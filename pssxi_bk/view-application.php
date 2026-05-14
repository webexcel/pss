<?php
/**
 * View Single Application Details
 */

$pageTitle = 'View Application';
$currentStep = 0;

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/api/Config/Database.php';
require_once __DIR__ . '/api/Models/Application.php';
require_once __DIR__ . '/api/Models/Student.php';
require_once __DIR__ . '/api/Models/ParentModel.php';

use Api\Config\Database;
use Api\Models\Application;

$applicationId = $_GET['id'] ?? null;

if (!$applicationId) {
    header('Location: applications.php');
    exit;
}

// Get application data
$applicationModel = new Application();
$app = $applicationModel->findByApplicationId($applicationId);

if (!$app) {
    header('Location: applications.php');
    exit;
}

$data = $applicationModel->getCompleteData((int) $app['id']);
$student = $data['student'] ?? [];
$parents = $data['parents'] ?? [];

// Organize parents by type
$father = [];
$mother = [];
$guardian = [];
foreach ($parents as $parent) {
    if ($parent['parent_type'] === 'father') $father = $parent;
    if ($parent['parent_type'] === 'mother') $mother = $parent;
    if ($parent['parent_type'] === 'guardian') $guardian = $parent;
}
?>

<main class="flex-grow w-full px-4 md:px-8 py-8">
    <div class="max-w-4xl mx-auto">

        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <div>
                <a href="applications.php" class="text-primary hover:underline text-sm flex items-center gap-1 mb-2">
                    <span class="material-symbols-outlined text-base">arrow_back</span>
                    Back to Applications
                </a>
                <h1 class="text-2xl md:text-3xl font-black tracking-tight text-slate-900 dark:text-white">
                    <?= e($student['full_name'] ?? 'Application Details') ?>
                </h1>
                <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">
                    Application ID: <span class="font-mono text-primary"><?= e($applicationId) ?></span>
                </p>
            </div>
            <a href="download-pdf.php?id=<?= e($applicationId) ?>"
               class="px-4 py-2 rounded-lg bg-green-600 text-white font-medium hover:bg-green-700 transition-colors flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">download</span>
                Download PDF
            </a>
        </div>

        <!-- Status Card -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-slate-200 dark:border-slate-700 p-4 mb-6 flex flex-wrap items-center gap-4">
            <div class="flex items-center gap-2">
                <span class="text-sm text-slate-500 dark:text-slate-400">Status:</span>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                    <?= ucfirst($app['status']) ?>
                </span>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-sm text-slate-500 dark:text-slate-400">Submitted:</span>
                <span class="text-sm text-slate-700 dark:text-slate-300">
                    <?= $app['submitted_at'] ? date('d M Y, h:i A', strtotime($app['submitted_at'])) : 'N/A' ?>
                </span>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-sm text-slate-500 dark:text-slate-400">Existing Student:</span>
                <span class="text-sm text-slate-700 dark:text-slate-300">
                    <?= $app['is_existing_student'] ? 'Yes' : 'No' ?>
                </span>
            </div>
        </div>

        <!-- Student Information -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm mb-6">
            <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-800/20">
                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">person</span>
                    Student Information
                </h3>
            </div>
            <div class="p-6">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Full Name</dt>
                        <dd class="mt-1 text-slate-900 dark:text-white font-medium"><?= e($student['full_name'] ?? 'N/A') ?></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Class Applying For</dt>
                        <dd class="mt-1 text-slate-900 dark:text-white"><?= e($student['class_applying'] ?? 'N/A') ?></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Date of Birth</dt>
                        <dd class="mt-1 text-slate-900 dark:text-white"><?= $student['date_of_birth'] ? date('d/m/Y', strtotime($student['date_of_birth'])) : 'N/A' ?></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Gender</dt>
                        <dd class="mt-1 text-slate-900 dark:text-white"><?= e($student['gender'] ?? 'N/A') ?></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Community</dt>
                        <dd class="mt-1 text-slate-900 dark:text-white"><?= e($student['community'] ?? 'N/A') ?></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">EMIS Number</dt>
                        <dd class="mt-1 text-slate-900 dark:text-white"><?= e($student['emis_number'] ?? 'N/A') ?></dd>
                    </div>
                    <div class="md:col-span-2">
                        <dt class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Residential Address</dt>
                        <dd class="mt-1 text-slate-900 dark:text-white"><?= nl2br(e($student['residential_address'] ?? 'N/A')) ?></dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm mb-6">
            <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-800/20">
                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">contact_phone</span>
                    Contact Information
                </h3>
            </div>
            <div class="p-6">
                <dl class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <dt class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Father's Mobile</dt>
                        <dd class="mt-1 text-slate-900 dark:text-white"><?= e($student['father_mobile'] ?? 'N/A') ?></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Mother's Mobile</dt>
                        <dd class="mt-1 text-slate-900 dark:text-white"><?= e($student['mother_mobile'] ?? 'N/A') ?></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Parent's Email</dt>
                        <dd class="mt-1 text-slate-900 dark:text-white"><?= e($student['parent_email'] ?? 'N/A') ?></dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Academic Information -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm mb-6">
            <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-800/20">
                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">school</span>
                    Academic Information
                </h3>
            </div>
            <div class="p-6">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Previous School</dt>
                        <dd class="mt-1 text-slate-900 dark:text-white"><?= e($student['previous_school'] ?? 'N/A') ?></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Maths Type (Class 10)</dt>
                        <dd class="mt-1 text-slate-900 dark:text-white"><?= e($student['maths_type'] ?? 'N/A') ?></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Subject Preference 1</dt>
                        <dd class="mt-1 text-slate-900 dark:text-white"><?= e($student['subject_pref_1'] ?? 'N/A') ?></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Subject Preference 2</dt>
                        <dd class="mt-1 text-slate-900 dark:text-white"><?= e($student['subject_pref_2'] ?? 'N/A') ?></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Subject Preference 3</dt>
                        <dd class="mt-1 text-slate-900 dark:text-white"><?= e($student['subject_pref_3'] ?? 'N/A') ?></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Subject Preference 4</dt>
                        <dd class="mt-1 text-slate-900 dark:text-white"><?= e($student['subject_pref_4'] ?? 'N/A') ?></dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Parent Details -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm mb-6">
            <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-800/20">
                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">family_restroom</span>
                    Parent Details
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Father -->
                    <div class="p-4 bg-slate-50 dark:bg-slate-800/30 rounded-lg">
                        <h4 class="font-semibold text-slate-800 dark:text-slate-200 mb-3">Father</h4>
                        <dl class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-slate-500 dark:text-slate-400">Name:</dt>
                                <dd class="text-slate-900 dark:text-white"><?= e($father['full_name'] ?? 'N/A') ?></dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-slate-500 dark:text-slate-400">Qualification:</dt>
                                <dd class="text-slate-900 dark:text-white"><?= e($father['qualification'] ?? 'N/A') ?></dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-slate-500 dark:text-slate-400">Occupation:</dt>
                                <dd class="text-slate-900 dark:text-white"><?= e($father['occupation'] ?? 'N/A') ?></dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-slate-500 dark:text-slate-400">Annual Income:</dt>
                                <dd class="text-slate-900 dark:text-white"><?= $father['annual_income'] ? 'Rs. ' . number_format((float)$father['annual_income']) : 'N/A' ?></dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Mother -->
                    <div class="p-4 bg-slate-50 dark:bg-slate-800/30 rounded-lg">
                        <h4 class="font-semibold text-slate-800 dark:text-slate-200 mb-3">Mother</h4>
                        <dl class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-slate-500 dark:text-slate-400">Name:</dt>
                                <dd class="text-slate-900 dark:text-white"><?= e($mother['full_name'] ?? 'N/A') ?></dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-slate-500 dark:text-slate-400">Qualification:</dt>
                                <dd class="text-slate-900 dark:text-white"><?= e($mother['qualification'] ?? 'N/A') ?></dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-slate-500 dark:text-slate-400">Occupation:</dt>
                                <dd class="text-slate-900 dark:text-white"><?= e($mother['occupation'] ?? 'N/A') ?></dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-slate-500 dark:text-slate-400">Annual Income:</dt>
                                <dd class="text-slate-900 dark:text-white"><?= $mother['annual_income'] ? 'Rs. ' . number_format((float)$mother['annual_income']) : 'N/A' ?></dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <?php if (!empty($guardian['full_name'])): ?>
                <!-- Guardian -->
                <div class="mt-6 p-4 bg-slate-50 dark:bg-slate-800/30 rounded-lg">
                    <h4 class="font-semibold text-slate-800 dark:text-slate-200 mb-3">Guardian</h4>
                    <dl class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                        <div>
                            <dt class="text-slate-500 dark:text-slate-400">Name:</dt>
                            <dd class="text-slate-900 dark:text-white"><?= e($guardian['full_name'] ?? 'N/A') ?></dd>
                        </div>
                        <div>
                            <dt class="text-slate-500 dark:text-slate-400">Qualification:</dt>
                            <dd class="text-slate-900 dark:text-white"><?= e($guardian['qualification'] ?? 'N/A') ?></dd>
                        </div>
                        <div>
                            <dt class="text-slate-500 dark:text-slate-400">Occupation:</dt>
                            <dd class="text-slate-900 dark:text-white"><?= e($guardian['occupation'] ?? 'N/A') ?></dd>
                        </div>
                        <div>
                            <dt class="text-slate-500 dark:text-slate-400">Annual Income:</dt>
                            <dd class="text-slate-900 dark:text-white"><?= $guardian['annual_income'] ? 'Rs. ' . number_format((float)$guardian['annual_income']) : 'N/A' ?></dd>
                        </div>
                    </dl>
                </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
