<?php
/**
 * Error Page Handler
 */

$code = isset($_GET['code']) ? (int) $_GET['code'] : 404;

$errors = [
    403 => [
        'title' => 'Access Denied',
        'message' => 'You do not have permission to access this resource.',
        'icon' => 'block'
    ],
    404 => [
        'title' => 'Page Not Found',
        'message' => 'The page you are looking for does not exist.',
        'icon' => 'search_off'
    ],
    500 => [
        'title' => 'Server Error',
        'message' => 'Something went wrong on our end. Please try again later.',
        'icon' => 'error'
    ]
];

$error = $errors[$code] ?? $errors[404];
http_response_code($code);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $code ?> - <?= $error['title'] ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 font-['Lexend'] min-h-screen flex items-center justify-center p-4">
    <div class="text-center">
        <div class="w-24 h-24 bg-red-100 rounded-full mx-auto mb-6 flex items-center justify-center">
            <span class="material-symbols-outlined text-5xl text-red-500"><?= $error['icon'] ?></span>
        </div>
        <h1 class="text-6xl font-bold text-slate-800 mb-2"><?= $code ?></h1>
        <h2 class="text-2xl font-bold text-slate-700 mb-4"><?= $error['title'] ?></h2>
        <p class="text-slate-500 mb-8"><?= $error['message'] ?></p>
        <a href="step1.php" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors">
            <span class="material-symbols-outlined">home</span>
            Go to Home
        </a>
    </div>
</body>
</html>
