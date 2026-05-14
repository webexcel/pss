<?php
/**
 * Fee Selection Page
 */

require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/includes/functions.php';

// Require login
requireLogin();

$sessionData = getSessionData();
$paymentStatus = getPaymentStatus($sessionData['adno']);
$paymentOptions = getAvailablePaymentOptions($sessionData['adno']);

$pageTitle = 'Select Payment Option';
$includeRazorpay = true;
$scripts = ['assets/js/payment.js'];

initSession();
$csrfToken = generateCSRFToken();

require_once __DIR__ . '/templates/header.php';
?>

<div class="card fee-selection-card">
    <div class="card-header">
        <h3>Fee Payment</h3>
        <div class="student-info">
            <p><strong>Name:</strong> <?= e($sessionData['student_name']) ?></p>
            <p><strong>Class:</strong> <?= e($sessionData['class_section']) ?></p>
        </div>
    </div>

    <div class="card-body">
        <?php if ($paymentStatus['is_complete']): ?>
            <!-- All Payments Complete -->
            <div class="payment-complete">
                <div class="success-icon">&#10004;</div>
                <h4>All Fees Paid</h4>
                <p>Thank you! Your Integrated Course Fee has been fully paid.</p>

                <div class="action-buttons print-actions no-print">
                    <button onclick="window.print()" class="btn btn-primary">Print Receipt</button>
                </div>

                <!-- Printable Receipt Section -->
                <div class="printable-receipt">
                    <div class="receipt-header print-only">
                        <h2><?= e(SCHOOL_NAME) ?></h2>
                        <h3>Integrated Course Fee - Payment Receipt</h3>
                    </div>

                    <div class="receipt-student-info">
                        <table class="receipt-info-table">
                            <tr>
                                <td><strong>Student Name:</strong></td>
                                <td><?= e($sessionData['student_name']) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Admission No:</strong></td>
                                <td><?= e($sessionData['adno']) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Class:</strong></td>
                                <td><?= e($sessionData['class_section']) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Print Date:</strong></td>
                                <td><?= date('d M Y, h:i A') ?></td>
                            </tr>
                            <tr>
                                <td><strong>Discription</strong></td>
                                <td>Integrated Course Fee JEE / NEET</td>
                            </tr>
                        </table>
                    </div>

                    <div class="payment-history">
                        <h5>Payment Details</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Transaction ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $totalPaid = 0;
                                foreach ($paymentStatus['payments'] as $payment):
                                    $totalPaid += (int)$payment['amount'];
                                ?>
                                <tr>
                                    <td><?= e($payment['payment_type']) ?></td>
                                    <td><?= formatAmount((int)$payment['amount']) ?></td>
                                    <td><?= date('d M Y, h:i A', strtotime($payment['end_time'])) ?></td>
                                    <td><code><?= e($payment['payment_id']) ?></code></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr class="total-row">
                                    <td><strong>Total Paid</strong></td>
                                    <td><strong><?= formatAmount($totalPaid) ?></strong></td>
                                    <td colspan="2"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="receipt-footer print-only">
                        <p>This is a computer-generated receipt and does not require a signature.</p>
                        <p>For queries, contact: <?= e(SUPPORT_EMAIL) ?> | <?= e(SUPPORT_PHONE) ?></p>
                    </div>
                </div>
            </div>

        <?php elseif ($paymentStatus['has_inst1'] && !$paymentStatus['has_inst2']): ?>
            <!-- Partial Payment - Show pending amount -->
            <div class="partial-payment-notice no-print">
                <div class="info-icon">&#9432;</div>
                <p>You have paid Installment 1. Please complete your final installment below.</p>
            </div>

            <!-- Print Receipt for Installment 1 -->
            <div class="paid-installment-section">
                <div class="action-buttons print-actions no-print">
                    <button onclick="window.print()" class="btn btn-secondary btn-sm">Print Installment 1 Receipt</button>
                </div>

                <div class="printable-receipt">
                    <div class="receipt-header print-only">
                        <h2><?= e(SCHOOL_NAME) ?></h2>
                        <h3>Integrated Course Fee - Payment Receipt</h3>
                    </div>

                    <div class="receipt-student-info print-only">
                        <table class="receipt-info-table">
                            <tr>
                                <td><strong>Student Name:</strong></td>
                                <td><?= e($sessionData['student_name']) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Admission No:</strong></td>
                                <td><?= e($sessionData['adno']) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Class:</strong></td>
                                <td><?= e($sessionData['class_section']) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Print Date:</strong></td>
                                <td><?= date('d M Y, h:i A') ?></td>
                            </tr>
                        </table>
                    </div>

                    <div class="payment-history-mini no-print">
                        <p><strong>Installment 1 Paid:</strong>
                        <?php foreach ($paymentStatus['payments'] as $payment): ?>
                            <?php if ($payment['payment_type'] === 'INST1'): ?>
                                <?= formatAmount((int)$payment['amount']) ?> on <?= date('d M Y', strtotime($payment['end_time'])) ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        </p>
                    </div>

                    <div class="payment-history print-only">
                        <h5>Payment Details</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Transaction ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($paymentStatus['payments'] as $payment): ?>
                                <tr>
                                    <td><?= e($payment['payment_type']) ?></td>
                                    <td><?= formatAmount((int)$payment['amount']) ?></td>
                                    <td><?= date('d M Y, h:i A', strtotime($payment['end_time'])) ?></td>
                                    <td><code><?= e($payment['payment_id']) ?></code></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <p class="pending-note"><strong>Pending:</strong> Installment 2 - <?= formatAmount(FEE_INST2_DISPLAY) ?></p>
                    </div>

                    <div class="receipt-footer print-only">
                        <p>This is a computer-generated receipt and does not require a signature.</p>
                        <p>For queries, contact: <?= e(SUPPORT_EMAIL) ?> | <?= e(SUPPORT_PHONE) ?></p>
                    </div>
                </div>
            </div>

            <div class="payment-options no-print">
                <?php foreach ($paymentOptions as $option): ?>
                <div class="payment-option" data-type="<?= e($option['type']) ?>">
                    <div class="option-header">
                        <h4><?= e($option['label']) ?></h4>
                        <span class="amount"><?= formatAmount($option['amount']) ?></span>
                    </div>
                    <p class="option-description"><?= e($option['description']) ?></p>
                    <button
                        type="button"
                        class="btn btn-primary btn-pay"
                        data-type="<?= e($option['type']) ?>"
                        data-amount="<?= $option['amount_paise'] ?>"
                    >
                        Pay <?= formatAmount($option['amount']) ?>
                    </button>
                </div>
                <?php endforeach; ?>
            </div>

        <?php else: ?>
            <!-- Fresh - Show all options -->
            <div class="payment-options">
                <div class="options-header">
                    <h4>Choose Payment Option</h4>
                    <p>Select full payment for a discount of <?= formatAmount(FEE_INST1_DISPLAY + FEE_INST2_DISPLAY - FEE_FULL_DISPLAY) ?></p>
                </div>

                <?php foreach ($paymentOptions as $option): ?>
                <div class="payment-option <?= $option['type'] === 'FULL' ? 'recommended' : '' ?>" data-type="<?= e($option['type']) ?>">
                    <?php if ($option['type'] === 'FULL'): ?>
                    <div class="badge">Recommended</div>
                    <?php endif; ?>
                    <div class="option-header">
                        <h4><?= e($option['label']) ?></h4>
                        <span class="amount"><?= formatAmount($option['amount']) ?></span>
                    </div>
                    <p class="option-description"><?= e($option['description']) ?></p>
                    <?php if ($option['type'] === 'INST1'): ?>
                    <p class="installment-note">
                        <small>Total with installments: <?= formatAmount(FEE_INST1_DISPLAY + FEE_INST2_DISPLAY) ?></small>
                    </p>
                    <?php endif; ?>
                    <button
                        type="button"
                        class="btn <?= $option['type'] === 'FULL' ? 'btn-primary' : 'btn-secondary' ?> btn-pay"
                        data-type="<?= e($option['type']) ?>"
                        data-amount="<?= $option['amount_paise'] ?>"
                    >
                        Pay <?= formatAmount($option['amount']) ?>
                    </button>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="card-footer">
        <a href="logout.php" class="btn btn-link">Logout</a>
    </div>
</div>

<!-- Hidden data for JS -->
<script>
    window.paymentConfig = {
        razorpayKey: '<?= RAZORPAY_KEY_ID ?>',
        studentName: '<?= e($sessionData['student_name']) ?>',
        contact: '<?= e($sessionData['contact']) ?>',
        email: 'test@gmail.com',
        csrfToken: '<?= e($csrfToken) ?>',
        schoolName: '<?= e(SCHOOL_NAME) ?>'
    };
</script>

<?php require_once __DIR__ . '/templates/footer.php'; ?>
