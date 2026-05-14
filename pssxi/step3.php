<?php
/**
 * Step 3: Review & Submit
 */

// Suppress errors in production
error_reporting(E_ALL);
ini_set('display_errors', '0');

$pageTitle = 'Review & Submit';
$currentStep = 3;

require_once __DIR__ . '/includes/header.php';

// Check if session exists
if (empty($_SESSION['app_token'])) {
    header('Location: step1.php');
    exit;
}

// Get all saved data
$studentData = $_SESSION['step1_data'] ?? [];
$parentData = $_SESSION['step2_data'] ?? [];
$fatherData = $parentData['father'] ?? [];
$motherData = $parentData['mother'] ?? [];

// Get qualification labels
$qualificationOptions = getQualificationOptions();
?>

<main class="flex-1 flex flex-col items-center py-8 px-4 sm:px-10 lg:px-40">
    <div class="w-full max-w-[960px] flex flex-col gap-6">

        <!-- Breadcrumbs -->
        <nav class="flex flex-wrap gap-2 text-sm">
            <a class="text-slate-500 dark:text-slate-400 font-medium hover:underline" href="step1.php">Home</a>
            <span class="text-slate-500 dark:text-slate-400 font-medium">/</span>
            <a class="text-slate-500 dark:text-slate-400 font-medium hover:underline" href="step1.php">Admissions</a>
            <span class="text-slate-500 dark:text-slate-400 font-medium">/</span>
            <span class="text-primary font-medium">Review Application</span>
        </nav>

        <!-- Page Heading & Progress -->
        <div class="flex flex-col md:flex-row justify-between gap-6 items-start md:items-end pb-4 border-b border-slate-200 dark:border-slate-700">
            <div class="flex flex-col gap-2 max-w-xl">
                <h1 class="text-3xl md:text-4xl font-black leading-tight tracking-tight">Review your Application</h1>
                <p class="text-slate-500 dark:text-slate-400 text-base font-normal leading-normal">
                    Please verify all details below before submitting. You will not be able to edit this after submission.
                </p>
            </div>
            <div class="w-full md:w-64 flex flex-col gap-2">
                <div class="flex justify-between text-sm font-medium">
                    <span>Step 3 of 3</span>
                    <span class="text-primary">100%</span>
                </div>
                <div class="rounded-full bg-slate-200 dark:bg-slate-700 h-2 overflow-hidden">
                    <div class="h-full bg-primary rounded-full" style="width: 100%;"></div>
                </div>
                <p class="text-slate-500 dark:text-slate-400 text-xs text-right">Review & Submit</p>
            </div>
        </div>

        <!-- Main Content Area -->
        <form id="step3-form" class="flex flex-col gap-8">

            <!-- Hidden field for existing student status (default: No) -->
            <input type="hidden" name="is_existing_student" value="0">

            <!-- Review Summary Sections -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Personal Info Summary -->
                <section class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 overflow-hidden">
                    <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50">
                        <h3 class="font-bold text-lg flex items-center gap-2">
                            <span class="material-symbols-outlined text-slate-400 text-xl">person</span>
                            Personal Information
                        </h3>
                        <a href="step1.php" class="text-primary text-sm font-medium hover:underline flex items-center gap-1">
                            Edit
                            <span class="material-symbols-outlined text-sm">edit</span>
                        </a>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-3 gap-2">
                            <dt class="text-slate-500 dark:text-slate-400 text-sm font-medium col-span-1">Full Name</dt>
                            <dd class="col-span-2 font-medium"><?= e($studentData['full_name'] ?? 'Not provided') ?></dd>
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <dt class="text-slate-500 dark:text-slate-400 text-sm font-medium col-span-1">Date of Birth</dt>
                            <dd class="col-span-2 font-medium"><?= !empty($studentData['date_of_birth']) ? formatDate($studentData['date_of_birth']) : 'Not provided' ?></dd>
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <dt class="text-slate-500 dark:text-slate-400 text-sm font-medium col-span-1">Gender</dt>
                            <dd class="col-span-2 font-medium"><?= e($studentData['gender'] ?? 'Not provided') ?></dd>
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <dt class="text-slate-500 dark:text-slate-400 text-sm font-medium col-span-1">Email</dt>
                            <dd class="col-span-2 font-medium"><?= e($studentData['parent_email'] ?? 'Not provided') ?></dd>
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <dt class="text-slate-500 dark:text-slate-400 text-sm font-medium col-span-1">Phone</dt>
                            <dd class="col-span-2 font-medium"><?= e($studentData['father_mobile'] ?? 'Not provided') ?></dd>
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <dt class="text-slate-500 dark:text-slate-400 text-sm font-medium col-span-1">Address</dt>
                            <dd class="col-span-2 font-medium"><?= e($studentData['residential_address'] ?? 'Not provided') ?></dd>
                        </div>
                    </div>
                </section>

                <!-- Academic Info Summary -->
                <section class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 overflow-hidden">
                    <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50">
                        <h3 class="font-bold text-lg flex items-center gap-2">
                            <span class="material-symbols-outlined text-slate-400 text-xl">history_edu</span>
                            Academic Details
                        </h3>
                        <a href="step1.php" class="text-primary text-sm font-medium hover:underline flex items-center gap-1">
                            Edit
                            <span class="material-symbols-outlined text-sm">edit</span>
                        </a>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-3 gap-2">
                            <dt class="text-slate-500 dark:text-slate-400 text-sm font-medium col-span-1">Class Applied</dt>
                            <dd class="col-span-2 font-medium"><?= e($studentData['class_applying'] ?? 'Not provided') ?></dd>
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <dt class="text-slate-500 dark:text-slate-400 text-sm font-medium col-span-1">Prev. School</dt>
                            <dd class="col-span-2 font-medium"><?= e($studentData['previous_school'] ?? 'N/A') ?></dd>
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <dt class="text-slate-500 dark:text-slate-400 text-sm font-medium col-span-1">Community</dt>
                            <dd class="col-span-2 font-medium"><?= e($studentData['community'] ?? 'N/A') ?></dd>
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <dt class="text-slate-500 dark:text-slate-400 text-sm font-medium col-span-1">EMIS Number</dt>
                            <dd class="col-span-2 font-medium"><?= e($studentData['emis_number'] ?? 'N/A') ?></dd>
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <dt class="text-slate-500 dark:text-slate-400 text-sm font-medium col-span-1">Maths Type</dt>
                            <dd class="col-span-2 font-medium"><?= e($studentData['maths_type'] ?? 'N/A') ?></dd>
                        </div>
                        <?php if (!empty($studentData['subject_pref_1'])): ?>
                        <div class="grid grid-cols-3 gap-2">
                            <dt class="text-slate-500 dark:text-slate-400 text-sm font-medium col-span-1">Subject Pref 1</dt>
                            <dd class="col-span-2 font-medium text-sm"><?= e($studentData['subject_pref_1']) ?></dd>
                        </div>
                        <?php endif; ?>
                    </div>
                </section>

                <!-- Guardian Info Summary (Full Width) -->
                <section class="md:col-span-2 bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 overflow-hidden">
                    <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50">
                        <h3 class="font-bold text-lg flex items-center gap-2">
                            <span class="material-symbols-outlined text-slate-400 text-xl">family_restroom</span>
                            Guardian Information
                        </h3>
                        <a href="step2.php" class="text-primary text-sm font-medium hover:underline flex items-center gap-1">
                            Edit
                            <span class="material-symbols-outlined text-sm">edit</span>
                        </a>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-12">
                        <div class="grid grid-cols-3 gap-2">
                            <dt class="text-slate-500 dark:text-slate-400 text-sm font-medium col-span-1">Father</dt>
                            <dd class="col-span-2 font-medium"><?= e($fatherData['full_name'] ?? 'Not provided') ?></dd>
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <dt class="text-slate-500 dark:text-slate-400 text-sm font-medium col-span-1">Occupation</dt>
                            <dd class="col-span-2 font-medium"><?= e($fatherData['occupation'] ?? 'N/A') ?></dd>
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <dt class="text-slate-500 dark:text-slate-400 text-sm font-medium col-span-1">Mother</dt>
                            <dd class="col-span-2 font-medium"><?= e($motherData['full_name'] ?? 'Not provided') ?></dd>
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <dt class="text-slate-500 dark:text-slate-400 text-sm font-medium col-span-1">Occupation</dt>
                            <dd class="col-span-2 font-medium"><?= e($motherData['occupation'] ?? 'N/A') ?></dd>
                        </div>
                        <?php if (!empty($parentData['guardian_enabled']) && !empty($parentData['guardian']['full_name'])): ?>
                        <div class="grid grid-cols-3 gap-2">
                            <dt class="text-slate-500 dark:text-slate-400 text-sm font-medium col-span-1">Guardian</dt>
                            <dd class="col-span-2 font-medium"><?= e($parentData['guardian']['full_name']) ?></dd>
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <dt class="text-slate-500 dark:text-slate-400 text-sm font-medium col-span-1">Occupation</dt>
                            <dd class="col-span-2 font-medium"><?= e($parentData['guardian']['occupation'] ?? 'N/A') ?></dd>
                        </div>
                        <?php endif; ?>
                    </div>
                </section>
   <!-- Documents Required Section (Full Width) -->
                <section class="md:col-span-2 bg-amber-50 dark:bg-amber-900/20 rounded-xl border border-amber-200 dark:border-amber-700 overflow-hidden">
                    <div class="flex items-center px-6 py-4 border-b border-amber-200 dark:border-amber-700 bg-amber-100 dark:bg-amber-900/30">
                        <h3 class="font-bold text-lg flex items-center gap-2 text-amber-800 dark:text-amber-200">
                            <span class="material-symbols-outlined text-amber-600 dark:text-amber-400 text-xl">description</span>
                            Documents Required for Class XI Admission
                        </h3>
                    </div>
                    <div class="p-6">
                        <p class="text-sm text-amber-700 dark:text-amber-300 mb-4">
                            Please submit the following documents along with your application form:
                        </p>
                        <ul class="space-y-3">
                            <li class="flex items-start gap-3">
                                <span class="material-symbols-outlined text-amber-600 dark:text-amber-400 text-lg mt-0.5">check_circle</span>
                                <span class="text-sm font-medium text-amber-800 dark:text-amber-200">Copy of Birth Certificate</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="material-symbols-outlined text-amber-600 dark:text-amber-400 text-lg mt-0.5">check_circle</span>
                                <span class="text-sm font-medium text-amber-800 dark:text-amber-200">Address Proof</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="material-symbols-outlined text-amber-600 dark:text-amber-400 text-lg mt-0.5">check_circle</span>
                                <span class="text-sm font-medium text-amber-800 dark:text-amber-200">Income Proof</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="material-symbols-outlined text-amber-600 dark:text-amber-400 text-lg mt-0.5">check_circle</span>
                                <span class="text-sm font-medium text-amber-800 dark:text-amber-200">Report Card of Class X (so far)</span>
                            </li>
                        </ul>
                    </div>
                </section>

            </div>

            <!-- Terms and Declaration -->
            <div class="bg-primary/5 rounded-xl p-6 border border-primary/10">
                <label class="flex items-start gap-3 cursor-pointer">
                    <input type="checkbox" name="terms_accepted" id="terms_accepted" value="1" required
                           class="mt-1 w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary">
                    <span class="text-sm leading-relaxed">
                        I hereby declare that the information provided above is true and correct to the best of my knowledge and belief. I understand that any false information may result in the rejection of my application or expulsion if already admitted.
                    </span>
                </label>
                <span class="text-red-500 text-xs error-message hidden" data-field="terms_accepted"></span>
            </div>

            <!-- Action Bar -->
            <div class="flex flex-col-reverse sm:flex-row items-center justify-between gap-4 mt-4 pt-6 border-t border-slate-200 dark:border-slate-700">
                <button type="button" id="reset-form-btn"
                        class="w-full sm:w-auto text-red-500 hover:text-red-700 font-medium px-6 py-3 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/10 transition-colors text-sm">
                    Reset Form
                </button>
                <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
                    <a href="step2.php"
                       class="w-full sm:w-auto px-6 py-3 rounded-lg border border-slate-300 dark:border-slate-600 font-medium hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors text-sm text-center">
                        Back
                    </a>
                    <button type="submit" id="submit-btn"
                            class="w-full sm:w-auto px-8 py-3 rounded-lg bg-primary hover:bg-blue-700 text-white font-medium shadow-lg shadow-primary/30 transition-all hover:scale-[1.02] active:scale-[0.98] text-sm flex items-center justify-center gap-2">
                        Submit Application
                        <span class="material-symbols-outlined text-sm">send</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</main>

<script>
    window.APP_CONFIG = {
        apiUrl: '<?= apiUrl() ?>',
        sessionToken: '<?= e($sessionToken ?? '') ?>',
        currentStep: 3
    };
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
