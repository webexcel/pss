<?php
/**
 * Test API Routing
 */

header('Content-Type: text/plain');

echo "=== API ROUTING TEST ===\n\n";

echo "REQUEST_URI: " . ($_SERVER['REQUEST_URI'] ?? 'NOT SET') . "\n";
echo "REQUEST_METHOD: " . ($_SERVER['REQUEST_METHOD'] ?? 'NOT SET') . "\n";
echo "SCRIPT_NAME: " . ($_SERVER['SCRIPT_NAME'] ?? 'NOT SET') . "\n";
echo "PHP_SELF: " . ($_SERVER['PHP_SELF'] ?? 'NOT SET') . "\n\n";

// Parse URI
$uri = $_SERVER['REQUEST_URI'];
$uri = parse_url($uri, PHP_URL_PATH);
$basePath = '/pssxi/api';
$uri = str_replace($basePath, '', $uri);
$uri = trim($uri, '/');

echo "Parsed URI: $uri\n";
echo "Segments: " . print_r(explode('/', $uri), true) . "\n\n";

// Check if mod_rewrite is working
echo "Testing mod_rewrite:\n";
if (function_exists('apache_get_modules')) {
    $modules = apache_get_modules();
    if (in_array('mod_rewrite', $modules)) {
        echo "✓ mod_rewrite IS enabled\n";
    } else {
        echo "✗ mod_rewrite is NOT enabled\n";
    }
} else {
    echo "⚠ Cannot check mod_rewrite (not running as Apache module)\n";
}

echo "\n";

// Check .htaccess
echo "Checking .htaccess:\n";
if (file_exists(__DIR__ . '/.htaccess')) {
    echo "✓ .htaccess EXISTS\n";
    echo "Content:\n";
    echo file_get_contents(__DIR__ . '/.htaccess');
} else {
    echo "✗ .htaccess NOT FOUND\n";
}
