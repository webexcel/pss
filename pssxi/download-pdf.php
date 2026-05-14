<?php

/**
 * PDF Download Handler
 *
 * Downloads the filled application PDF for a submitted application
 * URL: /download-pdf.php?id=ADM-2026-00001
 */

declare(strict_types=1);

// Error handling - enable display for debugging
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Load dependencies
require_once __DIR__ . '/api/Config/Database.php';
require_once __DIR__ . '/api/Models/Application.php';
require_once __DIR__ . '/api/Models/Student.php';
require_once __DIR__ . '/api/Models/ParentModel.php';
require_once __DIR__ . '/api/Config/PdfGenerator.php';

use Api\Config\PdfGenerator;
use Api\Models\Application;

// Get application ID from query string
$applicationId = $_GET['id'] ?? null;
$action = $_GET['action'] ?? 'download'; // 'download' or 'view'

if (!$applicationId) {
    http_response_code(400);
    die('Application ID is required');
}

try {
    // Find the application
    $applicationModel = new Application();
    $application = $applicationModel->findByApplicationId($applicationId);

    if (!$application) {
        http_response_code(404);
        die('Application not found: ' . htmlspecialchars($applicationId));
    }

    // Only allow PDF generation for submitted applications
    if ($application['status'] !== 'submitted') {
        http_response_code(403);
        die('PDF is only available for submitted applications');
    }

    // Get complete application data
    $data = $applicationModel->getCompleteData((int) $application['id']);

    if (!$data) {
        http_response_code(500);
        die('Failed to retrieve application data');
    }

    // Generate and output PDF
    $pdfGenerator = new PdfGenerator();
    $filename = 'Application_' . $applicationId . '.pdf';

    if ($action === 'view') {
        $pdfGenerator->view($data, $filename);
    } else {
        $pdfGenerator->download($data, $filename);
    }

} catch (\Exception $e) {
    error_log('PDF Generation Error: ' . $e->getMessage());
    http_response_code(500);
    die('Error generating PDF: ' . $e->getMessage());
}
