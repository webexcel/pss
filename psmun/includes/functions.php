<?php
/**
 * Helper Functions - Clarion PSMUN Registration Fee
 */

require_once __DIR__ . '/config.php';
require_once dirname(__DIR__, 2) . '/integratedFees/includes/db.php';
require_once dirname(__DIR__, 2) . '/integratedFees/includes/razorpay.php';

/**
 * Start session (shared cookie with the rest of the site, keys are namespaced)
 */
function initSession(): void {
    if (session_status() === PHP_SESSION_NONE) {
        session_set_cookie_params([
            'path' => '/',
            'httponly' => true,
            'samesite' => 'Lax'
        ]);
        session_start();
    }
}

/**
 * Sanitize output
 */
function e(?string $string): string {
    return htmlspecialchars((string) $string, ENT_QUOTES, 'UTF-8');
}

/**
 * Format amount for display
 */
function formatAmount(float $amount): string {
    return '₹' . number_format($amount);
}

/**
 * Generate CSRF token
 */
function generateCSRFToken(): string {
    initSession();
    if (empty($_SESSION['psmun_csrf'])) {
        $_SESSION['psmun_csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['psmun_csrf'];
}

/**
 * Verify CSRF token
 */
function verifyCSRFToken(string $token): bool {
    initSession();
    return isset($_SESSION['psmun_csrf']) && hash_equals($_SESSION['psmun_csrf'], $token);
}

/**
 * Trim a value and cap its length
 */
function cleanText($value, int $maxLength = 150): string {
    $value = trim(preg_replace('/\s+/', ' ', (string) $value));
    return mb_substr($value, 0, $maxLength);
}

/**
 * Validate the submitted registration form.
 * Returns [errors, cleanData]. The amount is always calculated here, never taken from the browser.
 */
function validateRegistration(string $type, array $input): array {
    $errors = [];

    $data = [
        'student_type' => $type,
        'adno' => null,
        'school_name' => null,
        'branch' => null,
        'contact_name' => cleanText($input['contact_name'] ?? '', 100),
        'mobile' => preg_replace('/\D/', '', (string) ($input['mobile'] ?? '')),
        'email' => cleanText($input['email'] ?? '', 150),
        'delegates' => [],
    ];

    if ($type === MUN_TYPE_INTERNAL) {
        $name = cleanText($input['student_name'] ?? '', 100);
        $class = cleanText($input['class_section'] ?? '', 30);
        $data['adno'] = cleanText($input['adno'] ?? '', 50);

        if ($name === '') $errors[] = 'Student name is required.';
        if ($class === '') $errors[] = 'Class & section is required.';
        if ($data['adno'] === '') $errors[] = 'Admission number is required.';

        $data['delegates'][] = ['name' => $name, 'class' => $class];
        // Parent / student contact name defaults to the student
        if ($data['contact_name'] === '') $data['contact_name'] = $name;
    } else {
        $data['school_name'] = cleanText($input['school_name'] ?? '', 150);
        $data['branch'] = cleanText($input['branch'] ?? '', 100) ?: null;

        if ($data['school_name'] === '') $errors[] = 'School name is required.';
        if ($data['contact_name'] === '') $errors[] = 'Contact person name is required.';

        $delegates = is_array($input['delegates'] ?? null) ? $input['delegates'] : [];
        foreach ($delegates as $i => $delegate) {
            $name = cleanText($delegate['name'] ?? '', 100);
            $class = cleanText($delegate['class'] ?? '', 30);
            if ($name === '' && $class === '') continue; // skip empty rows
            if ($name === '' || $class === '') {
                $errors[] = 'Please enter both name and class for delegate ' . ($i + 1) . '.';
                continue;
            }
            $data['delegates'][] = ['name' => $name, 'class' => $class];
        }

        if (count($data['delegates']) === 0) {
            $errors[] = 'Please add at least one delegate.';
        } elseif (count($data['delegates']) > MUN_MAX_GROUP_SIZE) {
            $errors[] = 'A group booking can have at most ' . MUN_MAX_GROUP_SIZE . ' delegates.';
        }
    }

    if (!preg_match('/^[6-9]\d{9}$/', $data['mobile'])) {
        $errors[] = 'Please enter a valid 10-digit mobile number.';
    }
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }

    $data['delegate_count'] = count($data['delegates']);
    $data['amount'] = $data['delegate_count'] * MUN_FEE_PER_DELEGATE; // paise

    return [$errors, $data];
}

/**
 * Check whether one of our students has already paid
 */
function isInternalStudentRegistered(string $adno): bool {
    $pdo = getDBConnection();
    $stmt = $pdo->prepare("
        SELECT 1 FROM psmun_fee_payments
        WHERE student_type = 'INTERNAL' AND adno = ? AND status = 'COMPLETED'
        LIMIT 1
    ");
    $stmt->execute([$adno]);
    return (bool) $stmt->fetchColumn();
}

/**
 * Create payment record
 */
function createPaymentRecord(string $orderId, string $receipt, array $data): int {
    $pdo = getDBConnection();

    $stmt = $pdo->prepare("
        INSERT INTO psmun_fee_payments
            (order_id, receipt, student_type, adno, school_name, branch, contact_name, mobile, email,
             delegate_count, delegates, amount, status, start_time, paydetails)
        VALUES
            (:order_id, :receipt, :student_type, :adno, :school_name, :branch, :contact_name, :mobile, :email,
             :delegate_count, :delegates, :amount, 'START', NOW(), '{}')
    ");

    $stmt->execute([
        ':order_id' => $orderId,
        ':receipt' => $receipt,
        ':student_type' => $data['student_type'],
        ':adno' => $data['adno'],
        ':school_name' => $data['school_name'],
        ':branch' => $data['branch'],
        ':contact_name' => $data['contact_name'],
        ':mobile' => $data['mobile'],
        ':email' => $data['email'],
        ':delegate_count' => $data['delegate_count'],
        ':delegates' => json_encode($data['delegates'], JSON_UNESCAPED_UNICODE),
        ':amount' => $data['amount'] / 100, // store in rupees
    ]);

    return (int) $pdo->lastInsertId();
}

/**
 * Mark payment as completed
 */
function updatePaymentCompleted(string $orderId, string $paymentId, string $signature, string $paydetails): bool {
    $pdo = getDBConnection();
    $stmt = $pdo->prepare("
        UPDATE psmun_fee_payments
        SET status = 'COMPLETED', payment_id = ?, signature = ?, paydetails = ?, end_time = NOW()
        WHERE order_id = ? AND status IN ('START', 'FAILED')
    ");
    return $stmt->execute([$paymentId, $signature, $paydetails, $orderId]);
}

/**
 * Mark payment as failed
 */
function updatePaymentFailed(string $orderId, string $paydetails): bool {
    $pdo = getDBConnection();
    $stmt = $pdo->prepare("
        UPDATE psmun_fee_payments
        SET status = 'FAILED', paydetails = ?, end_time = NOW()
        WHERE order_id = ? AND status = 'START'
    ");
    return $stmt->execute([$paydetails, $orderId]);
}

/**
 * Get payment by order ID
 */
function getPaymentByOrderId(string $orderId): ?array {
    $pdo = getDBConnection();
    $stmt = $pdo->prepare("SELECT * FROM psmun_fee_payments WHERE order_id = ?");
    $stmt->execute([$orderId]);
    return $stmt->fetch() ?: null;
}
