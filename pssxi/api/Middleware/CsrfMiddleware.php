<?php

declare(strict_types=1);

namespace Api\Middleware;

use Api\Config\Database;

/**
 * CSRF Protection Middleware
 *
 * Generates and validates CSRF tokens for form submissions
 */
class CsrfMiddleware
{
    private Database $db;
    private int $expirySeconds;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $config = require dirname(__DIR__, 2) . '/config/app.php';
        $this->expirySeconds = $config['csrf_expiry'] ?? 3600;
    }

    /**
     * Generate a new CSRF token
     */
    public function generateToken(string $sessionToken): string
    {
        // Clean up old tokens for this session
        $this->cleanupTokens($sessionToken);

        // Generate new token
        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', time() + $this->expirySeconds);

        $sql = "INSERT INTO csrf_tokens (token, session_token, expires_at)
                VALUES (:token, :session_token, :expires_at)";

        $this->db->execute($sql, [
            'token'         => $token,
            'session_token' => $sessionToken,
            'expires_at'    => $expiresAt,
        ]);

        return $token;
    }

    /**
     * Validate a CSRF token
     */
    public function validateToken(string $token, string $sessionToken): bool
    {
        $sql = "SELECT id FROM csrf_tokens
                WHERE token = :token
                AND session_token = :session_token
                AND expires_at > NOW()
                LIMIT 1";

        $result = $this->db->fetchOne($sql, [
            'token'         => $token,
            'session_token' => $sessionToken,
        ]);

        if ($result) {
            // Delete the used token (one-time use)
            $this->deleteToken($token);
            return true;
        }

        return false;
    }

    /**
     * Delete a token
     */
    private function deleteToken(string $token): void
    {
        $sql = "DELETE FROM csrf_tokens WHERE token = :token";
        $this->db->execute($sql, ['token' => $token]);
    }

    /**
     * Clean up expired tokens for a session
     */
    private function cleanupTokens(string $sessionToken): void
    {
        $sql = "DELETE FROM csrf_tokens
                WHERE session_token = :session_token
                OR expires_at < NOW()";

        $this->db->execute($sql, ['session_token' => $sessionToken]);
    }

    /**
     * Middleware handler for API requests
     */
    public function handle(): bool
    {
        // Skip for GET requests
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            return true;
        }

        // Get token from header or POST data
        $token = $_SERVER['HTTP_X_CSRF_TOKEN']
            ?? $_POST['csrf_token']
            ?? null;

        // Get session token from header or POST
        $sessionToken = $_SERVER['HTTP_X_SESSION_TOKEN']
            ?? $_POST['session_token']
            ?? null;

        if (!$token || !$sessionToken) {
            return false;
        }

        return $this->validateToken($token, $sessionToken);
    }

    /**
     * Get HTML hidden input for forms
     */
    public function getFormField(string $sessionToken): string
    {
        $token = $this->generateToken($sessionToken);
        return sprintf(
            '<input type="hidden" name="csrf_token" value="%s">',
            htmlspecialchars($token, ENT_QUOTES, 'UTF-8')
        );
    }
}
