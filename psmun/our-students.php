<?php
/**
 * Registration Form - P.S. Senior students (admission number only)
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
        <p>Enter your admission number to pay the registration fee of <?= formatAmount(MUN_FEE_PER_DELEGATE_DISPLAY) ?>.</p>
    </div>

    <div class="card-body">
        <form id="psmun-form" class="mun-form" data-type="<?= MUN_TYPE_INTERNAL ?>" novalidate>
            <div class="form-group">
                <label for="adno">Admission Number *</label>
                <div class="lookup-row">
                    <input type="text" id="adno" name="adno" maxlength="50" required autocomplete="off" autofocus>
                    <button type="button" id="lookup-button" class="btn btn-secondary">Find</button>
                </div>
            </div>

            <div id="student-details" class="student-details" hidden>
                <table class="receipt-table">
                    <tr><td>Name</td><td><strong id="student-name"></strong></td></tr>
                    <tr><td>Class</td><td id="student-class"></td></tr>
                    <tr id="student-mobile-row"><td>Registered Mobile</td><td id="student-mobile"></td></tr>
                </table>
                <p class="details-note">Not your details? Change the admission number and press Find again.</p>

                <div id="already-paid" class="alert alert-success" hidden>This student has already paid the registration fee.</div>

                <div id="pay-section">
                    <div class="total-box">
                        <span>Amount Payable</span>
                        <strong><?= formatAmount(MUN_FEE_PER_DELEGATE_DISPLAY) ?></strong>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Pay <?= formatAmount(MUN_FEE_PER_DELEGATE_DISPLAY) ?></button>
                    <p class="details-note">Enter your email in the payment window to receive the confirmation.</p>
                </div>
            </div>
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
