<?php
/**
 * Admin - Export registrations to Excel (CSV, one row per delegate)
 */

require_once dirname(__DIR__) . '/includes/admin.php';

requireAdmin();

$filters = getRegistrationFilters();
$registrations = fetchRegistrations($filters);

$filename = 'psmun-registrations-' . strtolower($filters['status']) . '-' . date('Y-m-d-His') . '.csv';

header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: no-store');

$out = fopen('php://output', 'w');

// UTF-8 BOM so Excel shows Tamil / special characters correctly
fwrite($out, "\xEF\xBB\xBF");

fputcsv($out, [
    'S.No', 'Delegate Name', 'Class', 'Type', 'Admission No.', 'School', 'Branch',
    'Contact Person', 'Mobile', 'Email', 'Delegates in Booking', 'Booking Amount (Rs)',
    'Status', 'Payment ID', 'Receipt No.', 'Paid On', 'Booking ID',
]);

/**
 * Stop Excel from treating user-entered text as a formula
 */
function csvCell($value): string {
    $value = (string) $value;
    if ($value !== '' && in_array($value[0], ['=', '+', '-', '@'], true)) {
        $value = "'" . $value;
    }
    return $value;
}

$serial = 0;
foreach ($registrations as $reg) {
    $delegates = $reg['delegate_list'] ?: [['name' => $reg['contact_name'], 'class' => '']];

    foreach ($delegates as $delegate) {
        fputcsv($out, array_map('csvCell', [
            ++$serial,
            $delegate['name'],
            $delegate['class'],
            $reg['student_type'] === MUN_TYPE_INTERNAL ? 'Our School' : 'Other School',
            $reg['adno'],
            $reg['student_type'] === MUN_TYPE_INTERNAL ? SCHOOL_NAME : $reg['school_name'],
            $reg['branch'],
            $reg['contact_name'],
            $reg['mobile'],
            $reg['email'],
            $reg['delegate_count'],
            $reg['amount'],
            $reg['status'] === 'COMPLETED' ? 'Paid' : $reg['status'],
            $reg['payment_id'],
            $reg['receipt'],
            $reg['end_time'] ? date('d-m-Y H:i', strtotime($reg['end_time'])) : '',
            $reg['id'],
        ]));
    }
}

fclose($out);
