<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? MUN_EVENT_NAME) ?> - <?= e(MUN_EVENT_NAME) ?></title>
    <link rel="stylesheet" href="../integratedFees/assets/css/style.css">
    <link rel="stylesheet" href="assets/css/psmun.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="logo">
                <h1><?= e(SCHOOL_NAME) ?></h1>
            </div>
            <div class="header-title">
                <h2><?= e(MUN_EVENT_NAME) ?> &middot; <?= e(MUN_EDITION) ?></h2>
            </div>
        </header>
        <main class="main-content">
