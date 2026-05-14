<?php
/**
 * Login Page - Admission Number Entry
 */

require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/includes/functions.php';

// If already logged in, redirect to fee selection
if (isLoggedIn()) {
    header('Location: fee-selection.php');
    exit;
}

$error = '';
$message = '';

// Handle session expired message
if (isset($_GET['msg']) && $_GET['msg'] === 'session_expired') {
    $message = 'Your session has expired. Please login again.';
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $adno = trim($_POST['adno'] ?? '');

    if (empty($adno)) {
        $error = 'Please enter your Admission Number.';
    } else {
        $student = validateStudent($adno);

        if ($student) {
            createSession($student);
            header('Location: fee-selection.php');
            exit;
        } else {
            $error = 'Invalid Admission Number. Please check and try again.';
        }
    }
}

initSession();
$pageTitle = 'Login';
require_once __DIR__ . '/templates/header.php';
?>

<div class="card login-card">
    <div class="card-header">
        <h3>Student Login</h3>
        <p>Enter your Admission Number to proceed with Integrated Course fee payment</p>
    </div>

    <div class="card-body">
        <?php if ($error): ?>
            <div class="alert alert-error">
                <?= e($error) ?>
            </div>
        <?php endif; ?>

        <?php if ($message): ?>
            <div class="alert alert-info">
                <?= e($message) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="" class="login-form">
            <div class="form-group">
                <label for="adno">Admission Number</label>
                <input
                    type="text"
                    id="adno"
                    name="adno"
                    placeholder="e.g., PS2024001"
                    value="<?= e($_POST['adno'] ?? '') ?>"
                    required
                    autofocus
                    autocomplete="off"
                >
            </div>

            <button type="submit" class="btn btn-primary btn-block">
                Continue to Payment
            </button>
        </form>

        <div class="fee-info">
            <h4>Fee Structure</h4>
            <ul>
                <li>
                    <span>Full Payment</span>
                    <strong><?= formatAmount(FEE_FULL_DISPLAY) ?></strong>
                </li>
                <li>
                    <span>1st Installment</span>
                    <strong><?= formatAmount(FEE_INST1_DISPLAY) ?></strong>
                </li>
                <li>
                    <span>2nd Installment</span>
                    <strong><?= formatAmount(FEE_INST2_DISPLAY) ?></strong>
                </li>
            </ul>
            <p style="font-size: 0.75rem; color: var(--success-600); margin-top: 12px; text-align: center;">
                Save <?= formatAmount(FEE_INST1_DISPLAY + FEE_INST2_DISPLAY - FEE_FULL_DISPLAY) ?> with full payment!
            </p>
        </div>
    </div>

    <div class="card-footer">
        <p style="font-size: 0.8rem; color: var(--text-secondary);">
            Secure payment powered by Razorpay
        </p>
    </div>
</div>

<?php require_once __DIR__ . '/templates/footer.php'; ?>
