<?php
/**
 * Admin - Send / resend confirmation email for a paid registration
 */

require_once dirname(__DIR__) . '/includes/admin.php';
require_once dirname(__DIR__) . '/includes/mailer.php';

requireAdmin();

$return = 'index.php' . (!empty($_POST['return']) ? '?' . $_POST['return'] : '');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verifyCSRFToken((string) ($_POST['csrf_token'] ?? ''))) {
    header('Location: index.php');
    exit;
}

$stmt = getDBConnection()->prepare("SELECT * FROM psmun_fee_payments WHERE id = ? AND status = 'COMPLETED'");
$stmt->execute([(int) ($_POST['id'] ?? 0)]);
$payment = $stmt->fetch();

if (!$payment) {
    $_SESSION['psmun_flash'] = ['type' => 'error', 'message' => 'Paid registration not found.'];
} elseif (sendConfirmationEmail($payment)) {
    $_SESSION['psmun_flash'] = ['type' => 'success', 'message' => "Confirmation email sent to {$payment['email']}."];
} else {
    $_SESSION['psmun_flash'] = ['type' => 'error', 'message' => getMailConfig()
        ? 'Email could not be sent. Check psmun/logs/error.log for details.'
        : 'Email is not set up yet. Create psmun/includes/mail-config.php from mail-config.sample.php.'];
}

// Only allow returning to this page with its own filters
header('Location: ' . preg_replace('/[\r\n]/', '', $return));
exit;
