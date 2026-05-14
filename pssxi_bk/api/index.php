<?php

declare(strict_types=1);

/**
 * API Router
 *
 * Entry point for all API requests
 */

// Error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');

// Set timezone
date_default_timezone_set('Asia/Kolkata');

// CORS headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With, X-CSRF-Token, X-Session-Token');
header('Content-Type: application/json; charset=UTF-8');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Autoloader
spl_autoload_register(function (string $class): void {
    $prefix = 'Api\\';
    $baseDir = __DIR__ . '/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);

    // Keep original casing for folders and class names (Linux is case-sensitive)
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

use Api\Controllers\AdmissionController;
use Api\Middleware\RateLimiter;
use Api\Middleware\CsrfMiddleware;

// Get request method and URI
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
error_log("DEBUG URI: " . $uri);
error_log("DEBUG basePath removed: " . str_replace('/pssxi/api', '', $uri));

// Remove query string and base path
$uri = parse_url($uri, PHP_URL_PATH);
//$basePath = '/pssxi/api';
$basePath = dirname($_SERVER['SCRIPT_NAME']);
$uri = str_replace($basePath, '', $uri);
$uri = trim($uri, '/');

// Parse URI segments
$segments = explode('/', $uri);

// Initialize response
$response = [
    'success' => false,
    'data'    => null,
    'message' => 'Invalid endpoint',
    'errors'  => [],
];

try {
    // Rate limiting for submissions
    $rateLimiter = new RateLimiter();
    if ($method === 'POST') {
        if (!$rateLimiter->handle('api')) {
            echo json_encode([
                'success' => false,
                'data'    => null,
                'message' => 'Too many requests. Please try again later.',
                'errors'  => [],
            ]);
            exit;
        }
    }

    // Initialize controller
    $controller = new AdmissionController();

    // Get JSON input for POST requests
    $input = [];
    if ($method === 'POST') {
        $rawInput = file_get_contents('php://input');
        if ($rawInput) {
            $input = json_decode($rawInput, true) ?? [];
        }
        // Merge with POST data
        $input = array_merge($_POST, $input);
    }

    // Route matching
    // POST /application/start
    if ($method === 'POST' && $segments[0] === 'application' && ($segments[1] ?? '') === 'start') {
        $response = $controller->startApplication();
    }
    // GET /application/{token}
    elseif ($method === 'GET' && $segments[0] === 'application' && !empty($segments[1]) && empty($segments[2])) {
        $token = $segments[1];
        $response = $controller->getApplication($token);
    }
    // POST /application/{token}/step1
    elseif ($method === 'POST' && $segments[0] === 'application' && !empty($segments[1]) && ($segments[2] ?? '') === 'step1') {
        $token = $segments[1];
        $response = $controller->saveStep1($token, $input);
    }
    // POST /application/{token}/step2
    elseif ($method === 'POST' && $segments[0] === 'application' && !empty($segments[1]) && ($segments[2] ?? '') === 'step2') {
        $token = $segments[1];
        $response = $controller->saveStep2($token, $input);
    }
    // GET /application/{token}/review
    elseif ($method === 'GET' && $segments[0] === 'application' && !empty($segments[1]) && ($segments[2] ?? '') === 'review') {
        $token = $segments[1];
        $response = $controller->getReviewData($token);
    }
    // POST /application/{token}/submit
    elseif ($method === 'POST' && $segments[0] === 'application' && !empty($segments[1]) && ($segments[2] ?? '') === 'submit') {
        $token = $segments[1];
        $response = $controller->submitApplication($token, $input);
    }
    // POST /application/{token}/draft
    elseif ($method === 'POST' && $segments[0] === 'application' && !empty($segments[1]) && ($segments[2] ?? '') === 'draft') {
        $token = $segments[1];
        $response = $controller->saveDraft($token, $input);
    }
    // POST /application/{token}/reset
    elseif ($method === 'POST' && $segments[0] === 'application' && !empty($segments[1]) && ($segments[2] ?? '') === 'reset') {
        $token = $segments[1];
        $response = $controller->resetApplication($token);
    }
    // GET /csrf-token/{session_token}
    elseif ($method === 'GET' && $segments[0] === 'csrf-token' && !empty($segments[1])) {
        $sessionToken = $segments[1];
        $csrf = new CsrfMiddleware();
        $token = $csrf->generateToken($sessionToken);
        $response = [
            'success' => true,
            'data'    => ['csrf_token' => $token],
            'message' => '',
            'errors'  => [],
        ];
    }
    // GET /recaptcha-key
    elseif ($method === 'GET' && $segments[0] === 'recaptcha-key') {
        $recaptcha = new \Api\Middleware\Recaptcha();
        $response = [
            'success' => true,
            'data'    => ['site_key' => $recaptcha->getSiteKey()],
            'message' => '',
            'errors'  => [],
        ];
    }
    // 404 - Not Found
    else {
        http_response_code(404);
        $response = [
            'success' => false,
            'data'    => null,
            'message' => 'Endpoint not found',
            'errors'  => [],
        ];
    }

} catch (\Exception $e) {
    error_log('API Error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
    error_log('Stack trace: ' . $e->getTraceAsString());

    http_response_code(500);
    $response = [
        'success' => false,
        'data'    => null,
        'message' => 'An internal error occurred. Please try again later.',
        'errors'  => [],
        // Temporarily include error details for debugging (remove in production)
        'debug' => [
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ],
    ];
}

echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
