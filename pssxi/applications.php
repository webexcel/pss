<?php
/**
 * View Submitted Applications
 * Lists all submitted applications grouped by class with selection checkboxes
 */

$pageTitle = 'Submitted Applications';
$currentStep = 0;

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/api/Config/Database.php';

use Api\Config\Database;

// Get database connection
$db = Database::getInstance();

// Handle AJAX request to update sel_list or form_submit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');

    if ($_POST['action'] === 'update_selection') {
        $appId = (int) ($_POST['app_id'] ?? 0);
        $selected = (int) ($_POST['selected'] ?? 0);

        if ($appId > 0) {
            $sql = "UPDATE applications SET sel_list = :selected, sel_date = NOW() WHERE id = :id";
            $db->execute($sql, ['selected' => $selected, 'id' => $appId]);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid ID']);
        }
    } elseif ($_POST['action'] === 'update_form_submit') {
        $appId = (int) ($_POST['app_id'] ?? 0);
        $formSubmit = $_POST['form_submit'] === 'Y' ? 'Y' : 'N';

        if ($appId > 0) {
            $sql = "UPDATE applications SET form_submit = :form_submit, form_date = NOW() WHERE id = :id";
            $db->execute($sql, ['form_submit' => $formSubmit, 'id' => $appId]);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid ID']);
        }
    } elseif ($_POST['action'] === 'bulk_update') {
        $ids = json_decode($_POST['ids'] ?? '[]', true);
        $selected = (int) ($_POST['selected'] ?? 0);

        if (!empty($ids)) {
            $placeholders = implode(',', array_fill(0, count($ids), '?'));
            $sql = "UPDATE applications SET sel_list = ?, sel_date = NOW() WHERE id IN ($placeholders)";
            $params = array_merge([$selected], $ids);
            $db->getConnection()->prepare($sql)->execute($params);
            echo json_encode(['success' => true, 'updated' => count($ids)]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No IDs provided']);
        }
    } elseif ($_POST['action'] === 'bulk_update_form') {
        $ids = json_decode($_POST['ids'] ?? '[]', true);
        $formSubmit = $_POST['form_submit'] === 'Y' ? 'Y' : 'N';

        if (!empty($ids)) {
            $placeholders = implode(',', array_fill(0, count($ids), '?'));
            $sql = "UPDATE applications SET form_submit = ?, form_date = NOW() WHERE id IN ($placeholders)";
            $params = array_merge([$formSubmit], $ids);
            $db->getConnection()->prepare($sql)->execute($params);
            echo json_encode(['success' => true, 'updated' => count($ids)]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No IDs provided']);
        }
    }
    exit;
}

// Get filter parameters
$filterClass = $_GET['class'] ?? '';
$filterSelStatus = $_GET['sel_status'] ?? '';
$filterFormStatus = $_GET['form_status'] ?? '';
$searchQuery = $_GET['search'] ?? '';

// Build query with filters
$whereConditions = ["a.status = 'submitted'"];
$params = [];

if ($filterClass) {
    $whereConditions[] = "s.class_applying = :class";
    $params['class'] = $filterClass;
}

if ($filterSelStatus !== '') {
    $whereConditions[] = "a.sel_list = :sel_status";
    $params['sel_status'] = (int) $filterSelStatus;
}

if ($filterFormStatus !== '') {
    $whereConditions[] = "a.form_submit = :form_status";
    $params['form_status'] = $filterFormStatus;
}

if ($searchQuery) {
    $whereConditions[] = "(s.full_name LIKE :search OR a.application_id LIKE :search OR s.father_mobile LIKE :search OR s.mother_mobile LIKE :search OR s.parent_email LIKE :search)";
    $params['search'] = '%' . $searchQuery . '%';
}

$whereClause = implode(' AND ', $whereConditions);

// Fetch all submitted applications with student data
$sql = "SELECT
            a.id,
            a.application_id,
            a.status,
            a.sel_list,
            a.sel_date,
            a.form_submit,
            a.form_date,
            a.is_existing_student,
            a.submitted_at,
            a.created_at,
            s.full_name,
            s.gender,
            s.date_of_birth,
            s.class_applying,
            s.community,
            s.father_mobile,
            s.mother_mobile,
            s.parent_email
        FROM applications a
        LEFT JOIN students s ON a.id = s.application_id
        WHERE $whereClause
        ORDER BY s.class_applying ASC, a.submitted_at DESC";

$applications = $db->fetchAll($sql, $params);

// Group applications by class
$groupedApps = [];
foreach ($applications as $app) {
    $class = $app['class_applying'] ?? 'Unknown';
    if (!isset($groupedApps[$class])) {
        $groupedApps[$class] = [];
    }
    $groupedApps[$class][] = $app;
}

// Get class counts for filter dropdown
$classCounts = $db->fetchAll("
    SELECT s.class_applying, COUNT(*) as count
    FROM applications a
    LEFT JOIN students s ON a.id = s.application_id
    WHERE a.status = 'submitted'
    GROUP BY s.class_applying
    ORDER BY s.class_applying
");

// Count statistics
$totalSelected = 0;
$totalUnselected = 0;
$totalMoved = 0;
$totalWait = 0;
$totalCallInterview = 0;
$totalFormY = 0;
$totalFormN = 0;
foreach ($applications as $app) {
    if ($app['sel_list'] == 1) {
        $totalSelected++;
    } elseif ($app['sel_list'] == 2) {
        $totalMoved++;
    } elseif ($app['sel_list'] == 3) {
        $totalWait++;
    } elseif ($app['sel_list'] == 4) {
        $totalCallInterview++;
    } else {
        $totalUnselected++;
    }
    if ($app['form_submit'] === 'Y') {
        $totalFormY++;
    } else {
        $totalFormN++;
    }
}
?>

<main class="flex-grow w-full px-4 md:px-8 py-8">
    <div class="max-w-7xl mx-auto">

        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-2xl md:text-3xl font-black tracking-tight text-slate-900 dark:text-white mb-4">
                Submitted Applications
            </h1>

            <!-- Statistics Table -->
            <div class="bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden mb-4">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-700">
                            <th class="px-4 py-2 text-left font-semibold text-slate-700 dark:text-slate-300">Total</th>
                            <th class="px-4 py-2 text-center font-semibold text-green-600 dark:text-green-400">Selected</th>
                            <th class="px-4 py-2 text-center font-semibold text-orange-600 dark:text-orange-400">Pending</th>
                            <th class="px-4 py-2 text-center font-semibold text-cyan-600 dark:text-cyan-400">Moved</th>
                            <th class="px-4 py-2 text-center font-semibold text-yellow-600 dark:text-yellow-400">Wait</th>
                            <th class="px-4 py-2 text-center font-semibold text-purple-600 dark:text-purple-400">Call Interview</th>
                            <th class="px-4 py-2 text-center font-semibold text-blue-600 dark:text-blue-400">Form Submitted</th>
                            <th class="px-4 py-2 text-center font-semibold text-red-600 dark:text-red-400">Form Pending</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="px-4 py-3 text-left font-bold text-slate-900 dark:text-white"><?= count($applications) ?></td>
                            <td class="px-4 py-3 text-center font-semibold text-green-600 dark:text-green-400"><?= $totalSelected ?></td>
                            <td class="px-4 py-3 text-center font-semibold text-orange-600 dark:text-orange-400"><?= $totalUnselected ?></td>
                            <td class="px-4 py-3 text-center font-semibold text-cyan-600 dark:text-cyan-400"><?= $totalMoved ?></td>
                            <td class="px-4 py-3 text-center font-semibold text-yellow-600 dark:text-yellow-400"><?= $totalWait ?></td>
                            <td class="px-4 py-3 text-center font-semibold text-purple-600 dark:text-purple-400"><?= $totalCallInterview ?></td>
                            <td class="px-4 py-3 text-center font-semibold text-blue-600 dark:text-blue-400"><?= $totalFormY ?></td>
                            <td class="px-4 py-3 text-center font-semibold text-red-600 dark:text-red-400"><?= $totalFormN ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Filters -->
            <div class="flex flex-wrap gap-3">
                <!-- Search Box -->
                <div class="relative flex-grow max-w-md">
                    <input type="text" id="search-input"
                           value="<?= e($searchQuery) ?>"
                           placeholder="Search by name, ID, mobile, or email..."
                           class="w-full rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-sm h-10 pl-10 pr-3 focus:ring-2 focus:ring-primary focus:border-primary"
                           oninput="searchDebounce()"
                           onkeypress="if(event.key === 'Enter') applyFilters()">
                    <span class="material-symbols-outlined absolute left-3 top-2.5 text-slate-400 text-lg pointer-events-none">search</span>
                </div>

                <select id="filter-class" onchange="applyFilters()"
                        class="form-select rounded-lg border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm h-10 px-3">
                    <option value="">All Classes</option>
                    <?php foreach ($classCounts as $cc): ?>
                    <option value="<?= e($cc['class_applying']) ?>" <?= $filterClass === $cc['class_applying'] ? 'selected' : '' ?>>
                        Class <?= e($cc['class_applying']) ?> (<?= $cc['count'] ?>)
                    </option>
                    <?php endforeach; ?>
                </select>

                <select id="filter-sel-status" onchange="applyFilters()"
                        class="form-select rounded-lg border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm h-10 px-3">
                    <option value="">Selection Status</option>
                    <option value="1" <?= $filterSelStatus === '1' ? 'selected' : '' ?>>Selected</option>
                    <option value="0" <?= $filterSelStatus === '0' ? 'selected' : '' ?>>Pending</option>
                    <option value="2" <?= $filterSelStatus === '2' ? 'selected' : '' ?>>Moved</option>
                    <option value="3" <?= $filterSelStatus === '3' ? 'selected' : '' ?>>Wait</option>
                    <option value="4" <?= $filterSelStatus === '4' ? 'selected' : '' ?>>Call Interview</option>
                </select>

                <select id="filter-form-status" onchange="applyFilters()"
                        class="form-select rounded-lg border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm h-10 px-3">
                    <option value="">Form Status</option>
                    <option value="Y" <?= $filterFormStatus === 'Y' ? 'selected' : '' ?>>Form Submitted</option>
                    <option value="N" <?= $filterFormStatus === 'N' ? 'selected' : '' ?>>Form Pending</option>
                </select>

                <button onclick="clearFilters()" class="px-4 py-2 text-sm text-slate-600 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">close</span>
                    Clear Filters
                </button>
            </div>
        </div>

        <!-- Bulk Actions -->
        <div id="bulk-actions" class="hidden mb-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800 flex flex-col md:flex-row items-start md:items-center justify-between gap-3">
            <span class="text-blue-700 dark:text-blue-300 text-sm">
                <span id="selected-count">0</span> application(s) selected
            </span>
            <div class="flex flex-wrap gap-2">
                <button onclick="bulkUpdate(1)" class="px-4 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition-colors">
                    Mark Selected
                </button>
                <button onclick="bulkUpdate(0)" class="px-4 py-2 bg-orange-600 text-white text-sm rounded-lg hover:bg-orange-700 transition-colors">
                    Mark Pending
                </button>
                <button onclick="bulkUpdate(2)" class="px-4 py-2 bg-cyan-600 text-white text-sm rounded-lg hover:bg-cyan-700 transition-colors">
                    Mark Moved
                </button>
                <button onclick="bulkUpdate(3)" class="px-4 py-2 bg-yellow-600 text-white text-sm rounded-lg hover:bg-yellow-700 transition-colors">
                    Mark Wait
                </button>
                <button onclick="bulkUpdate(4)" class="px-4 py-2 bg-purple-600 text-white text-sm rounded-lg hover:bg-purple-700 transition-colors">
                    Mark Call Interview
                </button>
                <button onclick="bulkUpdateForm('Y')" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors">
                    Form = Y
                </button>
                <button onclick="bulkUpdateForm('N')" class="px-4 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition-colors">
                    Form = N
                </button>
                <button onclick="clearSelection()" class="px-4 py-2 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 text-sm rounded-lg hover:bg-slate-300 dark:hover:bg-slate-600 transition-colors">
                    Clear
                </button>
            </div>
        </div>

        <?php if (!empty($searchQuery) || $filterClass || $filterSelStatus !== '' || $filterFormStatus !== ''): ?>
            <div class="mb-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border-2 border-blue-300 dark:border-blue-700">
                <div class="flex items-start justify-between">
                    <p class="text-blue-700 dark:text-blue-300 text-sm flex flex-wrap items-center gap-2">
                        <span class="material-symbols-outlined text-lg">filter_alt</span>
                        <span class="font-semibold">Active filters:</span>
                        <?php if ($searchQuery): ?>
                            <span class="px-2 py-1 bg-blue-100 dark:bg-blue-800 rounded font-medium">Search: "<?= e($searchQuery) ?>"</span>
                        <?php endif; ?>
                        <?php if ($filterClass): ?>
                            <span class="px-2 py-1 bg-blue-100 dark:bg-blue-800 rounded font-medium">Class: <?= e($filterClass) ?></span>
                        <?php endif; ?>
                        <?php if ($filterSelStatus !== ''): ?>
                            <span class="px-2 py-1 bg-blue-100 dark:bg-blue-800 rounded font-medium">Selection: <?= ['Pending', 'Selected', 'Moved', 'Wait', 'Call Interview'][$filterSelStatus] ?? 'Unknown' ?></span>
                        <?php endif; ?>
                        <?php if ($filterFormStatus !== ''): ?>
                            <span class="px-2 py-1 bg-blue-100 dark:bg-blue-800 rounded font-medium">Form: <?= $filterFormStatus ?></span>
                        <?php endif; ?>
                        <span class="text-blue-600 dark:text-blue-400">→ Showing <?= count($applications) ?> result(s)</span>
                    </p>
                    <button onclick="clearFilters()" class="ml-4 px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition-colors flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">close</span>
                        Clear
                    </button>
                </div>
            </div>
        <?php endif; ?>

        <?php if (empty($applications)): ?>
            <div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm p-12 text-center">
                <span class="material-symbols-outlined text-6xl text-slate-300 dark:text-slate-600 mb-4">folder_open</span>
                <p class="text-slate-500 dark:text-slate-400 text-lg">No applications found</p>
                <?php if ($searchQuery || $filterClass || $filterSelStatus !== '' || $filterFormStatus !== ''): ?>
                    <p class="text-slate-400 text-sm mt-2">Try adjusting your search or filters</p>
                    <button onclick="clearFilters()" class="inline-block mt-4 px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90">
                        Clear Filters
                    </button>
                <?php else: ?>
                    <a href="step1.php" class="inline-block mt-4 text-primary hover:underline">Create a new application</a>
                <?php endif; ?>
            </div>
        <?php else: ?>

            <!-- Grouped by Class -->
            <?php foreach ($groupedApps as $class => $apps): ?>
            <div class="mb-6">
                <!-- Class Header -->
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-lg font-bold text-slate-800 dark:text-slate-200 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">school</span>
                        Class <?= e($class) ?>
                        <span class="ml-2 px-2 py-0.5 text-xs font-medium bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-full">
                            <?= count($apps) ?> application(s)
                        </span>
                    </h2>
                    <div class="flex items-center gap-2">
                        <label class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400 cursor-pointer">
                            <input type="checkbox" class="select-all-class rounded border-slate-300 dark:border-slate-600 text-primary focus:ring-primary"
                                   data-class="<?= e($class) ?>" onchange="toggleClassSelection(this)">
                            Select All
                        </label>
                    </div>
                </div>

                <!-- Applications Table -->
                <div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-700">
                                    <th class="px-3 py-3 text-center w-10">
                                        <span class="sr-only">Select</span>
                                    </th>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-700 dark:text-slate-300">Application ID</th>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-700 dark:text-slate-300">Student Name</th>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-700 dark:text-slate-300">Gender</th>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-700 dark:text-slate-300">Community</th>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-700 dark:text-slate-300">DOB</th>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-700 dark:text-slate-300">Contact</th>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-700 dark:text-slate-300">Submitted</th>
                                    <th class="px-4 py-3 text-center font-semibold text-slate-700 dark:text-slate-300">Selection</th>
                                    <th class="px-4 py-3 text-center font-semibold text-slate-700 dark:text-slate-300">Form Status</th>
                                    <th class="px-4 py-3 text-center font-semibold text-slate-700 dark:text-slate-300">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
                                <?php foreach ($apps as $app):
                                    $rowBgClass = '';
                                    if ($app['sel_list'] == 1) {
                                        $rowBgClass = 'bg-green-50/50 dark:bg-green-900/10';
                                    } elseif ($app['sel_list'] == 2) {
                                        $rowBgClass = 'bg-cyan-50/50 dark:bg-cyan-900/10';
                                    } elseif ($app['sel_list'] == 3) {
                                        $rowBgClass = 'bg-yellow-50/50 dark:bg-yellow-900/10';
                                    } elseif ($app['sel_list'] == 4) {
                                        $rowBgClass = 'bg-purple-50/50 dark:bg-purple-900/10';
                                    }
                                ?>
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors <?= $rowBgClass ?>"
                                    data-id="<?= $app['id'] ?>" data-class="<?= e($class) ?>">
                                    <td class="px-3 py-3 text-center">
                                        <input type="checkbox" class="app-checkbox rounded border-slate-300 dark:border-slate-600 text-primary focus:ring-primary"
                                               data-id="<?= $app['id'] ?>" data-class="<?= e($class) ?>" onchange="updateBulkActions()">
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="font-mono text-primary font-medium"><?= e($app['application_id']) ?></span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="font-medium text-slate-900 dark:text-white"><?= e($app['full_name'] ?? 'N/A') ?></span>
                                    </td>
                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-300">
                                        <?= e($app['gender'] ?? 'N/A') ?>
                                    </td>
                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-300">
                                        <?= e($app['community'] ?? 'N/A') ?>
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
                                    <td class="px-4 py-3 text-center">
                                        <button onclick="toggleSelection(<?= $app['id'] ?>, this)"
                                                class="selection-btn px-3 py-1.5 rounded-full text-xs font-medium transition-all
                                                <?php
                                                    if ($app['sel_list'] == 1) {
                                                        echo 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 hover:bg-green-200';
                                                    } elseif ($app['sel_list'] == 2) {
                                                        echo 'bg-cyan-100 text-cyan-700 dark:bg-cyan-900/30 dark:text-cyan-400 hover:bg-cyan-200';
                                                    } elseif ($app['sel_list'] == 3) {
                                                        echo 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400 hover:bg-yellow-200';
                                                    } elseif ($app['sel_list'] == 4) {
                                                        echo 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400 hover:bg-purple-200';
                                                    } else {
                                                        echo 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400 hover:bg-orange-200';
                                                    }
                                                ?>"
                                                data-selected="<?= $app['sel_list'] ?>">
                                            <?php
                                                if ($app['sel_list'] == 1) {
                                                    echo 'Selected';
                                                } elseif ($app['sel_list'] == 2) {
                                                    echo 'Moved';
                                                } elseif ($app['sel_list'] == 3) {
                                                    echo 'Wait';
                                                } elseif ($app['sel_list'] == 4) {
                                                    echo 'Call Interview';
                                                } else {
                                                    echo 'Pending';
                                                }
                                            ?>
                                        </button>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <button onclick="toggleFormSubmit(<?= $app['id'] ?>, this)"
                                                class="form-btn px-3 py-1.5 rounded-full text-xs font-medium transition-all
                                                <?= $app['form_submit'] === 'Y'
                                                    ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 hover:bg-blue-200'
                                                    : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 hover:bg-red-200' ?>"
                                                data-form="<?= $app['form_submit'] ?>">
                                            <?= $app['form_submit'] === 'Y' ? 'Y' : 'N' ?>
                                        </button>
                                        <?php if ($app['form_submit'] === 'Y' && $app['form_date']): ?>
                                        <div class="text-xs text-slate-400 mt-1"><?= date('d/m/y', strtotime($app['form_date'])) ?></div>
                                        <?php endif; ?>
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
                </div>
            </div>
            <?php endforeach; ?>

        <?php endif; ?>

    </div>
</main>

<script>
// Debounce timer for search
let searchTimeout;

// Debounce search input to avoid too many requests
function searchDebounce() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        applyFilters();
    }, 800); // Wait 800ms after user stops typing
}

// Filter functions
function applyFilters() {
    const searchInput = document.getElementById('search-input').value;
    const classFilter = document.getElementById('filter-class').value;
    const selStatus = document.getElementById('filter-sel-status').value;
    const formStatus = document.getElementById('filter-form-status').value;

    let url = 'applications.php?';
    const params = [];

    if (searchInput) params.push('search=' + encodeURIComponent(searchInput));
    if (classFilter) params.push('class=' + encodeURIComponent(classFilter));
    if (selStatus !== '') params.push('sel_status=' + selStatus);
    if (formStatus !== '') params.push('form_status=' + formStatus);

    window.location.href = url + params.join('&');
}

function clearFilters() {
    window.location.href = 'applications.php';
}

// Toggle single selection - cycles through 0 -> 1 -> 2 -> 3 -> 4 -> 0
async function toggleSelection(appId, btn) {
    const currentSelected = parseInt(btn.dataset.selected);
    let newSelected;

    // Cycle through: Pending (0) -> Selected (1) -> Moved (2) -> Wait (3) -> Call Interview (4) -> Pending (0)
    if (currentSelected === 0) {
        newSelected = 1;
    } else if (currentSelected === 1) {
        newSelected = 2;
    } else if (currentSelected === 2) {
        newSelected = 3;
    } else if (currentSelected === 3) {
        newSelected = 4;
    } else {
        newSelected = 0;
    }

    btn.disabled = true;
    btn.innerHTML = '<span class="spinner"></span>';

    try {
        const formData = new FormData();
        formData.append('action', 'update_selection');
        formData.append('app_id', appId);
        formData.append('selected', newSelected);

        const response = await fetch('applications.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (result.success) {
            btn.dataset.selected = newSelected;

            // Set text based on status
            let statusText, statusClass;
            if (newSelected === 1) {
                statusText = 'Selected';
                statusClass = 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 hover:bg-green-200';
            } else if (newSelected === 2) {
                statusText = 'Moved';
                statusClass = 'bg-cyan-100 text-cyan-700 dark:bg-cyan-900/30 dark:text-cyan-400 hover:bg-cyan-200';
            } else if (newSelected === 3) {
                statusText = 'Wait';
                statusClass = 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400 hover:bg-yellow-200';
            } else if (newSelected === 4) {
                statusText = 'Call Interview';
                statusClass = 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400 hover:bg-purple-200';
            } else {
                statusText = 'Pending';
                statusClass = 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400 hover:bg-orange-200';
            }

            btn.innerHTML = statusText;
            btn.className = 'selection-btn px-3 py-1.5 rounded-full text-xs font-medium transition-all ' + statusClass;

            // Update row background
            const row = btn.closest('tr');
            row.classList.remove('bg-green-50/50', 'dark:bg-green-900/10', 'bg-cyan-50/50', 'dark:bg-cyan-900/10', 'bg-yellow-50/50', 'dark:bg-yellow-900/10', 'bg-purple-50/50', 'dark:bg-purple-900/10');

            if (newSelected === 1) {
                row.classList.add('bg-green-50/50', 'dark:bg-green-900/10');
            } else if (newSelected === 2) {
                row.classList.add('bg-cyan-50/50', 'dark:bg-cyan-900/10');
            } else if (newSelected === 3) {
                row.classList.add('bg-yellow-50/50', 'dark:bg-yellow-900/10');
            } else if (newSelected === 4) {
                row.classList.add('bg-purple-50/50', 'dark:bg-purple-900/10');
            }

            showToast('Selection updated', 'success');
        } else {
            showToast('Failed to update', 'error');
        }
    } catch (error) {
        showToast('Error: ' + error.message, 'error');
    }

    btn.disabled = false;
}

// Toggle form submit status
async function toggleFormSubmit(appId, btn) {
    const currentForm = btn.dataset.form;
    const newForm = currentForm === 'Y' ? 'N' : 'Y';

    btn.disabled = true;
    btn.innerHTML = '<span class="spinner"></span>';

    try {
        const formData = new FormData();
        formData.append('action', 'update_form_submit');
        formData.append('app_id', appId);
        formData.append('form_submit', newForm);

        const response = await fetch('applications.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (result.success) {
            btn.dataset.form = newForm;
            btn.innerHTML = newForm;
            btn.className = 'form-btn px-3 py-1.5 rounded-full text-xs font-medium transition-all ' +
                (newForm === 'Y'
                    ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 hover:bg-blue-200'
                    : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 hover:bg-red-200');

            showToast('Form status updated', 'success');
        } else {
            showToast('Failed to update', 'error');
        }
    } catch (error) {
        showToast('Error: ' + error.message, 'error');
    }

    btn.disabled = false;
}

// Bulk selection functions
function updateBulkActions() {
    const checked = document.querySelectorAll('.app-checkbox:checked');
    const bulkActions = document.getElementById('bulk-actions');
    const selectedCount = document.getElementById('selected-count');

    if (checked.length > 0) {
        bulkActions.classList.remove('hidden');
        selectedCount.textContent = checked.length;
    } else {
        bulkActions.classList.add('hidden');
    }
}

function toggleClassSelection(checkbox) {
    const className = checkbox.dataset.class;
    const classCheckboxes = document.querySelectorAll(`.app-checkbox[data-class="${className}"]`);

    classCheckboxes.forEach(cb => {
        cb.checked = checkbox.checked;
    });

    updateBulkActions();
}

async function bulkUpdate(selected) {
    const checked = document.querySelectorAll('.app-checkbox:checked');
    const ids = Array.from(checked).map(cb => parseInt(cb.dataset.id));

    if (ids.length === 0) return;

    try {
        const formData = new FormData();
        formData.append('action', 'bulk_update');
        formData.append('ids', JSON.stringify(ids));
        formData.append('selected', selected);

        const response = await fetch('applications.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (result.success) {
            showToast(`Updated ${result.updated} application(s)`, 'success');
            setTimeout(() => window.location.reload(), 500);
        } else {
            showToast('Failed to update', 'error');
        }
    } catch (error) {
        showToast('Error: ' + error.message, 'error');
    }
}

async function bulkUpdateForm(formSubmit) {
    const checked = document.querySelectorAll('.app-checkbox:checked');
    const ids = Array.from(checked).map(cb => parseInt(cb.dataset.id));

    if (ids.length === 0) return;

    try {
        const formData = new FormData();
        formData.append('action', 'bulk_update_form');
        formData.append('ids', JSON.stringify(ids));
        formData.append('form_submit', formSubmit);

        const response = await fetch('applications.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (result.success) {
            showToast(`Updated ${result.updated} application(s)`, 'success');
            setTimeout(() => window.location.reload(), 500);
        } else {
            showToast('Failed to update', 'error');
        }
    } catch (error) {
        showToast('Error: ' + error.message, 'error');
    }
}

function clearSelection() {
    document.querySelectorAll('.app-checkbox').forEach(cb => cb.checked = false);
    document.querySelectorAll('.select-all-class').forEach(cb => cb.checked = false);
    updateBulkActions();
}

// Toast notification
function showToast(message, type = 'success') {
    const container = document.getElementById('toast-container');
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.textContent = message;
    container.appendChild(toast);

    setTimeout(() => toast.classList.add('show'), 10);
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}
</script>

<style>
.spinner {
    border: 2px solid #f3f3f3;
    border-top: 2px solid currentColor;
    border-radius: 50%;
    width: 14px;
    height: 14px;
    animation: spin 0.6s linear infinite;
    display: inline-block;
}
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
