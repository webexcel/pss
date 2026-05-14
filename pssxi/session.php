<?php
/**
 * Session Handler
 *
 * Stores application token in PHP session
 */

error_reporting(E_ALL);
ini_set('display_errors', '0');

session_start();

// Always set JSON header for POST/GET
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if it's JSON input (AJAX) or form POST
    $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

    if (strpos($contentType, 'application/json') !== false) {
        // AJAX request with JSON body
        $input = json_decode(file_get_contents('php://input'), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(['success' => false, 'message' => 'Invalid JSON']);
            exit;
        }

        if (isset($input['app_token'])) {
            $_SESSION['app_token'] = $input['app_token'];
        }

        if (isset($input['application_id'])) {
            $_SESSION['application_id'] = $input['application_id'];
        }

        if (isset($input['step1_data'])) {
            $_SESSION['step1_data'] = $input['step1_data'];
        }

        if (isset($input['step2_data'])) {
            $_SESSION['step2_data'] = $input['step2_data'];
        }

        echo json_encode(['success' => true, 'session' => [
            'app_token' => $_SESSION['app_token'] ?? null,
            'application_id' => $_SESSION['application_id'] ?? null
        ]]);
        exit;
    } else {
        // Form POST request
        if (isset($_POST['app_token'])) {
            $_SESSION['app_token'] = $_POST['app_token'];
        }

        if (isset($_POST['application_id'])) {
            $_SESSION['application_id'] = $_POST['application_id'];
        }

        // Store step data if provided
        if (isset($_POST['step1_data'])) {
            $_SESSION['step1_data'] = json_decode($_POST['step1_data'], true);
        }

        if (isset($_POST['step2_data'])) {
            $_SESSION['step2_data'] = json_decode($_POST['step2_data'], true);
        }

        // Redirect back to the form
        $redirect = $_POST['redirect'] ?? 'step1.php';
        header('Location: ' . $redirect);
        exit;
    }
}

// GET request - return session data
echo json_encode([
    'success' => true,
    'app_token' => $_SESSION['app_token'] ?? null,
    'application_id' => $_SESSION['application_id'] ?? null,
]);
