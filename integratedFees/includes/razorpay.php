<?php
/**
 * Razorpay Integration Helper
 */

require_once __DIR__ . '/config.php';

/**
 * Create Razorpay Order
 */
function createRazorpayOrder(int $amount, string $receipt, array $notes = []): ?array {
    $url = 'https://api.razorpay.com/v1/orders';

    $orderData = [
        'amount' => $amount,
        'currency' => 'INR',
        'receipt' => $receipt,
        'notes' => $notes
    ];

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($orderData),
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json'
        ],
        CURLOPT_USERPWD => RAZORPAY_KEY_ID . ':' . RAZORPAY_KEY_SECRET,
        CURLOPT_TIMEOUT => 30
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        error_log("Razorpay order creation error: " . $error);
        return null;
    }

    $result = json_decode($response, true);

    if ($httpCode !== 200 || !isset($result['id'])) {
        error_log("Razorpay order creation failed: " . $response);
        return null;
    }

    return $result;
}

/**
 * Verify Razorpay Payment Signature
 */
function verifyRazorpaySignature(string $orderId, string $paymentId, string $signature): bool {
    $expectedSignature = hash_hmac(
        'sha256',
        $orderId . '|' . $paymentId,
        RAZORPAY_KEY_SECRET
    );

    return hash_equals($expectedSignature, $signature);
}

/**
 * Verify Razorpay Webhook Signature
 */
function verifyWebhookSignature(string $payload, string $signature): bool {
    $expectedSignature = hash_hmac(
        'sha256',
        $payload,
        RAZORPAY_WEBHOOK_SECRET
    );

    return hash_equals($expectedSignature, $signature);
}

/**
 * Fetch Payment Details from Razorpay
 */
function fetchPaymentDetails(string $paymentId): ?array {
    $url = "https://api.razorpay.com/v1/payments/{$paymentId}";

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_USERPWD => RAZORPAY_KEY_ID . ':' . RAZORPAY_KEY_SECRET,
        CURLOPT_TIMEOUT => 30
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200) {
        return null;
    }

    return json_decode($response, true);
}
