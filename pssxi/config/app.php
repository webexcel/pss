<?php
/**
 * Application Configuration
 */

return [
    'name'        => 'P.S. Senior Secondary School',
    'url'         => 'https://pssenior.edu.in/pssxi',
    'timezone'    => 'Asia/Kolkata',
    'debug'       => false, // Set to false in production

    // Draft expiry in days
    'draft_expiry_days' => 7,

    // Rate limiting
    'rate_limit' => [
        'max_requests'   => 50,   // Max requests
        'window_seconds' => 3600, // Per hour
    ],

    // CSRF token expiry in seconds
    'csrf_expiry' => 3600, // 1 hour

    // Valid class options
    'class_options' => [
        'STD XI'
    ],

    // Valid community options
    'community_options' => ['General', 'OBC', 'SC', 'ST'],

    // Valid subject groups
    'subject_groups' => [
        'Maths, Physics, Chemistry, Computer Science',
        'Maths, Physics, Chemistry, Biology',
        'Maths, Physics, Chemistry, Informatics Practices',
        'Physics, Chemistry, Biology, Informatics Practices',
        'Business Studies, Accountancy, Economics, Applied Maths',
        'Business Studies, Accountancy, Economics, Legal Studies',
        'Business Studies, Accountancy, Economics, Entrepreneurship',
	'Business studies, Accountancy, Economics, Informatics Practices'
    ],

    // Qualification options
    'qualification_options' => [
        'hs'    => 'High School',
        'ug'    => 'Undergraduate',
        'pg'    => 'Postgraduate',
        'doc'   => 'Doctorate',
        'other' => 'Other'
    ],
];
