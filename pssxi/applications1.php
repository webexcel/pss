<?php
/**
 * View Submitted Applications
 * Lists all submitted applications in a table
 */

$pageTitle = 'Submitted Applications';
$currentStep = 0;

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/api/Config/Database.php';

use Api\Config\Database;

// Get database connection
$db = Database::getInstance();

// Fetch all submitted applications with student data
$sql = "SELECT
            a.id,
            a.application_id,
            a.status,
            a.is_existing_student,
            a.submitted_at,
            a.created_at,
            s.full_name,
            s.gender,
            s.date_of_birth,
            s.class_applying,
            s.father_mobile,
            s.mother_mobile,
            s.parent_email
        FROM applications a
        LEFT JOIN students s ON a.id = s.application_id
        WHERE a.status = 'submitted'
        ORDER BY a.submitted_at DESC";

$applications = $db->fetchAll($sql);
?>

<main class="flex-grow w-full px-4 md:px-8 py-8">
    <div class="max-w-7xl mx-auto">

        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-2xl md:text-3xl font-black tracking-tight text-slate-900 dark:text-white">
                Submitted Applications
            </h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">
                Total: <?= count($applications) ?> application(s)
            </p>
        </div>

        <!-- Applications Table -->
        <div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <?php if (empty($applications)): ?>
                <div class="p-12 text-center">
                    <span class="material-symbols-outlined text-6xl text-slate-300 dark:text-slate-600 mb-4">folder_open</span>
                    <p class="text-slate-500 dark:text-slate-400 text-lg">No submitted applications yet</p>
                    <a href="step1.php" class="inline-block mt-4 text-primary hover:underline">Create a new application</a>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-700">
                                <th class="px-4 py-3 text-left font-semibold text-slate-700 dark:text-slate-300">#</th>
                                <th class="px-4 py-3 text-left font-semibold text-slate-700 dark:text-slate-300">Application ID</th>
                                <th class="px-4 py-3 text-left font-semibold text-slate-700 dark:text-slate-300">Student Name</th>
                                <th class="px-4 py-3 text-left font-semibold text-slate-700 dark:text-slate-300">Class</th>
                                <th class="px-4 py-3 text-left font-semibold text-slate-700 dark:text-slate-300">Gender</th>
                                <th class="px-4 py-3 text-left font-semibold text-slate-700 dark:text-slate-300">DOB</th>
                                <th class="px-4 py-3 text-left font-semibold text-slate-700 dark:text-slate-300">Contact</th>
                                <th class="px-4 py-3 text-left font-semibold text-slate-700 dark:text-slate-300">Submitted</th>
                                <th class="px-4 py-3 text-left font-semibold text-slate-700 dark:text-slate-300">Status</th>
                                <th class="px-4 py-3 text-center font-semibold text-slate-700 dark:text-slate-300">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
                            <?php foreach ($applications as $index => $app): ?>
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                                <td class="px-4 py-3 text-slate-500 dark:text-slate-400">
                                    <?= $index + 1 ?>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="font-mono text-primary font-medium"><?= e($app['application_id']) ?></span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="font-medium text-slate-900 dark:text-white"><?= e($app['full_name'] ?? 'N/A') ?></span>
                                </td>
                                <td class="px-4 py-3 text-slate-600 dark:text-slate-300">
                                    <?= e($app['class_applying'] ?? 'N/A') ?>
                                </td>
                                <td class="px-4 py-3 text-slate-600 dark:text-slate-300">
                                    <?= e($app['gender'] ?? 'N/A') ?>
                                </td>
                                <td class="px-4 py-3 text-slate-600 dark:text-slate-300">
                                    <?= $app['date_of_birth'] ? date('d/m/Y', strtotime($app['date_of_birth'])) : 'N/A' ?>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-xs">
                                        <div class="text-slate-600 dark:text-slate-300"><?= e($app['father_mobile'] ?? '') ?></div>
                                        <div class="text-slate-400 dark:text-slate-500"><?= e($app['parent_email'] ?? '') ?></div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-slate-500 dark:text-slate-400 text-xs">
                                    <?= $app['submitted_at'] ? date('d M Y, h:i A', strtotime($app['submitted_at'])) : 'N/A' ?>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                        <?php if ($app['status'] === 'submitted'): ?>
                                            bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400
                                        <?php elseif ($app['status'] === 'confirmed'): ?>
                                            bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400
                                        <?php else: ?>
                                            bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300
                                        <?php endif; ?>">
                                        <?= ucfirst($app['status']) ?>
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="view-application.php?id=<?= e($app['application_id']) ?>"
                                           class="p-1.5 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-500 hover:text-primary transition-colors"
                                           title="View Details">
                                            <span class="material-symbols-outlined text-lg">visibility</span>
                                        </a>
                                        <a href="download-pdf.php?id=<?= e($app['application_id']) ?>"
                                           class="p-1.5 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-500 hover:text-green-600 transition-colors"
                                           title="Download PDF">
                                            <span class="material-symbols-outlined text-lg">download</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
