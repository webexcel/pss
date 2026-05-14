<?php
/**
 * Create Razorpay Order - AJAX Endpoint
 */

header('Content-Type: application/json');

require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/razorpay.php';

// Check if logged in
if (!isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['error' => 'Session expired. Please login again.']);
    exit;
}

// Only POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

// Verify CSRF token
if (!isset($input['csrf_token']) || !verifyCSRFToken($input['csrf_token'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Invalid request']);
    exit;
}

$paymentType = $input['payment_type'] ?? '';
$sessionData = getSessionData();

// Validate payment type
if (!in_array($paymentType, ['FULL', 'INST1', 'INST2'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid payment type']);
    exit;
}

// Check if this payment type is valid for the student
if (!isValidPaymentType($sessionData['adno'], $paymentType)) {
    http_response_code(400);
    echo json_encode(['error' => 'This payment option is not available']);
    exit;
}

// Get amount (server-side - never trust client)
$amount = getAmountForType($paymentType);

if ($amount <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid amount']);
    exit;
}

// Generate receipt ID
$receipt = 'ICFEE-' . $sessionData['adno'] . '-' . $paymentType . '-' . time();

// Create Razorpay order
$order = createRazorpayOrder($amount, $receipt, [
    'adno' => $sessionData['adno'],
    'student_name' => $sessionData['student_name'],
    'payment_type' => $paymentType
]);

if (!$order) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to create payment order. Please try again.']);
    exit;
}

// Save order to database
try {
    createPaymentRecord([
        'order_id' => $order['id'],
        'adno' => $sessionData['adno'],
        'mobile' => $sessionData['contact'],
        'amount' => $amount,
        'year_id' => $sessionData['year_id'],
        'remarks' => getRemarksForType($paymentType),
        'payment_type' => $paymentType
    ]);
} catch (Exception $e) {
    error_log("Failed to save payment record: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Failed to initiate payment. Please try again.']);
    exit;
}

// Return order details to frontend
echo json_encode([
    'success' => true,
    'order_id' => $order['id'],
    'amount' => $amount,
    'currency' => 'INR',
    'receipt' => $receipt
]);
