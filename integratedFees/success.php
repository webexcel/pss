<?php
/**
 * Payment Success Page
 */

require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/includes/functions.php';

initSession();

// Get payment info from session
$lastPayment = $_SESSION['last_payment'] ?? null;

// Clear sensitive session data but keep for display
$paymentInfo = $lastPayment;

// Destroy session after getting data
destroySession();

$pageTitle = 'Payment Successful';
require_once __DIR__ . '/templates/header.php';
?>

<div class="card success-card">
    <div class="card-header success-header">
        <div class="success-icon-large">&#10004;</div>
        <h3>Payment Successful!</h3>
    </div>

    <div class="card-body">
        <?php if ($paymentInfo): ?>
            <div class="receipt">
                <h4>Payment Receipt</h4>
                <table class="receipt-table">
                    <tr>
                        <td>Student Name</td>
                        <td><strong><?= e($paymentInfo['student_name']) ?></strong></td>
                    </tr>
                    <tr>
                        <td>Admission No.</td>
                        <td><?= e($paymentInfo['adno']) ?></td>
                    </tr>
                    <tr>
                        <td>Payment Type</td>
                        <td><?= e($paymentInfo['payment_type']) ?></td>
                    </tr>
                    <tr>
                        <td>Amount Paid</td>
                        <td><strong><?= formatAmount((int)$paymentInfo['amount']) ?></strong></td>
                    </tr>
                    <tr>
                        <td>Transaction ID</td>
                        <td><code><?= e($paymentInfo['payment_id']) ?></code></td>
                    </tr>
                    <tr>
                        <td>Order ID</td>
                        <td><code><?= e($paymentInfo['order_id']) ?></code></td>
                    </tr>
                    <tr>
                        <td>Date & Time</td>
                        <td><?= date('d M Y, h:i:s A') ?></td>
                    </tr>
                    <tr>
                        <td>Discription</td>
                        <td>Integrated Course Fee JEE / NEET</td>
                    </tr>
                </table>
            </div>

            <div class="receipt-note">
                <p><strong>Important:</strong> Please save this transaction ID for your records.</p>
                <p>A confirmation may be sent to your registered contact.</p>
            </div>

            <?php if ($paymentInfo['payment_type'] === 'INST1'): ?>
            <div class="pending-notice">
                <div class="info-icon">&#9432;</div>
                <p><strong>Reminder:</strong> You have paid Installment 1. Please remember to pay Installment 2 (<?= formatAmount(FEE_INST2_DISPLAY) ?>) to complete your fee payment.</p>
            </div>
            <?php endif; ?>

        <?php else: ?>
            <div class="generic-success">
                <p>Your payment has been processed successfully.</p>
                <p>If you don't see your payment details, please check your email or contact the school office.</p>
            </div>
        <?php endif; ?>

        <div class="action-buttons">
            <a href="index.php" class="btn btn-primary">Make Another Payment</a>
            <button onclick="window.print()" class="btn btn-secondary">Print Receipt</button>
        </div>
    </div>

    <div class="card-footer">
        <p>For any queries, contact: <?= e(SUPPORT_EMAIL) ?></p>
    </div>
</div>

<?php require_once __DIR__ . '/templates/footer.php'; ?>
