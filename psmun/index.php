<?php
/**
 * Clarion PSMUN Registration - Choose student type
 */

require_once __DIR__ . '/includes/functions.php';

$pageTitle = 'Registration';
require_once __DIR__ . '/templates/header.php';
?>

<div class="card">
    <div class="card-header">
        <h3>Delegate Registration</h3>
        <p>Registration fee: <strong><?= formatAmount(MUN_FEE_PER_DELEGATE_DISPLAY) ?></strong> per delegate</p>
    </div>

    <div class="card-body">
        <div class="type-choices">
            <a href="our-students.php" class="type-choice">
                <h4>P.S. Senior Students</h4>
                <p>For students of our school. Keep your admission number ready.</p>
                <span class="type-choice-amount"><?= formatAmount(MUN_FEE_PER_DELEGATE_DISPLAY) ?></span>
            </a>

            <a href="other-schools.php" class="type-choice">
                <h4>Other School Students</h4>
                <p>Register one delegate or a whole group in a single payment.</p>
                <span class="type-choice-amount"><?= formatAmount(MUN_FEE_PER_DELEGATE_DISPLAY) ?> &times; delegates</span>
            </a>
        </div>
    </div>

    <div class="card-footer">
        <p style="font-size: 0.8rem; color: var(--text-secondary);">Secure payment powered by Razorpay</p>
    </div>
</div>

<?php require_once __DIR__ . '/templates/footer.php'; ?>
