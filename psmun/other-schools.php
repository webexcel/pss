<?php
/**
 * Registration Form - Other school students (single or group booking)
 */

require_once __DIR__ . '/includes/functions.php';

$csrfToken = generateCSRFToken();

$pageTitle = 'Other School Students';
$includeRazorpay = true;
$scripts = ['assets/js/psmun.js'];
require_once __DIR__ . '/templates/header.php';
?>

<div class="card">
    <div class="card-header">
        <h3>Other School Students</h3>
        <p><?= formatAmount(MUN_FEE_PER_DELEGATE_DISPLAY) ?> per student. Add all students from your school to pay once for the group.</p>
    </div>

    <div class="card-body">
        <form id="psmun-form" class="mun-form" data-type="<?= MUN_TYPE_EXTERNAL ?>" novalidate>
            <h4 class="form-section-title">School Details</h4>

            <div class="form-group">
                <label for="school_name">School Name *</label>
                <input type="text" id="school_name" name="school_name" maxlength="150" required>
            </div>

            <div class="form-group">
                <label for="branch">Branch <span class="optional">(if any)</span></label>
                <input type="text" id="branch" name="branch" maxlength="100" placeholder="e.g., Mylapore">
            </div>

            <h4 class="form-section-title">Contact Person</h4>

            <div class="form-group">
                <label for="contact_name">Name (Student) *</label>
                <input type="text" id="contact_name" name="contact_name" maxlength="100" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="mobile">Mobile No. *</label>
                    <input type="tel" id="mobile" name="mobile" maxlength="10" inputmode="numeric" pattern="[6-9][0-9]{9}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" maxlength="150" required>
                </div>
            </div>

            <h4 class="form-section-title">Student</h4>

            <div id="delegate-list" class="delegate-list" data-max="<?= MUN_MAX_GROUP_SIZE ?>"></div>

            <button type="button" id="add-delegate" class="btn btn-secondary btn-block btn-sm">+ Add Student</button>

            <div class="total-box">
                <span>
                    <span id="delegate-count">1</span> &times; <?= formatAmount(MUN_FEE_PER_DELEGATE_DISPLAY) ?>
                </span>
                <strong id="total-amount"><?= formatAmount(MUN_FEE_PER_DELEGATE_DISPLAY) ?></strong>
            </div>

            <button type="submit" class="btn btn-primary btn-block" id="pay-button">Pay <?= formatAmount(MUN_FEE_PER_DELEGATE_DISPLAY) ?></button>
        </form>
    </div>

    <div class="card-footer">
        <p><a href="index.php" class="back-link">&larr; Back</a> &nbsp;|&nbsp; Secure payment powered by Razorpay</p>
    </div>
</div>

<template id="delegate-row-template">
    <div class="delegate-row">
        <span class="delegate-no"></span>
        <input type="text" class="delegate-name" placeholder="Student name" maxlength="100" required>
        <input type="text" class="delegate-class" placeholder="Class" maxlength="30" required>
        <button type="button" class="delegate-remove" title="Remove" aria-label="Remove delegate">&times;</button>
    </div>
</template>

<script>
    window.psmunConfig = {
        razorpayKey: <?= json_encode(RAZORPAY_KEY_ID) ?>,
        csrfToken: <?= json_encode($csrfToken) ?>,
        eventName: <?= json_encode(MUN_EVENT_NAME) ?>,
        feePerDelegate: <?= MUN_FEE_PER_DELEGATE_DISPLAY ?>
    };
</script>

<?php require_once __DIR__ . '/templates/footer.php'; ?>
