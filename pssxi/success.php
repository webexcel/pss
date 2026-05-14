<?php
/**
 * Success Page - Displayed after successful submission
 */

$pageTitle = 'Application Submitted';
$currentStep = 3;

require_once __DIR__ . '/includes/header.php';

$applicationId = $_GET['id'] ?? $_SESSION['application_id'] ?? null;

// Clear ALL session data after successful submission
session_unset();
session_destroy();
?>

<main class="flex-1 flex flex-col items-center justify-center py-12 px-4">
    <div class="w-full max-w-lg text-center">

        <!-- Success Icon -->
        <div class="w-24 h-24 bg-green-100 dark:bg-green-900/30 rounded-full mx-auto mb-8 flex items-center justify-center">
            <span class="material-symbols-outlined text-5xl text-green-600 dark:text-green-400">check_circle</span>
        </div>

        <!-- Success Message -->
        <h1 class="text-3xl md:text-4xl font-black tracking-tight text-slate-900 dark:text-white mb-4">
            Application Submitted!
        </h1>
        <p class="text-slate-500 dark:text-slate-400 text-lg mb-8">
            Thank you for submitting your admission application. We have received your application and it is currently under review.
        </p>

        <?php if ($applicationId): ?>
        <!-- Application ID Card -->
        <div class="bg-primary/5 border border-primary/20 rounded-xl p-6 mb-8">
            <p class="text-sm text-slate-500 dark:text-slate-400 mb-2">Your Application ID</p>
            <p class="text-2xl font-bold text-primary"><?= e($applicationId) ?></p>
            <p class="text-xs text-slate-400 mt-2">Please save this ID for future reference</p>
        </div>
        <?php endif; ?>

        <!-- Next Steps -->
        <div class="bg-amber-50 dark:bg-amber-900/20 border-l-4 border-amber-500 rounded-r-lg p-4 text-left mb-8">
            <h3 class="font-bold text-amber-800 dark:text-amber-200 mb-2">What's Next?</h3>
            <ul class="text-sm text-amber-700 dark:text-amber-300 space-y-1 list-disc list-inside">
                <!-- <li>A confirmation email has been sent to your registered email address</li> -->
                <li>Our admissions team will review your application</li>
                <li>You may be contacted for additional documents or an interview</li>
            </ul>
        </div>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <?php if ($applicationId): ?>
            <a href="download-pdf.php?id=<?= htmlspecialchars($applicationId, ENT_QUOTES, 'UTF-8') ?>"
               class="px-6 py-3 rounded-lg bg-green-600 text-white font-medium hover:bg-green-700 transition-colors flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-lg">download</span>
                Download Application PDF
            </a>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
