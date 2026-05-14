<?php
/**
 * Step 1: Personal Information
 */

// Suppress errors in production
error_reporting(E_ALL);
ini_set('display_errors', '0');

$pageTitle = 'Personal Information';
$currentStep = 1;

require_once __DIR__ . '/includes/header.php';

// Get saved data if resuming
$savedData = $_SESSION['step1_data'] ?? [];
?>

<main class="flex-grow w-full px-4 md:px-8 py-8 flex justify-center">
    <div class="w-full max-w-5xl flex flex-col gap-6">

        <!-- Page Header -->
        <div class="flex flex-col gap-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
                <div>
                    <h1 class="text-3xl md:text-4xl font-black tracking-tight text-slate-900 dark:text-white mb-2">Student Admission Application</h1>
                    <p class="text-slate-500 dark:text-slate-400 text-base font-normal">Please complete the form below to register for the upcoming academic year.</p>
                </div>
                <div class="hidden md:block">
                    <span id="draft-status" class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-wider">
                        <span class="w-2 h-2 rounded-full bg-slate-400 mr-1"></span> New Application
                    </span>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="bg-surface-light dark:bg-surface-dark p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                <div class="flex justify-between items-center mb-3">
                    <span class="text-primary font-bold text-sm uppercase tracking-wide">Step 1: Personal Info</span>
                    <span class="text-slate-400 dark:text-slate-500 text-sm font-medium">Step 1 of 3</span>
                </div>
                <div class="h-2 w-full bg-slate-100 dark:bg-slate-700 rounded-full overflow-hidden">
                    <div class="h-full bg-primary w-1/3 rounded-full shadow-[0_0_10px_rgba(19,91,236,0.5)]"></div>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form id="step1-form" class="bg-surface-light dark:bg-surface-dark rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">

            <!-- Student Information Section -->
            <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-800/20">
                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">person</span>
                    Student Information
                </h3>
            </div>

            <div class="p-6 md:p-8 space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    <!-- Full Name -->
                    <label class="flex flex-col gap-2 group">
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300 group-focus-within:text-primary transition-colors">Full Name of Student <span class="text-red-500">*</span></span>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500 text-xl pointer-events-none">badge</span>
                            <input type="text" name="full_name" id="full_name" required
                                   value="<?= e($savedData['full_name'] ?? '') ?>"
                                   class="form-input w-full rounded-lg border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 pl-10 h-12 focus:border-primary focus:ring-primary/20 dark:text-white dark:placeholder-slate-500 transition-all"
                                   placeholder="Enter full name">
                        </div>
                        <span class="text-red-500 text-xs error-message hidden" data-field="full_name"></span>
                    </label>

                    <!-- Gender -->
                    <label class="flex flex-col gap-2 group">
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300 group-focus-within:text-primary transition-colors">Gender <span class="text-red-500">*</span></span>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500 text-xl pointer-events-none">transgender</span>
                            <select name="gender" id="gender" required
                                    class="form-select w-full rounded-lg border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 pl-10 h-12 focus:border-primary focus:ring-primary/20 dark:text-white transition-all">
                                <option value="" disabled <?= empty($savedData['gender']) ? 'selected' : '' ?>>Select Gender</option>
                                <option value="Male" <?= ($savedData['gender'] ?? '') === 'Male' ? 'selected' : '' ?>>Male</option>
                                <option value="Female" <?= ($savedData['gender'] ?? '') === 'Female' ? 'selected' : '' ?>>Female</option>
                                <option value="Other" <?= ($savedData['gender'] ?? '') === 'Other' ? 'selected' : '' ?>>Other</option>
                            </select>
                        </div>
                        <span class="text-red-500 text-xs error-message hidden" data-field="gender"></span>
                    </label>

                    <!-- Date of Birth -->
                    <label class="flex flex-col gap-2 group">
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300 group-focus-within:text-primary transition-colors">Date of Birth <span class="text-red-500">*</span></span>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500 text-xl pointer-events-none">calendar_today</span>
                            <input type="date" name="date_of_birth" id="date_of_birth" required
                                   value="<?= e($savedData['date_of_birth'] ?? '') ?>"
                                   class="form-input w-full rounded-lg border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 pl-10 h-12 focus:border-primary focus:ring-primary/20 dark:text-white transition-all">
                        </div>
                        <span class="text-red-500 text-xs error-message hidden" data-field="date_of_birth"></span>
                    </label>

                    <!-- Class Applying For -->
                    <label class="flex flex-col gap-2 group">
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300 group-focus-within:text-primary transition-colors">Class Applying For <span class="text-red-500">*</span></span>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500 text-xl pointer-events-none">school</span>
                            <input type="text" name="class_applying" id="class_applying" value="STD XI" readonly
                                   class="form-input w-full rounded-lg border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-800/50 pl-10 h-12 dark:text-white cursor-not-allowed">
                        </div>
                    </label>

                    <!-- Community -->
                    <label class="flex flex-col gap-2 group">
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300 group-focus-within:text-primary transition-colors">Community <span class="text-red-500">*</span></span>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500 text-xl pointer-events-none">diversity_3</span>
                            <select name="community" id="community" required
                                    class="form-select w-full rounded-lg border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 pl-10 h-12 focus:border-primary focus:ring-primary/20 dark:text-white transition-all">
                                <option value="" disabled <?= empty($savedData['community']) ? 'selected' : '' ?>>Select Community</option>
                                <?php foreach (getCommunityOptions() as $community): ?>
                                <option value="<?= e($community) ?>" <?= ($savedData['community'] ?? '') === $community ? 'selected' : '' ?>><?= e($community) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <span class="text-red-500 text-xs error-message hidden" data-field="community"></span>
                    </label>

                    <!-- EMIS Number -->
                    <label class="flex flex-col gap-2 group">
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300 group-focus-within:text-primary transition-colors">EMIS Number <span class="text-red-500">*</span></span>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500 text-xl pointer-events-none">numbers</span>
                            <input type="text" name="emis_number" id="emis_number" required
                                   value="<?= e($savedData['emis_number'] ?? '') ?>"
                                   class="form-input w-full rounded-lg border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 pl-10 h-12 focus:border-primary focus:ring-primary/20 dark:text-white dark:placeholder-slate-500 transition-all"
                                   placeholder="Enter EMIS Number">
                        </div>
                        <span class="text-red-500 text-xs error-message hidden" data-field="emis_number"></span>
                    </label>
                </div>

                <div class="h-px bg-slate-100 dark:bg-slate-700/50"></div>

                <!-- Contact Information -->
                <div>
                    <h4 class="text-base font-semibold text-slate-800 dark:text-slate-200 mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary/80 text-lg">contact_mail</span> Contact Information
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                        <!-- Father's Mobile -->
                        <label class="flex flex-col gap-2 group">
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300 group-focus-within:text-primary transition-colors">Father's Mobile <span class="text-red-500">*</span></span>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500 text-xl pointer-events-none">call</span>
                                <input type="tel" name="father_mobile" id="father_mobile" required
                                       value="<?= e($savedData['father_mobile'] ?? '') ?>"
                                       class="form-input w-full rounded-lg border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 pl-10 h-12 focus:border-primary focus:ring-primary/20 dark:text-white dark:placeholder-slate-500 transition-all"
                                       placeholder="9876543210">
                            </div>
                            <span class="text-red-500 text-xs error-message hidden" data-field="father_mobile"></span>
                        </label>

                        <!-- Mother's Mobile -->
                        <label class="flex flex-col gap-2 group">
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300 group-focus-within:text-primary transition-colors">Mother's Mobile <span class="text-red-500">*</span></span>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500 text-xl pointer-events-none">call</span>
                                <input type="tel" name="mother_mobile" id="mother_mobile" required
                                       value="<?= e($savedData['mother_mobile'] ?? '') ?>"
                                       class="form-input w-full rounded-lg border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 pl-10 h-12 focus:border-primary focus:ring-primary/20 dark:text-white dark:placeholder-slate-500 transition-all"
                                       placeholder="9876543210">
                            </div>
                            <span class="text-red-500 text-xs error-message hidden" data-field="mother_mobile"></span>
                        </label>

                        <!-- Parent's Email -->
                        <label class="flex flex-col gap-2 group">
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300 group-focus-within:text-primary transition-colors">Parent's Email <span class="text-red-500">*</span></span>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500 text-xl pointer-events-none">mail</span>
                                <input type="email" name="parent_email" id="parent_email" required
                                       value="<?= e($savedData['parent_email'] ?? '') ?>"
                                       class="form-input w-full rounded-lg border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 pl-10 h-12 focus:border-primary focus:ring-primary/20 dark:text-white dark:placeholder-slate-500 transition-all"
                                       placeholder="parent@example.com">
                            </div>
                            <span class="text-red-500 text-xs error-message hidden" data-field="parent_email"></span>
                        </label>

                        <!-- Residential Address -->
                        <label class="flex flex-col gap-2 group md:col-span-2 lg:col-span-3">
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300 group-focus-within:text-primary transition-colors">Residential Address <span class="text-red-500">*</span></span>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3 top-4 text-slate-400 dark:text-slate-500 text-xl pointer-events-none">home</span>
                                <textarea name="residential_address" id="residential_address" required
                                          class="form-textarea w-full rounded-lg border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 pl-10 py-3 min-h-[100px] focus:border-primary focus:ring-primary/20 dark:text-white dark:placeholder-slate-500 transition-all"
                                          placeholder="Enter complete residential address"><?= e($savedData['residential_address'] ?? '') ?></textarea>
                            </div>
                            <span class="text-red-500 text-xs error-message hidden" data-field="residential_address"></span>
                        </label>
                    </div>
                </div>

                <div class="h-px bg-slate-100 dark:bg-slate-700/50"></div>

                <!-- Academic & Preferences -->
                <div>
                    <h4 class="text-base font-semibold text-slate-800 dark:text-slate-200 mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary/80 text-lg">history_edu</span> Academic & Preferences
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                        <!-- Previous School -->
                        <label class="flex flex-col gap-2 group md:col-span-2">
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300 group-focus-within:text-primary transition-colors">Previous School <span class="text-red-500">*</span></span>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500 text-xl pointer-events-none">apartment</span>
                                <input type="text" name="previous_school" id="previous_school" required
                                       value="<?= e($savedData['previous_school'] ?? '') ?>"
                                       class="form-input w-full rounded-lg border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 pl-10 h-12 focus:border-primary focus:ring-primary/20 dark:text-white dark:placeholder-slate-500 transition-all"
                                       placeholder="Name of previous school">
                            </div>
                            <span class="text-red-500 text-xs error-message hidden" data-field="previous_school"></span>
                        </label>

                        <!-- Maths Type -->
                        <label class="flex flex-col gap-2 group">
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300 group-focus-within:text-primary transition-colors">Maths Type (Class 10) <span class="text-red-500">*</span></span>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500 text-xl pointer-events-none">calculate</span>
                                <select name="maths_type" id="maths_type" required
                                        class="form-select w-full rounded-lg border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 pl-10 h-12 focus:border-primary focus:ring-primary/20 dark:text-white transition-all">
                                    <option value="" disabled <?= empty($savedData['maths_type']) ? 'selected' : '' ?>>-- SELECT --</option>
                                    <option value="Basic" <?= ($savedData['maths_type'] ?? '') === 'Basic' ? 'selected' : '' ?>>Basic Maths</option>
                                    <option value="Standard" <?= ($savedData['maths_type'] ?? '') === 'Standard' ? 'selected' : '' ?>>Standard Maths</option>
                                </select>
                            </div>
                            <span class="text-red-500 text-xs error-message hidden" data-field="maths_type"></span>
                        </label>

                        <!-- Subject Group Preferences -->
                        <div class="col-span-1 md:col-span-2 lg:col-span-3 grid grid-cols-1 sm:grid-cols-2 lg:col-span-4 gap-4 bg-slate-50 dark:bg-slate-800/30 p-4 rounded-lg border border-slate-100 dark:border-slate-800">
                            <p class="col-span-full text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Subject Group Preferences (For Class 11-12) <span class="text-red-500">*</span></p>

                            <?php for ($i = 1; $i <= 4; $i++): ?>
                            <label class="flex flex-col gap-2">
                                <span class="text-xs font-medium text-slate-600 dark:text-slate-400">Preference <?= $i ?> <span class="text-red-500">*</span></span>
                                <select name="subject_pref_<?= $i ?>" id="subject_pref_<?= $i ?>" required
                                        class="form-select w-full rounded border-slate-200 dark:border-slate-700 text-sm focus:border-primary focus:ring-0 dark:bg-slate-800 dark:text-white">
                                    <option value="" disabled <?= empty($savedData["subject_pref_{$i}"]) ? 'selected' : '' ?>>Select Group</option>
                                    <?php foreach (getSubjectGroups() as $group): ?>
                                    <option value="<?= e($group) ?>" <?= ($savedData["subject_pref_{$i}"] ?? '') === $group ? 'selected' : '' ?>><?= e($group) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="text-red-500 text-xs error-message hidden" data-field="subject_pref_<?= $i ?>"></span>
                            </label>
                            <?php endfor; ?>
                        </div>

                        <!-- Integrated Course -->
                        <div class="col-span-1 md:col-span-2 lg:col-span-3">
                            <label class="flex flex-col gap-2 group">
                                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Do you want to apply for Integrated Course? <span class="text-red-500">*</span></span>
                                <div class="flex items-center gap-6">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="integrated_course" value="Yes" required
                                               <?= ($savedData['integrated_course'] ?? '') === 'Yes' ? 'checked' : '' ?>
                                               class="form-radio text-primary focus:ring-primary/20">
                                        <span class="text-slate-700 dark:text-slate-300">Yes</span>
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="integrated_course" value="No" required
                                               <?= ($savedData['integrated_course'] ?? 'No') === 'No' ? 'checked' : '' ?>
                                               class="form-radio text-primary focus:ring-primary/20">
                                        <span class="text-slate-700 dark:text-slate-300">No</span>
                                    </label>
                                </div>
                                <span class="text-red-500 text-xs error-message hidden" data-field="integrated_course"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/50 border-t border-slate-200 dark:border-slate-700 flex flex-col sm:flex-row justify-between items-center gap-4">
                <button type="button" id="save-draft-btn"
                        class="w-full sm:w-auto px-6 py-3 rounded-lg border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-200 font-medium hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-lg">save</span>
                    Save as Draft
                </button>
                <button type="submit" id="next-step-btn"
                        class="w-full sm:w-auto px-8 py-3 rounded-lg bg-primary text-white font-bold hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/30 flex items-center justify-center gap-2 group">
                    Next Step
                    <span class="material-symbols-outlined text-lg group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </button>
            </div>
        </form>
    </div>
</main>

<script>
    // Initialize with session token if available
    window.APP_CONFIG = {
        apiUrl: '<?= apiUrl() ?>',
        sessionToken: '<?= e($sessionToken ?? '') ?>',
        currentStep: 1
    };
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
