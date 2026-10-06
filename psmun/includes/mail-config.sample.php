<?php
/**
 * SMTP settings for PSMUN confirmation emails
 *
 * Copy this file to mail-config.php (same folder) and fill in the values.
 * mail-config.php is git-ignored so the password is never committed.
 *
 * For Gmail: turn on 2-Step Verification and create an App Password
 * (Google Account > Security > App passwords). Use that 16-character
 * password below, not the normal Gmail password.
 */

return [
    'host'       => 'smtp.gmail.com',
    'port'       => 587,
    'secure'     => 'tls',                       // 'tls' (587) or 'ssl' (465)
    'username'   => 'pssrsec@gmail.com',
    'password'   => '',                          // Gmail App Password

    'from_email' => 'pssrsec@gmail.com',         // Gmail requires this to match username
    'from_name'  => 'Clarion PSMUN - P.S. Senior Secondary School',
    'reply_to'   => 'pssrsec@gmail.com',

    // Optional: school copy of every confirmation (leave empty to skip)
    'bcc'        => '',
];
