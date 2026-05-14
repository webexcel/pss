<?php
/**
 * Database Configuration
 *
 * Update these values with your MySQL credentials
 */

return [
    'host'     => 'schooltree-prod.cfcyioeqyfml.ap-south-1.rds.amazonaws.com',
    'port'     => 3306,
    'database' => 'school_admission',
    'username' => 'main',
    'password' => 'P@mani4u',
    'charset'  => 'utf8mb4',
    'options'  => [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
        PDO::ATTR_STRINGIFY_FETCHES  => false,
    ],
];
