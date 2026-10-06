<?php
/**
 * Verify Payment - Razorpay Checkout callback
 */

require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/mailer.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$orderId = $_POST['razorpay_order_id'] ?? '';
$paymentId = $_POST['razorpay_payment_id'] ?? '';
$signature = $_POST['razorpay_signature'] ?? '';

if ($orderId === '' || $paymentId === '' || $signature === '') {
    header('Location: failure.php?error=missing_data');
    exit;
}

if (!verifyRazorpaySignature($orderId, $paymentId, $signature)) {
    error_log("PSMUN: signature verification failed for order: {$orderId}");
    header('Location: failure.php?error=invalid_signature');
    exit;
}

$payment = getPaymentByOrderId($orderId);

if (!$payment) {
    error_log("PSMUN: payment record not found for order: {$orderId}");
    header('Location: failure.php?error=order_not_found');
    exit;
}

$paymentDetails = fetchPaymentDetails($paymentId);
$paydetailsJson = json_encode($paymentDetails ?: ['payment_id' => $paymentId]);

// Sends the confirmation email unless the webhook already completed this order
completePaymentAndNotify($orderId, $paymentId, $signature, $paydetailsJson);

initSession();
$_SESSION['psmun_last_order'] = $orderId;

header('Location: success.php');
exit;
