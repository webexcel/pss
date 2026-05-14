<?php
/**
 * Payment Failure Page
 */

require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/includes/functions.php';

initSession();

$error = $_GET['error'] ?? 'unknown';

$errorMessages = [
    'missing_data' => 'Payment data was incomplete. Please try again.',
    'invalid_signature' => 'Payment verification failed. If amount was deducted, it will be refunded automatically.',
    'order_not_found' => 'Payment order not found. Please try again.',
    'unauthorized' => 'Unauthorized payment attempt.',
    'cancelled' => 'Payment was cancelled.',
    'unknown' => 'An error occurred during payment. Please try again.'
];

$errorMessage = $errorMessages[$error] ?? $errorMessages['unknown'];

$pageTitle = 'Payment Failed';
require_once __DIR__ . '/templates/header.php';
?>

<div class="card failure-card">
    <div class="card-header failure-header">
        <div class="failure-icon-large">&#10008;</div>
        <h3>Payment Failed</h3>
    </div>

    <div class="card-body">
        <div class="error-message">
            <p><?= e($errorMessage) ?></p>
        </div>

        <div class="help-section">
            <h4>What should I do?</h4>
            <ul>
                <li>Check your internet connection and try again</li>
                <li>Make sure you have sufficient balance in your account</li>
                <li>Try using a different payment method</li>
                <li>If amount was deducted, it will be automatically refunded within 5-7 business days</li>
            </ul>
        </div>

        <div class="action-buttons">
            <?php if (isLoggedIn()): ?>
                <a href="fee-selection.php" class="btn btn-primary">Try Again</a>
            <?php else: ?>
                <a href="index.php" class="btn btn-primary">Login & Retry</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="card-footer">
        <p>Need help? Contact: <?= e(SUPPORT_EMAIL) ?> | <?= e(SUPPORT_PHONE) ?></p>
    </div>
</div>

<?php require_once __DIR__ . '/templates/footer.php'; ?>
