<?php

declare(strict_types=1);

namespace Api\Middleware;

use Api\Config\Database;

/**
 * Rate Limiter Middleware
 *
 * Limits the number of requests per IP address
 */
class RateLimiter
{
    private Database $db;
    private int $maxRequests;
    private int $windowSeconds;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $config = require dirname(__DIR__, 2) . '/config/app.php';
        $this->maxRequests = $config['rate_limit']['max_requests'] ?? 10;
        $this->windowSeconds = $config['rate_limit']['window_seconds'] ?? 3600;
    }

    /**
     * Check if the request is allowed
     */
    public function isAllowed(string $ipAddress, string $endpoint = 'default'): bool
    {
        $this->cleanupOldRecords();

        $record = $this->getRecord($ipAddress, $endpoint);

        if (!$record) {
            $this->createRecord($ipAddress, $endpoint);
            return true;
        }

        // Check if within rate limit
        if ($record['requests'] >= $this->maxRequests) {
            $windowStart = strtotime($record['window_start']);
            $windowEnd = $windowStart + $this->windowSeconds;

            if (time() < $windowEnd) {
                return false;
            }

            // Reset the window
            $this->resetRecord($ipAddress, $endpoint);
            return true;
        }

        // Increment request count
        $this->incrementRecord($ipAddress, $endpoint);
        return true;
    }

    /**
     * Get remaining requests for an IP
     */
    public function getRemainingRequests(string $ipAddress, string $endpoint = 'default'): int
    {
        $record = $this->getRecord($ipAddress, $endpoint);

        if (!$record) {
            return $this->maxRequests;
        }

        $remaining = $this->maxRequests - $record['requests'];
        return max(0, $remaining);
    }

    /**
     * Get reset time for an IP
     */
    public function getResetTime(string $ipAddress, string $endpoint = 'default'): int
    {
        $record = $this->getRecord($ipAddress, $endpoint);

        if (!$record) {
            return time() + $this->windowSeconds;
        }

        $windowStart = strtotime($record['window_start']);
        return $windowStart + $this->windowSeconds;
    }

    /**
     * Get rate limit record
     */
    private function getRecord(string $ipAddress, string $endpoint): ?array
    {
        $sql = "SELECT * FROM rate_limits
                WHERE ip_address = :ip_address AND endpoint = :endpoint
                LIMIT 1";

        return $this->db->fetchOne($sql, [
            'ip_address' => $ipAddress,
            'endpoint'   => $endpoint,
        ]);
    }

    /**
     * Create new rate limit record
     */
    private function createRecord(string $ipAddress, string $endpoint): void
    {
        $sql = "INSERT INTO rate_limits (ip_address, endpoint, requests, window_start)
                VALUES (:ip_address, :endpoint, 1, NOW())
                ON DUPLICATE KEY UPDATE requests = 1, window_start = NOW()";

        $this->db->execute($sql, [
            'ip_address' => $ipAddress,
            'endpoint'   => $endpoint,
        ]);
    }

    /**
     * Increment request count
     */
    private function incrementRecord(string $ipAddress, string $endpoint): void
    {
        $sql = "UPDATE rate_limits
                SET requests = requests + 1
                WHERE ip_address = :ip_address AND endpoint = :endpoint";

        $this->db->execute($sql, [
            'ip_address' => $ipAddress,
            'endpoint'   => $endpoint,
        ]);
    }

    /**
     * Reset rate limit record
     */
    private function resetRecord(string $ipAddress, string $endpoint): void
    {
        $sql = "UPDATE rate_limits
                SET requests = 1, window_start = NOW()
                WHERE ip_address = :ip_address AND endpoint = :endpoint";

        $this->db->execute($sql, [
            'ip_address' => $ipAddress,
            'endpoint'   => $endpoint,
        ]);
    }

    /**
     * Clean up old records
     */
    private function cleanupOldRecords(): void
    {
        $sql = "DELETE FROM rate_limits
                WHERE window_start < DATE_SUB(NOW(), INTERVAL :seconds SECOND)";

        $this->db->execute($sql, ['seconds' => $this->windowSeconds]);
    }

    /**
     * Middleware handler
     */
    public function handle(string $endpoint = 'default'): bool
    {
        $ipAddress = $this->getClientIp();

        if (!$this->isAllowed($ipAddress, $endpoint)) {
            http_response_code(429);
            header('Retry-After: ' . ($this->getResetTime($ipAddress, $endpoint) - time()));
            return false;
        }

        // Add rate limit headers
        header('X-RateLimit-Limit: ' . $this->maxRequests);
        header('X-RateLimit-Remaining: ' . $this->getRemainingRequests($ipAddress, $endpoint));
        header('X-RateLimit-Reset: ' . $this->getResetTime($ipAddress, $endpoint));

        return true;
    }

    /**
     * Get client IP address
     */
    private function getClientIp(): string
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
}
