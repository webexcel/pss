<?php
/**
 * Helper Functions
 */

require_once __DIR__ . '/db.php';

/**
 * Validate student by admission number
 */
function validateStudent(string $adno): ?array {
    $pdo = getDBConnection();

    $stmt = $pdo->prepare("
        SELECT `adno` as `ADMISSION_ID`, `name` as `NAME`, `class` as CLASSSEC, contact, Year_Id
        FROM v_course
        WHERE `adno` = ?
        LIMIT 1
    ");

    $stmt->execute([trim($adno)]);
    $student = $stmt->fetch();

    return $student ?: null;
}

/**
 * Get payment status for a student
 */
function getPaymentStatus(string $adno): array {
    $pdo = getDBConnection();

    $stmt = $pdo->prepare("
        SELECT payment_type, amount, status, end_time, payment_id
        FROM integrated_fee_payments
        WHERE adno = ? AND status = 'COMPLETED'
        ORDER BY payment_type
    ");

    $stmt->execute([$adno]);
    $payments = $stmt->fetchAll();

    $result = [
        'has_full' => false,
        'has_inst1' => false,
        'has_inst2' => false,
        'is_complete' => false,
        'payments' => $payments
    ];

    foreach ($payments as $payment) {
        if ($payment['payment_type'] === 'FULL') {
            $result['has_full'] = true;
            $result['is_complete'] = true;
        } elseif ($payment['payment_type'] === 'INST1') {
            $result['has_inst1'] = true;
        } elseif ($payment['payment_type'] === 'INST2') {
            $result['has_inst2'] = true;
        }
    }

    if ($result['has_inst1'] && $result['has_inst2']) {
        $result['is_complete'] = true;
    }

    return $result;
}

/**
 * Get available payment options for student
 */
function getAvailablePaymentOptions(string $adno): array {
    $status = getPaymentStatus($adno);
    $options = [];

    if ($status['is_complete']) {
        return []; // No options - already paid
    }

    if (!$status['has_full'] && !$status['has_inst1']) {
        // Fresh student - show both options
        $options[] = [
            'type' => 'FULL',
            'label' => 'Full Payment',
            'amount' => FEE_FULL_DISPLAY,
            'amount_paise' => FEE_FULL,
            'description' => 'Pay complete fee in one payment'
        ];
        $options[] = [
            'type' => 'INST1',
            'label' => 'Installment 1 of 2',
            'amount' => FEE_INST1_DISPLAY,
            'amount_paise' => FEE_INST1,
            'description' => 'First installment payment'
        ];
    } elseif ($status['has_inst1'] && !$status['has_inst2']) {
        // Paid inst1, pending inst2
        $options[] = [
            'type' => 'INST2',
            'label' => 'Installment 2 of 2 (Final)',
            'amount' => FEE_INST2_DISPLAY,
            'amount_paise' => FEE_INST2,
            'description' => 'Final installment payment'
        ];
    }

    return $options;
}

/**
 * Check if payment type is valid for student
 */
function isValidPaymentType(string $adno, string $paymentType): bool {
    $options = getAvailablePaymentOptions($adno);

    foreach ($options as $option) {
        if ($option['type'] === $paymentType) {
            return true;
        }
    }

    return false;
}

/**
 * Get amount for payment type (in paise)
 */
function getAmountForType(string $paymentType): int {
    return match ($paymentType) {
        'FULL' => FEE_FULL,
        'INST1' => FEE_INST1,
        'INST2' => FEE_INST2,
        default => 0
    };
}

/**
 * Get remarks for payment type
 */
function getRemarksForType(string $paymentType): string {
    return match ($paymentType) {
        'FULL' => 'Full Payment - Integrated Course Fee',
        'INST1' => 'Installment 1 of 2 - Integrated Course Fee',
        'INST2' => 'Installment 2 of 2 (Final) - Integrated Course Fee',
        default => 'Integrated Course Fee'
    };
}

/**
 * Create payment record
 */
function createPaymentRecord(array $data): int {
    $pdo = getDBConnection();

    $sql = "INSERT INTO integrated_fee_payments
        (order_id, adno, mobile, amount, status, Year_Id, start_time, remarks, paydetails, payment_type, fee_description)
        VALUES (:order_id, :adno, :mobile, :amount, 'START', :year_id, NOW(), :remarks, '{}', :payment_type, 'Integrated Course Fee JEE / NEET')";

    $stmt = $pdo->prepare($sql);

    $params = [
        ':order_id' => $data['order_id'],
        ':adno' => $data['adno'],
        ':mobile' => $data['mobile'],
        ':amount' => $data['amount'] / 100, // Store in rupees
        ':year_id' => $data['year_id'],
        ':remarks' => $data['remarks'],
        ':payment_type' => $data['payment_type']
    ];

    $result = $stmt->execute($params);

    if (!$result) {
        $errorInfo = $stmt->errorInfo();
        error_log("DB Insert failed: " . json_encode($errorInfo));
        throw new Exception("Failed to save payment record: " . $errorInfo[2]);
    }

    $insertId = (int) $pdo->lastInsertId();

    if ($insertId === 0) {
        error_log("DB Insert returned 0 lastInsertId for order: " . $data['order_id']);
        throw new Exception("Payment record was not created");
    }

    error_log("Payment record created: ID={$insertId}, Order={$data['order_id']}, Adno={$data['adno']}");

    return $insertId;
}

/**
 * Update payment as completed
 */
function updatePaymentCompleted(string $orderId, string $paymentId, string $signature, string $paydetails): bool {
    $pdo = getDBConnection();

    $stmt = $pdo->prepare("
        UPDATE integrated_fee_payments
        SET status = 'COMPLETED',
            payment_id = ?,
            signature = ?,
            paydetails = ?,
            end_time = NOW()
        WHERE order_id = ? AND status = 'START'
    ");

    return $stmt->execute([$paymentId, $signature, $paydetails, $orderId]);
    
}

/**
 * Update payment as failed
 */
function updatePaymentFailed(string $orderId, string $paydetails): bool {
    $pdo = getDBConnection();

    $stmt = $pdo->prepare("
        UPDATE integrated_fee_payments
        SET status = 'FAILED',
            paydetails = ?,
            end_time = NOW()
        WHERE order_id = ? AND status = 'START'
    ");

    return $stmt->execute([$paydetails, $orderId]);
}

/**
 * Get payment by order ID
 */
function getPaymentByOrderId(string $orderId): ?array {
    $pdo = getDBConnection();

    $stmt = $pdo->prepare("
        SELECT * FROM integrated_fee_payments WHERE order_id = ?
    ");

    $stmt->execute([$orderId]);
    return $stmt->fetch() ?: null;
}

/**
 * Format amount for display
 */
function formatAmount(int $amount): string {
    return '₹' . number_format($amount);
}

/**
 * Sanitize output
 */
function e(string $string): string {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Generate CSRF token
 */
function generateCSRFToken(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verify CSRF token
 */
function verifyCSRFToken(string $token): bool {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
