<?php
/**
 * Verify Payment - Callback Handler
 */

require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/razorpay.php';

// Check if logged in
if (!isLoggedIn()) {
    header('Location: index.php?msg=session_expired');
    exit;
}

// Only POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: fee-selection.php');
    exit;
}

$orderId = $_POST['razorpay_order_id'] ?? '';
$paymentId = $_POST['razorpay_payment_id'] ?? '';
$signature = $_POST['razorpay_signature'] ?? '';

// Validate inputs
if (empty($orderId) || empty($paymentId) || empty($signature)) {
    header('Location: failure.php?error=missing_data');
    exit;
}

// Verify signature
if (!verifyRazorpaySignature($orderId, $paymentId, $signature)) {
    error_log("Payment signature verification failed for order: {$orderId}");
    header('Location: failure.php?error=invalid_signature');
    exit;
}

// Get payment record
$payment = getPaymentByOrderId($orderId);

if (!$payment) {
    error_log("Payment record not found for order: {$orderId}");
    header('Location: failure.php?error=order_not_found');
    exit;
}

// Check if payment belongs to current session
$sessionData = getSessionData();
if ($payment['adno'] !== $sessionData['adno']) {
    error_log("Payment mismatch: order {$orderId} doesn't belong to {$sessionData['adno']}");
    header('Location: failure.php?error=unauthorized');
    exit;
}

// Fetch payment details from Razorpay for complete info
$paymentDetails = fetchPaymentDetails($paymentId);
$paydetailsJson = $paymentDetails ? json_encode($paymentDetails) : json_encode(['payment_id' => $paymentId]);

// Update payment as completed
$updated = updatePaymentCompleted($orderId, $paymentId, $signature, $paydetailsJson);

if (!$updated) {
    error_log("Failed to update payment record for order: {$orderId}");
    // Payment was successful but DB update failed - still show success
    // The webhook will retry the update
}

// Store payment info in session for success page
$_SESSION['last_payment'] = [
    'order_id' => $orderId,
    'payment_id' => $paymentId,
    'amount' => $payment['amount'],
    'payment_type' => $payment['payment_type'],
    'student_name' => $sessionData['student_name'],
    'adno' => $sessionData['adno']
];

// Redirect to success page
header('Location: success.php');
exit;
