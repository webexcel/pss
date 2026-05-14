<?php
/**
 * Common Header Template
 */

require_once __DIR__ . '/helpers.php';

// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get current step from URL or use the one already set, or default to 1
if (!isset($currentStep)) {
    $currentStep = isset($_GET['step']) ? (int) $_GET['step'] : 1;
}
$sessionToken = $_SESSION['app_token'] ?? null;
$applicationId = $_SESSION['application_id'] ?? null;
?>
<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'Admission Form') ?> - P.S. Senior Secondary School</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&family=Noto+Sans:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#135bec",
                        "background-light": "#f6f6f8",
                        "background-dark": "#101622",
                        "surface-light": "#ffffff",
                        "surface-dark": "#1e293b",
                    },
                    fontFamily: {
                        "display": ["Lexend", "sans-serif"],
                        "body": ["Noto Sans", "sans-serif"],
                    },
                    borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
                },
            },
        }
    </script>

    <!-- reCAPTCHA (only on step 3) -->
    <?php if (($currentStep ?? 1) === 3): ?>
    <?= recaptchaScript() ?>
    <?php endif; ?>

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* Loading spinner */
        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #135bec;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
            display: inline-block;
            vertical-align: middle;
            margin-right: 8px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Toast notifications */
        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 16px 24px;
            border-radius: 8px;
            color: white;
            font-weight: 500;
            z-index: 9999;
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.3s ease;
        }
        .toast.show {
            transform: translateY(0);
            opacity: 1;
        }
        .toast.success { background-color: #059669; }
        .toast.error { background-color: #dc2626; }
        .toast.warning { background-color: #d97706; }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-slate-100 min-h-screen flex flex-col transition-colors duration-200">

<!-- Header -->
<header class="sticky top-0 z-50 bg-surface-light/90 dark:bg-surface-dark/90 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 px-4 md:px-10 py-3">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="text-primary p-2 bg-primary/10 rounded-lg">
                <span class="material-symbols-outlined text-2xl">school</span>
            </div>
            <h2 class="text-lg md:text-xl font-bold tracking-tight"><?= e(mailConfig('school_name', 'School Admission Portal')) ?></h2>
        </div>
        <div class="flex items-center gap-6">
            <button class="hidden md:flex items-center gap-2 text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-primary transition-colors">
                <span class="material-symbols-outlined text-xl">help</span>
                Help Center
            </button>
            <?php if ($applicationId): ?>
            <span class="hidden lg:inline-block text-xs font-medium text-slate-500 bg-slate-100 dark:bg-slate-700 px-3 py-1 rounded-full">
                ID: <?= e($applicationId) ?>
            </span>
            <?php endif; ?>
        </div>
    </div>
</header>

<!-- Toast Container -->
<div id="toast-container"></div>
