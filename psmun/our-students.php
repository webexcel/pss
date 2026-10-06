<?php
/**
 * Registration Form - P.S. Senior students
 */

require_once __DIR__ . '/includes/functions.php';

$csrfToken = generateCSRFToken();

$pageTitle = 'Our School Students';
$includeRazorpay = true;
$scripts = ['assets/js/psmun.js'];
require_once __DIR__ . '/templates/header.php';
?>

<div class="card">
    <div class="card-header">
        <h3>P.S. Senior Students</h3>
        <p>Fill in the details and pay the registration fee of <?= formatAmount(MUN_FEE_PER_DELEGATE_DISPLAY) ?>.</p>
    </div>

    <div class="card-body">
        <form id="psmun-form" class="mun-form" data-type="<?= MUN_TYPE_INTERNAL ?>" novalidate>
            <div class="form-group">
                <label for="student_name">Student Name *</label>
                <input type="text" id="student_name" name="student_name" maxlength="100" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="adno">Admission No. *</label>
                    <input type="text" id="adno" name="adno" maxlength="50" required autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="class_section">Class &amp; Section *</label>
                    <input type="text" id="class_section" name="class_section" maxlength="30" placeholder="e.g., IX-B" required>
                </div>
            </div>

            <div class="form-group">
                <label for="mobile">Parent Mobile No. *</label>
                <input type="tel" id="mobile" name="mobile" maxlength="10" inputmode="numeric" pattern="[6-9][0-9]{9}" required>
            </div>

            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" maxlength="150" required>
            </div>

            <div class="total-box">
                <span>Amount Payable</span>
                <strong><?= formatAmount(MUN_FEE_PER_DELEGATE_DISPLAY) ?></strong>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Pay <?= formatAmount(MUN_FEE_PER_DELEGATE_DISPLAY) ?></button>
        </form>
    </div>

    <div class="card-footer">
        <p><a href="index.php" class="back-link">&larr; Back</a> &nbsp;|&nbsp; Secure payment powered by Razorpay</p>
    </div>
</div>

<script>
    window.psmunConfig = {
        razorpayKey: <?= json_encode(RAZORPAY_KEY_ID) ?>,
        csrfToken: <?= json_encode($csrfToken) ?>,
        eventName: <?= json_encode(MUN_EVENT_NAME) ?>,
        feePerDelegate: <?= MUN_FEE_PER_DELEGATE_DISPLAY ?>
    };
</script>

<?php require_once __DIR__ . '/templates/footer.php'; ?>
