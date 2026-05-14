<?php
/**
 * Configuration File - Integrated Course Fee Payment
 */

// Prevent direct access
if (!defined('APP_ROOT')) {
    define('APP_ROOT', dirname(__DIR__));
}

// Database Configuration
define('DB_HOST', 'schooltree-prod.cfcyioeqyfml.ap-south-1.rds.amazonaws.com');
define('DB_NAME', 'pssenior');      // Your existing school database
define('DB_USER', 'main');
define('DB_PASS', 'P@mani4u');
define('DB_CHARSET', 'utf8mb4');

// Razorpay Configuration
//define('RAZORPAY_KEY_ID', 'rzp_test_KT99X2kx24GGVJ');     // Replace with your key
//define('RAZORPAY_KEY_SECRET', 'NcVqNqjdOLxoh7eejXqZuRzN');   // Replace with your secret
define('RAZORPAY_KEY_ID', 'rzp_live_N1R53Ubks63NBg');     // Replace with your key
define('RAZORPAY_KEY_SECRET', 'l2YzCaDJLfWECG5GyYX8cBJS');   // Replace with your secret
define('RAZORPAY_WEBHOOK_SECRET', 'schooltree@321');       // Replace with webhook secret

// Fee Amounts (in paise for Razorpay)
define('FEE_FULL', 9900000);       // ₹99,000
define('FEE_INST1', 5500000);      // ₹55,000
define('FEE_INST2', 5000000);      // ₹50,000

// Fee Amounts (in rupees for display)
define('FEE_FULL_DISPLAY', 99000);
define('FEE_INST1_DISPLAY', 55000);
define('FEE_INST2_DISPLAY', 50000);

// Session Configuration
define('SESSION_TIMEOUT', 900);    // 15 minutes in seconds

// Application Settings
define('APP_NAME', 'Integrated Course Fee Payment');
define('SCHOOL_NAME', 'P.S. Senior Secondary School');
define('SUPPORT_EMAIL', 'pssrsec@gmail.com');
define('SUPPORT_PHONE', '+91-XXXXXXXXXX');

// Error Reporting (set to 0 in production)
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', APP_ROOT . '/logs/error.log');

// Timezone
date_default_timezone_set('Asia/Kolkata');
