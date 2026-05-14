<?php
/**
 * Mail Configuration (SMTP)
 *
 * Update these values with your SMTP server credentials
 */

return [
    'smtp_host'     => 'smtp.gmail.com',
    'smtp_port'     => 587,
    'smtp_username' => 'your-email@gmail.com',
    'smtp_password' => 'your-app-password',
    'smtp_secure'   => 'tls', // 'tls' or 'ssl'

    'from_email'    => 'admissions@school.edu',
    'from_name'     => 'P.S. Senior Secondary School',
    'reply_to'      => 'admissions@school.edu',

    // School details for email template
    'school_name'   => 'P.S. Senior Secondary School',
    'school_address'=> '33, Alarmelmangapuram, Mylapore, Chennai - 600004',
    'school_phone'  => '+91 1234567890',
    'school_website'=> 'https://www.psschool.edu',
];
