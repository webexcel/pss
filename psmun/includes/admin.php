<?php
/**
 * Admin helpers - registration list filters (shared by list page and export)
 */

require_once __DIR__ . '/functions.php';

/**
 * Read filters from the query string. Defaults to paid registrations only.
 */
function getRegistrationFilters(): array {
    $type = $_GET['type'] ?? '';
    $status = $_GET['status'] ?? 'COMPLETED';

    return [
        'type' => in_array($type, [MUN_TYPE_INTERNAL, MUN_TYPE_EXTERNAL], true) ? $type : '',
        'status' => in_array($status, ['COMPLETED', 'START', 'FAILED', 'ALL'], true) ? $status : 'COMPLETED',
        'q' => cleanText($_GET['q'] ?? '', 100),
    ];
}

/**
 * Fetch registrations matching the filters, newest first
 */
function fetchRegistrations(array $filters): array {
    $where = [];
    $params = [];

    if ($filters['type'] !== '') {
        $where[] = 'student_type = ?';
        $params[] = $filters['type'];
    }
    if ($filters['status'] !== 'ALL') {
        $where[] = 'status = ?';
        $params[] = $filters['status'];
    }
    if ($filters['q'] !== '') {
        $where[] = '(school_name LIKE ? OR branch LIKE ? OR contact_name LIKE ? OR mobile LIKE ? OR email LIKE ?
                     OR adno LIKE ? OR payment_id LIKE ? OR receipt LIKE ? OR delegates LIKE ?)';
        $like = '%' . $filters['q'] . '%';
        array_push($params, $like, $like, $like, $like, $like, $like, $like, $like, $like);
    }

    $sql = 'SELECT * FROM psmun_fee_payments'
        . ($where ? ' WHERE ' . implode(' AND ', $where) : '')
        . ' ORDER BY id DESC';

    $stmt = getDBConnection()->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetchAll();

    foreach ($rows as &$row) {
        $row['delegate_list'] = json_decode($row['delegates'], true) ?: [];
    }
    return $rows;
}

/**
 * Totals for paid registrations (ignores filters)
 */
function getRegistrationSummary(): array {
    $rows = getDBConnection()->query("
        SELECT student_type, COUNT(*) AS bookings, SUM(delegate_count) AS delegates, SUM(amount) AS amount
        FROM psmun_fee_payments
        WHERE status = 'COMPLETED'
        GROUP BY student_type
    ")->fetchAll();

    $summary = [
        MUN_TYPE_INTERNAL => ['bookings' => 0, 'delegates' => 0, 'amount' => 0],
        MUN_TYPE_EXTERNAL => ['bookings' => 0, 'delegates' => 0, 'amount' => 0],
    ];
    foreach ($rows as $row) {
        $summary[$row['student_type']] = [
            'bookings' => (int) $row['bookings'],
            'delegates' => (int) $row['delegates'],
            'amount' => (float) $row['amount'],
        ];
    }

    $summary['TOTAL'] = [
        'bookings' => $summary[MUN_TYPE_INTERNAL]['bookings'] + $summary[MUN_TYPE_EXTERNAL]['bookings'],
        'delegates' => $summary[MUN_TYPE_INTERNAL]['delegates'] + $summary[MUN_TYPE_EXTERNAL]['delegates'],
        'amount' => $summary[MUN_TYPE_INTERNAL]['amount'] + $summary[MUN_TYPE_EXTERNAL]['amount'],
    ];
    return $summary;
}
