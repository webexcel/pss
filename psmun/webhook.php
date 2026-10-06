<?php
/**
 * Razorpay Webhook Handler - Clarion PSMUN
 *
 * Add https://pssenior.edu.in/psmun/webhook.php as a webhook in the Razorpay
 * dashboard (events: payment.captured, payment.failed) using RAZORPAY_WEBHOOK_SECRET.
 * Orders that don't belong to PSMUN are ignored.
 */

require_once __DIR__ . '/includes/functions.php';

header('Content-Type: application/json');

$payload = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_RAZORPAY_SIGNATURE'] ?? '';

if ($signature === '' || !verifyWebhookSignature($payload, $signature)) {
    error_log('PSMUN webhook: signature verification failed');
    http_response_code(401);
    echo json_encode(['error' => 'Invalid signature']);
    exit;
}

$event = json_decode($payload, true);
$payment = $event['payload']['payment']['entity'] ?? null;
$orderId = $payment['order_id'] ?? '';

if ($payment && $orderId !== '') {
    $existing = getPaymentByOrderId($orderId);

    if ($existing && $existing['status'] !== 'COMPLETED') {
        if (($event['event'] ?? '') === 'payment.captured') {
            updatePaymentCompleted($orderId, $payment['id'] ?? '', '', json_encode($payment));
            error_log("PSMUN webhook: payment COMPLETED for order: {$orderId}");
        } elseif (($event['event'] ?? '') === 'payment.failed') {
            updatePaymentFailed($orderId, json_encode($payment));
            error_log("PSMUN webhook: payment FAILED for order: {$orderId}");
        }
    }
}

http_response_code(200);
echo json_encode(['status' => 'ok']);
