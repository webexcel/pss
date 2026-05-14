<?php
/**
 * Test API directly
 */

// Simulate POST request
$_SERVER['REQUEST_METHOD'] = 'POST';
$_SERVER['REQUEST_URI'] = '/pssxi/api/application/start';
$_SERVER['HTTP_HOST'] = 'localhost';

// Capture output
ob_start();
include __DIR__ . '/index.php';
$output = ob_get_clean();

// Display results
header('Content-Type: text/plain');
echo "=== API TEST ===\n\n";
echo "Output length: " . strlen($output) . " bytes\n\n";
echo "Output:\n";
echo $output;
