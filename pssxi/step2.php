<?php
/**
 * Step 2: Parent & Guardian Details
 */

// Suppress errors in production
error_reporting(E_ALL);
ini_set('display_errors', '0');

$pageTitle = 'Parent Details';
$currentStep = 2;

require_once __DIR__ . '/includes/header.php';

// Check if session exists
if (empty($_SESSION['app_token'])) {
    header('Location: step1.php');
    exit;
}

// Get saved data if resuming
$savedData = $_SESSION['step2_data'] ?? [];
$fatherData = $savedData['father'] ?? [];
$motherData = $savedData['mother'] ?? [];
$guardianData = $savedData['guardian'] ?? [];
$guardianEnabled = !empty($savedData['guardian_enabled']);

$qualificationOptions = getQualificationOptions();
?>

<main class="flex-1 w-full max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Progress Bar -->
    <div class="mb-8 max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-medium text-primary">Step 2 of 3</span>
            <span class="text-sm text-slate-500 dark:text-slate-400">66% Completed</span>
        </div>
        <div class="h-2 w-full rounded-full bg-slate-200 dark:bg-slate-700 overflow-hidden">
            <div class="h-full rounded-full bg-primary transition-all duration-500" style="width: 66%;"></div>
        </div>
    </div>

    <!-- Page Header -->
    <div class="mb-10 text-center max-w-2xl mx-auto">
        <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-slate-900 dark:text-white mb-3">Parent & Guardian Details</h1>
        <p class="text-base text-slate-500 dark:text-slate-400">Please provide accurate information for both parents. If applicable, add details for a local guardian.</p>
    </div>

    <!-- 3-Column Form Layout -->
    <form id="step2-form" class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8 mb-12">

        <!-- Father's Column -->
        <div class="flex flex-col gap-5 p-6 rounded-xl bg-white dark:bg-slate-800 shadow-sm border border-slate-200 dark:border-slate-700 relative group hover:border-primary/30 transition-colors">
            <div class="absolute top-0 left-0 w-full h-1 bg-primary rounded-t-xl"></div>
            <div class="flex items-center gap-3 pb-4 border-b border-slate-100 dark:border-slate-700/50">
                <div class="p-2 rounded-lg bg-blue-50 dark:bg-blue-900/20 text-primary">
                    <span class="material-symbols-outlined">man</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white">Father's Details</h3>
            </div>

            <!-- Father Name -->
            <label class="block">
                <span class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5 block">Full Name <span class="text-red-500">*</span></span>
                <input type="text" name="father[full_name]" id="father_full_name" required
                       value="<?= e($fatherData['full_name'] ?? '') ?>"
                       class="w-full rounded-lg border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-900/50 px-4 py-3 text-sm focus:border-primary focus:ring-primary dark:text-white placeholder:text-slate-400 transition-shadow"
                       placeholder="e.g. Robert Smith">
                <span class="text-red-500 text-xs error-message hidden" data-field="father_full_name"></span>
            </label>

            <!-- Father Qualification -->
            <label class="block">
                <span class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5 block">Qualification</span>
                <div class="relative">
                    <select name="father[qualification]" id="father_qualification"
                            class="w-full rounded-lg border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-900/50 px-4 py-3 text-sm focus:border-primary focus:ring-primary dark:text-white appearance-none cursor-pointer">
                        <option value="" disabled <?= empty($fatherData['qualification']) ? 'selected' : '' ?>>Select highest degree</option>
                        <?php foreach ($qualificationOptions as $key => $label): ?>
                        <option value="<?= e($key) ?>" <?= ($fatherData['qualification'] ?? '') === $key ? 'selected' : '' ?>><?= e($label) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-slate-500 text-lg">expand_more</span>
                </div>
            </label>

            <!-- Father Occupation -->
            <label class="block">
                <span class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5 block">Occupation</span>
                <input type="text" name="father[occupation]" id="father_occupation"
                       value="<?= e($fatherData['occupation'] ?? '') ?>"
                       class="w-full rounded-lg border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-900/50 px-4 py-3 text-sm focus:border-primary focus:ring-primary dark:text-white placeholder:text-slate-400"
                       placeholder="e.g. Software Engineer">
            </label>

            <!-- Father Annual Income -->
            <label class="block">
                <span class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5 block">Annual Income</span>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">currency_rupee</span>
                    <input type="number" name="father[annual_income]" id="father_annual_income"
                           value="<?= e($fatherData['annual_income'] ?? '') ?>"
                           class="w-full rounded-lg border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-900/50 pl-10 pr-4 py-3 text-sm focus:border-primary focus:ring-primary dark:text-white placeholder:text-slate-400"
                           placeholder="0.00">
                </div>
            </label>

            <!-- Father Office Address -->
            <label class="block flex-1">
                <span class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5 block">Office Address</span>
                <textarea name="father[office_address]" id="father_office_address" rows="3"
                          class="w-full rounded-lg border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-900/50 px-4 py-3 text-sm focus:border-primary focus:ring-primary dark:text-white placeholder:text-slate-400 resize-none h-24"
                          placeholder="Enter full office address"><?= e($fatherData['office_address'] ?? '') ?></textarea>
            </label>
        </div>

        <!-- Mother's Column -->
        <div class="flex flex-col gap-5 p-6 rounded-xl bg-white dark:bg-slate-800 shadow-sm border border-slate-200 dark:border-slate-700 relative group hover:border-primary/30 transition-colors">
            <div class="absolute top-0 left-0 w-full h-1 bg-pink-500 rounded-t-xl"></div>
            <div class="flex items-center gap-3 pb-4 border-b border-slate-100 dark:border-slate-700/50">
                <div class="p-2 rounded-lg bg-pink-50 dark:bg-pink-900/20 text-pink-500">
                    <span class="material-symbols-outlined">woman</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white">Mother's Details</h3>
            </div>

            <!-- Mother Name -->
            <label class="block">
                <span class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5 block">Full Name <span class="text-red-500">*</span></span>
                <input type="text" name="mother[full_name]" id="mother_full_name" required
                       value="<?= e($motherData['full_name'] ?? '') ?>"
                       class="w-full rounded-lg border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-900/50 px-4 py-3 text-sm focus:border-pink-500 focus:ring-pink-500 dark:text-white placeholder:text-slate-400 transition-shadow"
                       placeholder="e.g. Emily Smith">
                <span class="text-red-500 text-xs error-message hidden" data-field="mother_full_name"></span>
            </label>

            <!-- Mother Qualification -->
            <label class="block">
                <span class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5 block">Qualification</span>
                <div class="relative">
                    <select name="mother[qualification]" id="mother_qualification"
                            class="w-full rounded-lg border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-900/50 px-4 py-3 text-sm focus:border-pink-500 focus:ring-pink-500 dark:text-white appearance-none cursor-pointer">
                        <option value="" disabled <?= empty($motherData['qualification']) ? 'selected' : '' ?>>Select highest degree</option>
                        <?php foreach ($qualificationOptions as $key => $label): ?>
                        <option value="<?= e($key) ?>" <?= ($motherData['qualification'] ?? '') === $key ? 'selected' : '' ?>><?= e($label) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-slate-500 text-lg">expand_more</span>
                </div>
            </label>

            <!-- Mother Occupation -->
            <label class="block">
                <span class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5 block">Occupation</span>
                <input type="text" name="mother[occupation]" id="mother_occupation"
                       value="<?= e($motherData['occupation'] ?? '') ?>"
                       class="w-full rounded-lg border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-900/50 px-4 py-3 text-sm focus:border-pink-500 focus:ring-pink-500 dark:text-white placeholder:text-slate-400"
                       placeholder="e.g. Doctor">
            </label>

            <!-- Mother Annual Income -->
            <label class="block">
                <span class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5 block">Annual Income</span>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">currency_rupee</span>
                    <input type="number" name="mother[annual_income]" id="mother_annual_income"
                           value="<?= e($motherData['annual_income'] ?? '') ?>"
                           class="w-full rounded-lg border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-900/50 pl-10 pr-4 py-3 text-sm focus:border-pink-500 focus:ring-pink-500 dark:text-white placeholder:text-slate-400"
                           placeholder="0.00">
                </div>
            </label>

            <!-- Mother Office Address -->
            <label class="block flex-1">
                <span class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5 block">Office Address</span>
                <textarea name="mother[office_address]" id="mother_office_address" rows="3"
                          class="w-full rounded-lg border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-900/50 px-4 py-3 text-sm focus:border-pink-500 focus:ring-pink-500 dark:text-white placeholder:text-slate-400 resize-none h-24"
                          placeholder="Enter full office address"><?= e($motherData['office_address'] ?? '') ?></textarea>
            </label>
        </div>

        <!-- Guardian's Column (Optional) -->
        <div id="guardian-section" class="flex flex-col gap-5 p-6 rounded-xl bg-slate-50 dark:bg-slate-800/50 shadow-sm border border-dashed border-slate-300 dark:border-slate-700 relative transition-opacity <?= $guardianEnabled ? '' : 'opacity-90' ?>">
            <div class="flex items-center justify-between pb-4 border-b border-slate-200 dark:border-slate-700/50">
                <div class="flex items-center gap-3">
                    <div class="p-2 rounded-lg bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-300">
                        <span class="material-symbols-outlined">family_star</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-700 dark:text-slate-200">Guardian</h3>
                </div>
                <div class="flex items-center">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="guardian_enabled" id="guardian_enabled" value="1"
                               <?= $guardianEnabled ? 'checked' : '' ?>
                               class="sr-only peer">
                        <div class="w-9 h-5 bg-slate-300 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-primary"></div>
                        <span class="ml-2 text-xs font-medium text-slate-500 dark:text-slate-400">Enable</span>
                    </label>
                </div>
            </div>

            <div id="guardian-fields" class="relative">
                <!-- Overlay when disabled -->
                <div id="guardian-overlay" class="<?= $guardianEnabled ? 'hidden' : '' ?> absolute inset-0 bg-slate-50/50 dark:bg-slate-900/50 z-10 cursor-not-allowed rounded-lg"></div>

                <div class="flex flex-col gap-5">
                    <!-- Guardian Name -->
                    <label class="block">
                        <span class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1.5 block">Full Name</span>
                        <input type="text" name="guardian[full_name]" id="guardian_full_name"
                               value="<?= e($guardianData['full_name'] ?? '') ?>"
                               <?= $guardianEnabled ? '' : 'disabled' ?>
                               class="w-full rounded-lg border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-900/50 px-4 py-3 text-sm dark:text-slate-500 placeholder:text-slate-300"
                               placeholder="e.g. John Doe">
                    </label>

                    <!-- Guardian Qualification -->
                    <label class="block">
                        <span class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1.5 block">Qualification</span>
                        <div class="relative">
                            <select name="guardian[qualification]" id="guardian_qualification"
                                    <?= $guardianEnabled ? '' : 'disabled' ?>
                                    class="w-full rounded-lg border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-900/50 px-4 py-3 text-sm dark:text-slate-500 appearance-none">
                                <option value="" disabled selected>Select highest degree</option>
                                <?php foreach ($qualificationOptions as $key => $label): ?>
                                <option value="<?= e($key) ?>" <?= ($guardianData['qualification'] ?? '') === $key ? 'selected' : '' ?>><?= e($label) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-slate-300 text-lg">expand_more</span>
                        </div>
                    </label>

                    <!-- Guardian Occupation -->
                    <label class="block">
                        <span class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1.5 block">Occupation</span>
                        <input type="text" name="guardian[occupation]" id="guardian_occupation"
                               value="<?= e($guardianData['occupation'] ?? '') ?>"
                               <?= $guardianEnabled ? '' : 'disabled' ?>
                               class="w-full rounded-lg border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-900/50 px-4 py-3 text-sm dark:text-slate-500 placeholder:text-slate-300"
                               placeholder="Job title">
                    </label>

                    <!-- Guardian Annual Income -->
                    <label class="block">
                        <span class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1.5 block">Annual Income</span>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-300 text-lg">currency_rupee</span>
                            <input type="number" name="guardian[annual_income]" id="guardian_annual_income"
                                   value="<?= e($guardianData['annual_income'] ?? '') ?>"
                                   <?= $guardianEnabled ? '' : 'disabled' ?>
                                   class="w-full rounded-lg border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-900/50 pl-10 pr-4 py-3 text-sm dark:text-slate-500 placeholder:text-slate-300"
                                   placeholder="0.00">
                        </div>
                    </label>

                    <!-- Guardian Office Address -->
                    <label class="block flex-1">
                        <span class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1.5 block">Office Address</span>
                        <textarea name="guardian[office_address]" id="guardian_office_address" rows="3"
                                  <?= $guardianEnabled ? '' : 'disabled' ?>
                                  class="w-full rounded-lg border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-900/50 px-4 py-3 text-sm dark:text-slate-500 placeholder:text-slate-300 resize-none h-24"
                                  placeholder="Enter full address"><?= e($guardianData['office_address'] ?? '') ?></textarea>
                    </label>
                </div>
            </div>
        </div>
    </form>

    <!-- Footer Navigation -->
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-6 border-t border-slate-200 dark:border-slate-800">
        <a href="step1.php"
           class="group flex items-center gap-2 px-6 py-3 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors font-medium text-sm w-full sm:w-auto justify-center">
            <span class="material-symbols-outlined text-lg transition-transform group-hover:-translate-x-1">arrow_back</span>
            Back to Student Info
        </a>
        <div class="flex gap-4 w-full sm:w-auto">
            <button type="button" id="save-draft-btn"
                    class="flex-1 sm:flex-none items-center justify-center px-6 py-3 rounded-lg border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-white font-medium hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors text-sm">
                Save as Draft
            </button>
            <button type="submit" form="step2-form" id="next-step-btn"
                    class="group flex-1 sm:flex-none flex items-center justify-center gap-2 px-8 py-3 rounded-lg bg-primary text-white font-bold shadow-lg shadow-primary/30 hover:bg-primary/90 hover:shadow-primary/50 transition-all text-sm">
                Save & Continue
                <span class="material-symbols-outlined text-lg transition-transform group-hover:translate-x-1">arrow_forward</span>
            </button>
        </div>
    </div>
</main>

<script>
    window.APP_CONFIG = {
        apiUrl: '<?= apiUrl() ?>',
        sessionToken: '<?= e($sessionToken ?? '') ?>',
        currentStep: 2
    };

    // Guardian toggle functionality
    document.getElementById('guardian_enabled').addEventListener('change', function() {
        const overlay = document.getElementById('guardian-overlay');
        const fields = document.querySelectorAll('#guardian-fields input, #guardian-fields select, #guardian-fields textarea');

        if (this.checked) {
            overlay.classList.add('hidden');
            fields.forEach(field => field.disabled = false);
        } else {
            overlay.classList.remove('hidden');
            fields.forEach(field => field.disabled = true);
        }
    });
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
