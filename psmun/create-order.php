<?php
/**
 * Create Razorpay Order - AJAX Endpoint
 */

header('Content-Type: application/json');

require_once __DIR__ . '/includes/functions.php';

function jsonError(int $code, string $message): void {
    http_response_code($code);
    echo json_encode(['error' => $message]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonError(405, 'Method not allowed');
}

$input = json_decode(file_get_contents('php://input'), true);

if (!is_array($input) || !isset($input['csrf_token']) || !verifyCSRFToken((string) $input['csrf_token'])) {
    jsonError(403, 'Your session has expired. Please refresh the page and try again.');
}

$type = $input['student_type'] ?? '';
if (!in_array($type, [MUN_TYPE_INTERNAL, MUN_TYPE_EXTERNAL], true)) {
    jsonError(400, 'Invalid registration type');
}

[$errors, $data] = validateRegistration($type, $input);

if ($errors) {
    jsonError(400, implode(' ', $errors));
}

if ($type === MUN_TYPE_INTERNAL && isInternalStudentRegistered($data['adno'])) {
    jsonError(400, 'Admission No. ' . $data['adno'] . ' has already paid the registration fee.');
}

// Amount is calculated on the server (count x ₹900)
$amount = $data['amount'];

$receipt = 'PSMUN-' . ($type === MUN_TYPE_INTERNAL ? 'I' : 'E') . '-' . time() . '-' . bin2hex(random_bytes(3));

$description = $type === MUN_TYPE_INTERNAL
    ? MUN_EVENT_NAME . ' Registration'
    : MUN_EVENT_NAME . ' Registration - ' . $data['delegate_count'] . ' delegate(s)';

$order = createRazorpayOrder($amount, $receipt, [
    'event' => MUN_EVENT_NAME,
    'student_type' => $type,
    'name' => $data['contact_name'],
    'adno' => (string) $data['adno'],
    'school' => mb_substr((string) $data['school_name'], 0, 250),
    'branch' => (string) $data['branch'],
    'delegates' => (string) $data['delegate_count'],
]);

if (!$order) {
    jsonError(500, 'Failed to create payment order. Please try again.');
}

try {
    createPaymentRecord($order['id'], $receipt, $data);
} catch (Exception $e) {
    error_log('PSMUN: failed to save payment record: ' . $e->getMessage());
    jsonError(500, 'Failed to initiate payment. Please try again.');
}

echo json_encode([
    'success' => true,
    'order_id' => $order['id'],
    'amount' => $amount,
    'currency' => 'INR',
    'description' => $description,
    'prefill' => [
        'name' => $data['contact_name'],
        'email' => $data['email'],
        'contact' => $data['mobile'],
    ],
]);
