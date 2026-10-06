<?php
/**
 * Payment Failure Page
 */

require_once __DIR__ . '/includes/functions.php';

$errorMessages = [
    'missing_data' => 'Payment information was incomplete.',
    'invalid_signature' => 'Payment verification failed. If money was deducted, please contact the school office with your transaction details.',
    'order_not_found' => 'We could not find your registration. Please contact the school office.',
];

$errorMessage = $errorMessages[$_GET['error'] ?? ''] ?? 'Your payment could not be completed.';

$pageTitle = 'Payment Failed';
require_once __DIR__ . '/templates/header.php';
?>

<div class="card failure-card">
    <div class="card-header failure-header">
        <div class="failure-icon-large">&#10006;</div>
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
                <li>Try using a different payment method</li>
                <li>If amount was deducted, it will be automatically refunded within 5-7 business days</li>
            </ul>
        </div>

        <div class="action-buttons">
            <a href="index.php" class="btn btn-primary">Try Again</a>
        </div>
    </div>

    <div class="card-footer">
        <p>Need help? Contact: <?= e(SUPPORT_EMAIL) ?></p>
    </div>
</div>

<?php require_once __DIR__ . '/templates/footer.php'; ?>
