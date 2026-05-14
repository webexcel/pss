<?php

declare(strict_types=1);

/**
 * Helper Functions
 */

/**
 * Get base URL
 */
function baseUrl(string $path = ''): string
{
    $config = require dirname(__DIR__) . '/config/app.php';
    return rtrim($config['url'], '/') . '/' . ltrim($path, '/');
}

/**
 * Get API URL
 */
function apiUrl(string $path = ''): string
{
    return baseUrl('api/' . ltrim($path, '/'));
}

/**
 * Escape output for HTML
 */
function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

/**
 * Get config value
 */
function config(string $key, $default = null)
{
    static $config = null;

    if ($config === null) {
        $config = require dirname(__DIR__) . '/config/app.php';
    }

    return $config[$key] ?? $default;
}

/**
 * Get mail config value
 */
function mailConfig(string $key, $default = null)
{
    static $config = null;

    if ($config === null) {
        $config = require dirname(__DIR__) . '/config/mail.php';
    }

    return $config[$key] ?? $default;
}

/**
 * Format date
 */
function formatDate(string $date, string $format = 'F j, Y'): string
{
    $dt = new DateTime($date);
    return $dt->format($format);
}

/**
 * Format currency
 */
function formatCurrency(float $amount, string $symbol = '$'): string
{
    return $symbol . number_format($amount, 2);
}

/**
 * Get class options for select
 */
function getClassOptions(): array
{
    return config('class_options', []);
}

/**
 * Get community options for select
 */
function getCommunityOptions(): array
{
    return config('community_options', []);
}

/**
 * Get subject group options
 */
function getSubjectGroups(): array
{
    return config('subject_groups', []);
}

/**
 * Get qualification options
 */
function getQualificationOptions(): array
{
    return config('qualification_options', []);
}

/**
 * Generate CSRF token field
 */
function csrfField(string $sessionToken): string
{
    require_once dirname(__DIR__) . '/api/Middleware/CsrfMiddleware.php';
    $csrf = new \Api\Middleware\CsrfMiddleware();
    return $csrf->getFormField($sessionToken);
}

/**
 * Get reCAPTCHA site key
 */
function getRecaptchaSiteKey(): string
{
    require_once dirname(__DIR__) . '/api/Middleware/Recaptcha.php';
    $recaptcha = new \Api\Middleware\Recaptcha();
    return $recaptcha->getSiteKey();
}

/**
 * Get reCAPTCHA script tag
 */
function recaptchaScript(): string
{
    return '<script src="https://www.google.com/recaptcha/api.js"></script>';
}

/**
 * Get reCAPTCHA widget
 */
function recaptchaWidget(): string
{
    $siteKey = getRecaptchaSiteKey();
    return sprintf('<div class="g-recaptcha" data-sitekey="%s"></div>', e($siteKey));
}

/**
 * Check if request is AJAX
 */
function isAjax(): bool
{
    return isset($_SERVER['HTTP_X_REQUESTED_WITH'])
        && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

/**
 * Get client IP
 */
function getClientIp(): string
{
    $headers = [
        'HTTP_CF_CONNECTING_IP',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_FORWARDED_FOR',
        'HTTP_FORWARDED',
        'REMOTE_ADDR',
    ];

    foreach ($headers as $header) {
        if (!empty($_SERVER[$header])) {
            $ips = explode(',', $_SERVER[$header]);
            $ip = trim($ips[0]);
            if (filter_var($ip, FILTER_VALIDATE_IP)) {
                return $ip;
            }
        }
    }

    return '0.0.0.0';
}

/**
 * JSON response helper
 */
function jsonResponse(array $data, int $statusCode = 200): void
{
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

/**
 * Redirect helper
 */
function redirect(string $url): void
{
    header('Location: ' . $url);
    exit;
}

/**
 * Flash message helper
 */
function flash(string $key, $value = null)
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if ($value !== null) {
        $_SESSION['flash'][$key] = $value;
        return;
    }

    $message = $_SESSION['flash'][$key] ?? null;
    unset($_SESSION['flash'][$key]);
    return $message;
}

/**
 * Old input helper (for form repopulation)
 */
function old(string $key, string $default = ''): string
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $value = $_SESSION['old_input'][$key] ?? $default;
    return e($value);
}

/**
 * Store old input
 */
function storeOldInput(array $data): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $_SESSION['old_input'] = $data;
}

/**
 * Clear old input
 */
function clearOldInput(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    unset($_SESSION['old_input']);
}

/**
 * Check if value is selected/checked
 */
function isSelected(string $currentValue, string $optionValue): string
{
    return $currentValue === $optionValue ? 'selected' : '';
}

/**
 * Check if checkbox should be checked
 */
function isChecked($value): string
{
    return $value ? 'checked' : '';
}

/**
 * Render select options
 */
function renderOptions(array $options, string $selectedValue = '', bool $useKeyAsValue = false): string
{
    $html = '<option value="" disabled selected>Select an option</option>';

    foreach ($options as $key => $label) {
        $value = $useKeyAsValue ? $key : $label;
        $selected = ($value === $selectedValue) ? ' selected' : '';
        $html .= sprintf(
            '<option value="%s"%s>%s</option>',
            e($value),
            $selected,
            e($label)
        );
    }

    return $html;
}

/**
 * Debug helper (only in debug mode)
 */
function dd(...$vars): void
{
    if (!config('debug', false)) {
        return;
    }

    echo '<pre>';
    foreach ($vars as $var) {
        var_dump($var);
    }
    echo '</pre>';
    exit;
}
