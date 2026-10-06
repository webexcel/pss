<?php
/**
 * Admin - Clarion PSMUN Registrations
 */

require_once dirname(__DIR__) . '/includes/admin.php';

requireAdmin();

$filters = getRegistrationFilters();
$registrations = fetchRegistrations($filters);
$summary = getRegistrationSummary();
$csrfToken = generateCSRFToken();

$flash = $_SESSION['psmun_flash'] ?? null;
unset($_SESSION['psmun_flash']);

$exportUrl = 'export.php?' . http_build_query($filters);
$typeLabels = [MUN_TYPE_INTERNAL => 'Our School', MUN_TYPE_EXTERNAL => 'Other School'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSMUN Registrations - Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <header class="topbar">
        <div>
            <h1><?= e(MUN_EVENT_NAME) ?> &middot; Registrations</h1>
            <p><?= e(MUN_EDITION) ?> &middot; <?= formatAmount(MUN_FEE_PER_DELEGATE_DISPLAY) ?> per delegate</p>
        </div>
        <a href="../../admin/index.php" class="topbar-link">&larr; Admin Dashboard</a>
    </header>

    <main class="page">
        <?php if ($flash): ?>
            <div class="flash flash-<?= e($flash['type']) ?>"><?= e($flash['message']) ?></div>
        <?php endif; ?>

        <section class="stats">
            <div class="stat">
                <span class="stat-label">Total Collected</span>
                <strong class="stat-value"><?= formatAmount($summary['TOTAL']['amount']) ?></strong>
                <span class="stat-sub"><?= $summary['TOTAL']['delegates'] ?> delegates &middot; <?= $summary['TOTAL']['bookings'] ?> payments</span>
            </div>
            <div class="stat">
                <span class="stat-label">Our School</span>
                <strong class="stat-value"><?= $summary[MUN_TYPE_INTERNAL]['delegates'] ?></strong>
                <span class="stat-sub"><?= formatAmount($summary[MUN_TYPE_INTERNAL]['amount']) ?></span>
            </div>
            <div class="stat">
                <span class="stat-label">Other Schools</span>
                <strong class="stat-value"><?= $summary[MUN_TYPE_EXTERNAL]['delegates'] ?></strong>
                <span class="stat-sub"><?= $summary[MUN_TYPE_EXTERNAL]['bookings'] ?> bookings &middot; <?= formatAmount($summary[MUN_TYPE_EXTERNAL]['amount']) ?></span>
            </div>
        </section>

        <form class="filters" method="get">
            <input type="search" name="q" value="<?= e($filters['q']) ?>" placeholder="Search name, school, mobile, email, payment ID...">
            <select name="type">
                <option value="">All students</option>
                <?php foreach ($typeLabels as $value => $label): ?>
                    <option value="<?= $value ?>" <?= $filters['type'] === $value ? 'selected' : '' ?>><?= $label ?></option>
                <?php endforeach; ?>
            </select>
            <select name="status">
                <?php foreach (['COMPLETED' => 'Paid', 'START' => 'Not paid (abandoned)', 'FAILED' => 'Failed', 'ALL' => 'All statuses'] as $value => $label): ?>
                    <option value="<?= $value ?>" <?= $filters['status'] === $value ? 'selected' : '' ?>><?= $label ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn">Filter</button>
            <a href="index.php" class="btn btn-ghost">Reset</a>
            <a href="<?= e($exportUrl) ?>" class="btn btn-export">Export to Excel</a>
        </form>

        <p class="result-count"><?= count($registrations) ?> record(s)</p>

        <div class="table-wrap">
            <table class="reg-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Type</th>
                        <th>School / Student</th>
                        <th>Delegates</th>
                        <th>Contact</th>
                        <th class="num">Amount</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!$registrations): ?>
                    <tr><td colspan="9" class="empty">No registrations found.</td></tr>
                <?php endif; ?>

                <?php foreach ($registrations as $reg): ?>
                    <tr>
                        <td class="muted"><?= (int) $reg['id'] ?></td>
                        <td><span class="badge badge-<?= strtolower($reg['student_type']) ?>"><?= $typeLabels[$reg['student_type']] ?></span></td>
                        <td>
                            <?php if ($reg['student_type'] === MUN_TYPE_INTERNAL): ?>
                                <strong><?= e($reg['delegate_list'][0]['name'] ?? $reg['contact_name']) ?></strong>
                                <div class="muted">Adm. <?= e($reg['adno']) ?> &middot; <?= e($reg['delegate_list'][0]['class'] ?? '') ?></div>
                            <?php else: ?>
                                <strong><?= e($reg['school_name']) ?></strong>
                                <?php if ($reg['branch']): ?><div class="muted"><?= e($reg['branch']) ?></div><?php endif; ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($reg['student_type'] === MUN_TYPE_EXTERNAL): ?>
                                <details>
                                    <summary><?= (int) $reg['delegate_count'] ?> delegate(s)</summary>
                                    <ol class="delegates">
                                        <?php foreach ($reg['delegate_list'] as $delegate): ?>
                                            <li><?= e($delegate['name']) ?> <span class="muted">(<?= e($delegate['class']) ?>)</span></li>
                                        <?php endforeach; ?>
                                    </ol>
                                </details>
                            <?php else: ?>
                                1
                            <?php endif; ?>
                        </td>
                        <td>
                            <?= e($reg['contact_name']) ?>
                            <div class="muted"><?= e($reg['mobile']) ?></div>
                            <div class="muted"><?= e($reg['email']) ?></div>
                        </td>
                        <td class="num"><?= formatAmount((float) $reg['amount']) ?></td>
                        <td><span class="status status-<?= strtolower($reg['status']) ?>"><?= $reg['status'] === 'COMPLETED' ? 'Paid' : ($reg['status'] === 'START' ? 'Not paid' : ucfirst(strtolower($reg['status']))) ?></span></td>
                        <td>
                            <?php if ($reg['payment_id']): ?><code><?= e($reg['payment_id']) ?></code><?php endif; ?>
                            <div class="muted"><?= e(date('d M Y, h:i A', strtotime($reg['end_time'] ?? $reg['start_time']))) ?></div>
                        </td>
                        <td>
                            <?php if ($reg['status'] === 'COMPLETED'): ?>
                                <?php if ($reg['email_sent_at']): ?>
                                    <span class="muted" title="<?= e($reg['email_sent_at']) ?>">Sent</span>
                                <?php else: ?>
                                    <span class="warn">Not sent</span>
                                <?php endif; ?>
                                <form method="post" action="resend-email.php" class="inline-form">
                                    <input type="hidden" name="id" value="<?= (int) $reg['id'] ?>">
                                    <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
                                    <input type="hidden" name="return" value="<?= e($_SERVER['QUERY_STRING'] ?? '') ?>">
                                    <button type="submit" class="link-btn"><?= $reg['email_sent_at'] ? 'Resend' : 'Send' ?></button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
