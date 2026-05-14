<?php
/**
 * Session Management - Simple 15-minute sessions
 */

require_once __DIR__ . '/config.php';

function initSession(): void {
    if (session_status() === PHP_SESSION_NONE) {
        ini_set('session.gc_maxlifetime', SESSION_TIMEOUT);
        session_set_cookie_params([
            'lifetime' => SESSION_TIMEOUT,
            'path' => '/',
            'httponly' => true,
            'samesite' => 'Lax'
        ]);
        session_start();
    }
}

function isLoggedIn(): bool {
    initSession();

    if (!isset($_SESSION['adno']) || !isset($_SESSION['login_time'])) {
        return false;
    }

    // Check session timeout
    if (time() - $_SESSION['login_time'] > SESSION_TIMEOUT) {
        destroySession();
        return false;
    }

    return true;
}

function requireLogin(): void {
    if (!isLoggedIn()) {
        header('Location: index.php?msg=session_expired');
        exit;
    }
}

function createSession(array $studentData): void {
    initSession();
    session_regenerate_id(true);

    $_SESSION['adno'] = $studentData['ADMISSION_ID'];
    $_SESSION['student_name'] = $studentData['NAME'];
    $_SESSION['class_section'] = $studentData['CLASSSEC'];
    $_SESSION['contact'] = $studentData['contact'];
    //$_SESSION['email'] = $studentData['email'] ?? '';
    $_SESSION['year_id'] = $studentData['Year_Id'];
    $_SESSION['login_time'] = time();
}

function getSessionData(): array {
    initSession();
    return [
        'adno' => $_SESSION['adno'] ?? '',
        'student_name' => $_SESSION['student_name'] ?? '',
        'class_section' => $_SESSION['class_section'] ?? '',
        'contact' => $_SESSION['contact'] ?? '',
        //'email' => $_SESSION['email'] ?? '',
        'year_id' => $_SESSION['year_id'] ?? 0,
    ];
}

function destroySession(): void {
    initSession();
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params['path'], $params['domain'],
            $params['secure'], $params['httponly']
        );
    }

    session_destroy();
}
