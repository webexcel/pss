<?php

declare(strict_types=1);

namespace Api\Middleware;

/**
 * Google reCAPTCHA v2 Verification
 */
class Recaptcha
{
    private string $siteKey;
    private string $secretKey;
    private string $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';

    public function __construct()
    {
        $this->loadKeys();
    }

    /**
     * Load reCAPTCHA keys from config file
     */
    private function loadKeys(): void
    {
        $configPath = dirname(__DIR__, 2) . '/config/recaptcha.txt';

        if (!file_exists($configPath)) {
            throw new \RuntimeException('reCAPTCHA configuration file not found');
        }

        $content = file_get_contents($configPath);
        $lines = explode("\n", $content);

        foreach ($lines as $line) {
            $line = trim($line);

            // Skip comments and empty lines
            if (empty($line) || strpos($line, ';') === 0) {
                continue;
            }

            if (strpos($line, 'SITE_KEY=') === 0) {
                $this->siteKey = trim(substr($line, 9));
            } elseif (strpos($line, 'SECRET_KEY=') === 0) {
                $this->secretKey = trim(substr($line, 11));
            }
        }

        if (empty($this->siteKey) || empty($this->secretKey)) {
            throw new \RuntimeException('reCAPTCHA keys not configured');
        }
    }

    /**
     * Get site key for frontend
     */
    public function getSiteKey(): string
    {
        return $this->siteKey;
    }

    /**
     * Verify reCAPTCHA response
     */
    public function verify(string $response, string $remoteIp = ''): bool
    {
        if (empty($response)) {
            return false;
        }

        $data = [
            'secret'   => $this->secretKey,
            'response' => $response,
        ];

        if (!empty($remoteIp)) {
            $data['remoteip'] = $remoteIp;
        }

        $result = $this->makeRequest($data);

        if (!$result) {
            error_log('reCAPTCHA verification failed: No response from Google');
            return false;
        }

        $decoded = json_decode($result, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log('reCAPTCHA verification failed: Invalid JSON response');
            return false;
        }

        if (!empty($decoded['error-codes'])) {
            error_log('reCAPTCHA errors: ' . implode(', ', $decoded['error-codes']));
        }

        return $decoded['success'] ?? false;
    }

    /**
     * Make HTTP request to Google reCAPTCHA API
     */
    private function makeRequest(array $data): ?string
    {
        // Use cURL if available
        if (function_exists('curl_init')) {
            return $this->curlRequest($data);
        }

        // Fall back to file_get_contents
        return $this->streamRequest($data);
    }

    /**
     * Make request using cURL
     */
    private function curlRequest(array $data): ?string
    {
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL            => $this->verifyUrl,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => http_build_query($data),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 10,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
        ]);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            error_log('reCAPTCHA cURL error: ' . $error);
            return null;
        }

        return $response ?: null;
    }

    /**
     * Make request using file_get_contents
     */
    private function streamRequest(array $data): ?string
    {
        $options = [
            'http' => [
                'method'  => 'POST',
                'header'  => 'Content-Type: application/x-www-form-urlencoded',
                'content' => http_build_query($data),
                'timeout' => 10,
            ],
            'ssl' => [
                'verify_peer'      => true,
                'verify_peer_name' => true,
            ],
        ];

        $context = stream_context_create($options);
        $response = @file_get_contents($this->verifyUrl, false, $context);

        return $response ?: null;
    }

    /**
     * Get the reCAPTCHA script tag
     */
    public function getScript(): string
    {
        return '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
    }

    /**
     * Get the reCAPTCHA widget HTML
     */
    public function getWidget(): string
    {
        return sprintf(
            '<div class="g-recaptcha" data-sitekey="%s"></div>',
            htmlspecialchars($this->siteKey, ENT_QUOTES, 'UTF-8')
        );
    }
}
