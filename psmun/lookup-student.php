<?php
/**
 * Look up one of our students by admission number - AJAX Endpoint
 */

header('Content-Type: application/json');

require_once __DIR__ . '/includes/functions.php';

function jsonError(int $code, string $message): void {
    http_response_code($code);
    echo json_encode(['error' => $message]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonError(405, 'Method not allowed');
}

$input = json_decode(file_get_contents('php://input'), true);

if (!is_array($input) || !verifyCSRFToken((string) ($input['csrf_token'] ?? ''))) {
    jsonError(403, 'Your session has expired. Please refresh the page and try again.');
}

// Slow down guessing admission numbers: 20 lookups per 10 minutes per session
$now = time();
$_SESSION['psmun_lookups'] = array_filter($_SESSION['psmun_lookups'] ?? [], fn($t) => $t > $now - 600);
if (count($_SESSION['psmun_lookups']) >= 20) {
    jsonError(429, 'Too many attempts. Please wait a few minutes and try again.');
}
$_SESSION['psmun_lookups'][] = $now;

$student = findSchoolStudent((string) ($input['adno'] ?? ''));

if (!$student) {
    jsonError(404, 'Admission number not found. Please check and try again.');
}

echo json_encode([
    'success' => true,
    'adno' => $student['adno'],
    'name' => $student['name'],
    'class' => $student['class'],
    'mobile' => maskMobile($student['mobile']),
    'already_paid' => isInternalStudentRegistered($student['adno']),
]);
