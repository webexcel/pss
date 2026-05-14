<?php
/**
 * Razorpay Webhook Handler
 */

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/razorpay.php';

// Get raw payload
$payload = file_get_contents('php://input');

// Get signature header
$signature = $_SERVER['HTTP_X_RAZORPAY_SIGNATURE'] ?? '';

// Log all webhook requests
error_log("Webhook received: " . substr($payload, 0, 500));

// Verify signature
if (empty($signature) || !verifyWebhookSignature($payload, $signature)) {
    error_log("Webhook signature verification failed");
    http_response_code(401);
    echo json_encode(['error' => 'Invalid signature']);
    exit;
}

// Parse payload
$event = json_decode($payload, true);

if (!$event) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid payload']);
    exit;
}

$eventType = $event['event'] ?? '';
$paymentEntity = $event['payload']['payment']['entity'] ?? null;

// Handle payment events
switch ($eventType) {
    case 'payment.captured':
        if ($paymentEntity) {
            handlePaymentCaptured($paymentEntity, $payload);
        }
        break;

    case 'payment.failed':
        if ($paymentEntity) {
            handlePaymentFailed($paymentEntity, $payload);
        }
        break;

    case 'order.paid':
        // Additional confirmation - optional handling
        error_log("Order paid event received: " . ($event['payload']['order']['entity']['id'] ?? 'unknown'));
        break;

    default:
        error_log("Unhandled webhook event: {$eventType}");
}

// Always return 200 OK to acknowledge receipt
http_response_code(200);
echo json_encode(['status' => 'ok']);
exit;

/**
 * Handle payment.captured event
 */
function handlePaymentCaptured(array $payment, string $rawPayload): void {
    $orderId = $payment['order_id'] ?? '';
    $paymentId = $payment['id'] ?? '';

    if (empty($orderId) || empty($paymentId)) {
        error_log("Missing order_id or payment_id in captured event");
        return;
    }

    // Check if already processed
    $existingPayment = getPaymentByOrderId($orderId);

    if (!$existingPayment) {
        error_log("Payment record not found for webhook order: {$orderId}");
        return;
    }

    if ($existingPayment['status'] === 'COMPLETED') {
        error_log("Payment already marked as COMPLETED: {$orderId}");
        return;
    }

    // Update payment
    $updated = updatePaymentCompleted(
        $orderId,
        $paymentId,
        '', // Signature not available in webhook
        json_encode($payment)
    );

    if ($updated) {
        error_log("Webhook: Payment marked as COMPLETED for order: {$orderId}");
    } else {
        error_log("Webhook: Failed to update payment for order: {$orderId}");
    }
}

/**
 * Handle payment.failed event
 */
function handlePaymentFailed(array $payment, string $rawPayload): void {
    $orderId = $payment['order_id'] ?? '';

    if (empty($orderId)) {
        error_log("Missing order_id in failed event");
        return;
    }

    // Check if exists and not already completed
    $existingPayment = getPaymentByOrderId($orderId);

    if (!$existingPayment) {
        error_log("Payment record not found for failed webhook: {$orderId}");
        return;
    }

    if ($existingPayment['status'] === 'COMPLETED') {
        error_log("Cannot mark COMPLETED payment as failed: {$orderId}");
        return;
    }

    // Update payment as failed
    $updated = updatePaymentFailed($orderId, json_encode($payment));

    if ($updated) {
        error_log("Webhook: Payment marked as FAILED for order: {$orderId}");
    }
}
