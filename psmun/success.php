<?php
/**
 * Payment Success Page - Receipt
 */

require_once __DIR__ . '/includes/functions.php';

initSession();

$orderId = $_SESSION['psmun_last_order'] ?? '';
$payment = $orderId !== '' ? getPaymentByOrderId($orderId) : null;
$delegates = $payment ? (json_decode($payment['delegates'], true) ?: []) : [];

$pageTitle = 'Payment Successful';
require_once __DIR__ . '/templates/header.php';
?>

<div class="card success-card">
    <div class="card-header success-header">
        <div class="success-icon-large">&#10004;</div>
        <h3>Payment Successful!</h3>
    </div>

    <div class="card-body">
        <?php if ($payment): ?>
            <div class="receipt">
                <h4>Payment Receipt</h4>
                <table class="receipt-table">
                    <tr>
                        <td>Event</td>
                        <td><strong><?= e(MUN_EVENT_NAME) ?></strong> (<?= e(MUN_EDITION) ?>)</td>
                    </tr>
                    <?php if ($payment['student_type'] === MUN_TYPE_INTERNAL): ?>
                    <tr>
                        <td>Student Name</td>
                        <td><strong><?= e($delegates[0]['name'] ?? $payment['contact_name']) ?></strong></td>
                    </tr>
                    <tr>
                        <td>Admission No.</td>
                        <td><?= e($payment['adno']) ?></td>
                    </tr>
                    <tr>
                        <td>Class</td>
                        <td><?= e($delegates[0]['class'] ?? '') ?></td>
                    </tr>
                    <?php else: ?>
                    <tr>
                        <td>School</td>
                        <td><strong><?= e($payment['school_name']) ?></strong><?= $payment['branch'] ? ', ' . e($payment['branch']) : '' ?></td>
                    </tr>
                    <tr>
                        <td>Contact Person</td>
                        <td><?= e($payment['contact_name']) ?></td>
                    </tr>
                    <tr>
                        <td>Delegates</td>
                        <td>
                            <ol class="receipt-delegates">
                                <?php foreach ($delegates as $delegate): ?>
                                <li><?= e($delegate['name']) ?> <span>(<?= e($delegate['class']) ?>)</span></li>
                                <?php endforeach; ?>
                            </ol>
                        </td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <td>Mobile / Email</td>
                        <td><?= e($payment['mobile']) ?> / <?= e($payment['email']) ?></td>
                    </tr>
                    <tr>
                        <td>Amount Paid</td>
                        <td>
                            <strong><?= formatAmount((float) $payment['amount']) ?></strong>
                            <?php if ((int) $payment['delegate_count'] > 1): ?>
                                <small>(<?= (int) $payment['delegate_count'] ?> &times; <?= formatAmount(MUN_FEE_PER_DELEGATE_DISPLAY) ?>)</small>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Transaction ID</td>
                        <td><code><?= e($payment['payment_id'] ?? '') ?></code></td>
                    </tr>
                    <tr>
                        <td>Order ID</td>
                        <td><code><?= e($payment['order_id']) ?></code></td>
                    </tr>
                    <tr>
                        <td>Date &amp; Time</td>
                        <td><?= e(date('d M Y, h:i A', strtotime($payment['end_time'] ?? 'now'))) ?></td>
                    </tr>
                </table>
            </div>

            <div class="receipt-note">
                <p><strong>Important:</strong> Please save or print this receipt for your records.</p>
            </div>
        <?php else: ?>
            <div class="generic-success">
                <p>Your payment has been processed successfully.</p>
                <p>If you don't see your payment details, please contact the school office.</p>
            </div>
        <?php endif; ?>

        <div class="action-buttons no-print">
            <a href="index.php" class="btn btn-primary">New Registration</a>
            <button onclick="window.print()" class="btn btn-secondary">Print Receipt</button>
        </div>
    </div>

    <div class="card-footer">
        <p>For any queries, contact: <?= e(SUPPORT_EMAIL) ?></p>
    </div>
</div>

<?php require_once __DIR__ . '/templates/footer.php'; ?>
