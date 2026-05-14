<?php
/**
 * Mail Configuration (SMTP)
 *
 * Update these values with your SMTP server credentials
 */

return [
    'smtp_host'     => 'smtp.gmail.com',
    'smtp_port'     => 587,
    'smtp_username' => 'epraburajan@gmail.com',      // Your Gmail address
    'smtp_password' => 'xxxx xxxx xxxx xxxx',       // App Password from Google (16 chars)
    'smtp_secure'   => 'tls',

    'from_email'    => 'your-email@gmail.com',      // Must match smtp_username for Gmail
    'from_name'     => 'P.S. Senior Secondary School',
    'reply_to'      => 'your-email@gmail.com',      // Your Gmail address

    // School details for email template
    'school_name'   => 'P.S. Senior Secondary School',
    'school_address'=> '33, Alarmelmangapuram, Mylapore, Chennai - 600004',
    'school_phone'  => '+91 1234567890',
    'school_website'=> 'https://www.psschool.edu',
];
