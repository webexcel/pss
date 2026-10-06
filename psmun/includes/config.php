<?php
/**
 * Configuration - Clarion PSMUN Registration Fee
 *
 * Database and Razorpay credentials are shared with integratedFees
 * so the keys live in one place.
 */

// Log into psmun/logs instead of integratedFees/logs
if (!defined('APP_ROOT')) {
    define('APP_ROOT', dirname(__DIR__));
}

require_once dirname(__DIR__, 2) . '/integratedFees/includes/config.php';

// Event Settings
define('MUN_EVENT_NAME', 'Clarion PSMUN 2026');
define('MUN_EDITION', '13th Edition');

// Fee per delegate
define('MUN_FEE_PER_DELEGATE', 90000);          // ₹900 in paise
define('MUN_FEE_PER_DELEGATE_DISPLAY', 900);    // ₹900 in rupees

// Group booking limit for other school students
define('MUN_MAX_GROUP_SIZE', 30);

// Student types
define('MUN_TYPE_INTERNAL', 'INTERNAL');
define('MUN_TYPE_EXTERNAL', 'EXTERNAL');
