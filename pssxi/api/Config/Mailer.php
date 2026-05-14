<?php

declare(strict_types=1);

namespace Api\Config;

/**
 * Mailer Class
 *
 * Handles sending emails using PHP's mail() function or SMTP
 * For production, consider using PHPMailer library
 */
class Mailer
{
    private array $config;

    public function __construct()
    {
        $this->config = require dirname(__DIR__, 2) . '/config/mail.php';
    }

    /**
     * Send confirmation email after application submission
     */
    public function sendConfirmation(string $toEmail, string $applicationId, array $data): bool
    {
        $subject = "Application Received - {$applicationId} | {$this->config['school_name']}";

        $htmlBody = $this->getConfirmationTemplate($applicationId, $data);
        $textBody = $this->getPlainTextVersion($applicationId, $data);

        return $this->send($toEmail, $subject, $htmlBody, $textBody);
    }

    /**
     * Send email
     */
    public function send(string $to, string $subject, string $htmlBody, string $textBody = ''): bool
    {
        // Try SMTP first if configured
        if ($this->isSmtpConfigured()) {
            return $this->sendViaSMTP($to, $subject, $htmlBody, $textBody);
        }

        // Fall back to PHP mail()
        return $this->sendViaMail($to, $subject, $htmlBody, $textBody);
    }

    /**
     * Check if SMTP is configured
     */
    private function isSmtpConfigured(): bool
    {
        return !empty($this->config['smtp_host'])
            && !empty($this->config['smtp_username'])
            && !empty($this->config['smtp_password'])
            && $this->config['smtp_username'] !== 'your-email@gmail.com';
    }

    /**
     * Send via SMTP using sockets
     */
    private function sendViaSMTP(string $to, string $subject, string $htmlBody, string $textBody): bool
    {
        $host = $this->config['smtp_host'];
        $port = $this->config['smtp_port'];
        $username = $this->config['smtp_username'];
        $password = $this->config['smtp_password'];
        $secure = $this->config['smtp_secure'];

        try {
            // Connect to SMTP server
            $prefix = $secure === 'ssl' ? 'ssl://' : '';
            $socket = @fsockopen($prefix . $host, $port, $errno, $errstr, 30);

            if (!$socket) {
                error_log("SMTP connection failed: {$errstr} ({$errno})");
                return $this->sendViaMail($to, $subject, $htmlBody, $textBody);
            }

            $this->getResponse($socket); // Read greeting

            // EHLO
            $this->sendCommand($socket, "EHLO " . gethostname());

            // STARTTLS for TLS
            if ($secure === 'tls') {
                $this->sendCommand($socket, "STARTTLS");
                stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
                $this->sendCommand($socket, "EHLO " . gethostname());
            }

            // Authenticate
            $this->sendCommand($socket, "AUTH LOGIN");
            $this->sendCommand($socket, base64_encode($username));
            $this->sendCommand($socket, base64_encode($password));

            // Set sender and recipient
            $this->sendCommand($socket, "MAIL FROM:<{$this->config['from_email']}>");
            $this->sendCommand($socket, "RCPT TO:<{$to}>");

            // Send data
            $this->sendCommand($socket, "DATA");

            // Build message
            $boundary = md5(uniqid((string) time()));
            $headers = $this->buildHeaders($to, $subject, $boundary);
            $body = $this->buildMultipartBody($htmlBody, $textBody, $boundary);

            fwrite($socket, $headers . "\r\n" . $body . "\r\n.\r\n");
            $this->getResponse($socket);

            // Quit
            $this->sendCommand($socket, "QUIT");
            fclose($socket);

            // Log success
            $this->logEmail($to, $subject, true);

            return true;

        } catch (\Exception $e) {
            error_log("SMTP error: " . $e->getMessage());
            return $this->sendViaMail($to, $subject, $htmlBody, $textBody);
        }
    }

    /**
     * Send SMTP command
     */
    private function sendCommand($socket, string $command): string
    {
        fwrite($socket, $command . "\r\n");
        return $this->getResponse($socket);
    }

    /**
     * Get SMTP response
     */
    private function getResponse($socket): string
    {
        $response = '';
        while ($line = fgets($socket, 515)) {
            $response .= $line;
            if (substr($line, 3, 1) === ' ') {
                break;
            }
        }
        return $response;
    }

    /**
     * Send via PHP mail()
     */
    private function sendViaMail(string $to, string $subject, string $htmlBody, string $textBody): bool
    {
        $boundary = md5(uniqid((string) time()));

        $headers = [
            'From: ' . $this->config['from_name'] . ' <' . $this->config['from_email'] . '>',
            'Reply-To: ' . $this->config['reply_to'],
            'MIME-Version: 1.0',
            'Content-Type: multipart/alternative; boundary="' . $boundary . '"',
            'X-Mailer: PHP/' . phpversion(),
        ];

        $body = $this->buildMultipartBody($htmlBody, $textBody, $boundary);

        $result = mail($to, $subject, $body, implode("\r\n", $headers));

        $this->logEmail($to, $subject, $result);

        return $result;
    }

    /**
     * Build email headers
     */
    private function buildHeaders(string $to, string $subject, string $boundary): string
    {
        $headers = [
            "From: {$this->config['from_name']} <{$this->config['from_email']}>",
            "To: {$to}",
            "Subject: {$subject}",
            "Reply-To: {$this->config['reply_to']}",
            "MIME-Version: 1.0",
            "Content-Type: multipart/alternative; boundary=\"{$boundary}\"",
            "X-Mailer: PHP/" . phpversion(),
        ];

        return implode("\r\n", $headers);
    }

    /**
     * Build multipart email body
     */
    private function buildMultipartBody(string $htmlBody, string $textBody, string $boundary): string
    {
        $body = "--{$boundary}\r\n";
        $body .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $body .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
        $body .= $textBody . "\r\n\r\n";

        $body .= "--{$boundary}\r\n";
        $body .= "Content-Type: text/html; charset=UTF-8\r\n";
        $body .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
        $body .= $htmlBody . "\r\n\r\n";

        $body .= "--{$boundary}--";

        return $body;
    }

    /**
     * Get confirmation email HTML template
     */
    private function getConfirmationTemplate(string $applicationId, array $data): string
    {
        $student = $data['student'] ?? [];
        $application = $data['application'] ?? [];
        $parents = $data['parents'] ?? [];

        $studentName = htmlspecialchars($student['full_name'] ?? 'Applicant');
        $classApplying = htmlspecialchars($student['class_applying'] ?? 'N/A');
        $submittedAt = date('F j, Y \a\t g:i A', strtotime($application['submitted_at'] ?? 'now'));

        $parentInfo = '';
        foreach ($parents as $parent) {
            $type = ucfirst($parent['parent_type']);
            $name = htmlspecialchars($parent['full_name'] ?? 'N/A');
            $parentInfo .= "<li><strong>{$type}:</strong> {$name}</li>";
        }

        $schoolName = htmlspecialchars($this->config['school_name']);
        $schoolAddress = htmlspecialchars($this->config['school_address']);
        $schoolPhone = htmlspecialchars($this->config['school_phone']);
        $schoolWebsite = htmlspecialchars($this->config['school_website']);

        return <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Confirmation</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f6f6f8;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width: 600px; margin: 0 auto; background-color: #ffffff;">
        <!-- Header -->
        <tr>
            <td style="background-color: #135bec; padding: 30px; text-align: center;">
                <h1 style="color: #ffffff; margin: 0; font-size: 24px;">{$schoolName}</h1>
                <p style="color: #e0e7ff; margin: 10px 0 0 0; font-size: 14px;">Admission Portal</p>
            </td>
        </tr>

        <!-- Success Icon -->
        <tr>
            <td style="padding: 40px 30px 20px; text-align: center;">
                <div style="width: 80px; height: 80px; background-color: #d1fae5; border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                    <span style="font-size: 40px; color: #059669;">✓</span>
                </div>
            </td>
        </tr>

        <!-- Main Content -->
        <tr>
            <td style="padding: 0 30px 30px;">
                <h2 style="color: #1e293b; text-align: center; margin: 0 0 20px;">Application Received!</h2>
                <p style="color: #64748b; text-align: center; margin: 0 0 30px; line-height: 1.6;">
                    Thank you for submitting your admission application. We have received your application and it is currently under review.
                </p>

                <!-- Application Details Box -->
                <div style="background-color: #f8fafc; border-radius: 8px; padding: 24px; margin-bottom: 24px;">
                    <h3 style="color: #1e293b; margin: 0 0 16px; font-size: 16px;">Application Details</h3>
                    <table width="100%" cellspacing="0" cellpadding="8">
                        <tr>
                            <td style="color: #64748b; font-size: 14px;">Application ID:</td>
                            <td style="color: #1e293b; font-size: 14px; font-weight: 600;">{$applicationId}</td>
                        </tr>
                        <tr>
                            <td style="color: #64748b; font-size: 14px;">Student Name:</td>
                            <td style="color: #1e293b; font-size: 14px;">{$studentName}</td>
                        </tr>
                        <tr>
                            <td style="color: #64748b; font-size: 14px;">Class Applied For:</td>
                            <td style="color: #1e293b; font-size: 14px;">{$classApplying}</td>
                        </tr>
                        <tr>
                            <td style="color: #64748b; font-size: 14px;">Submitted On:</td>
                            <td style="color: #1e293b; font-size: 14px;">{$submittedAt}</td>
                        </tr>
                    </table>
                </div>

                <!-- Parent Info -->
                <div style="background-color: #eff6ff; border-radius: 8px; padding: 24px; margin-bottom: 24px;">
                    <h3 style="color: #1e293b; margin: 0 0 12px; font-size: 16px;">Guardian Information</h3>
                    <ul style="color: #475569; font-size: 14px; margin: 0; padding-left: 20px; line-height: 1.8;">
                        {$parentInfo}
                    </ul>
                </div>

                <!-- Next Steps -->
                <div style="background-color: #fef3c7; border-left: 4px solid #f59e0b; padding: 16px; margin-bottom: 24px;">
                    <h3 style="color: #92400e; margin: 0 0 8px; font-size: 14px;">What's Next?</h3>
                    <ul style="color: #78350f; font-size: 14px; margin: 0; padding-left: 20px; line-height: 1.6;">
                        <li>Our admissions team will review your application</li>
                        <li>You may be contacted for additional documents or an interview</li>
                        <li>Please save your Application ID for future reference</li>
                    </ul>
                </div>

                <p style="color: #64748b; font-size: 14px; text-align: center; margin: 0;">
                    If you have any questions, please contact us at:<br>
                    <strong style="color: #135bec;">{$schoolPhone}</strong>
                </p>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="background-color: #1e293b; padding: 30px; text-align: center;">
                <p style="color: #94a3b8; font-size: 14px; margin: 0 0 10px;">
                    {$schoolName}
                </p>
                <p style="color: #64748b; font-size: 12px; margin: 0 0 10px;">
                    {$schoolAddress}
                </p>
                <p style="color: #64748b; font-size: 12px; margin: 0;">
                    <a href="{$schoolWebsite}" style="color: #60a5fa; text-decoration: none;">{$schoolWebsite}</a>
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
HTML;
    }

    /**
     * Get plain text version
     */
    private function getPlainTextVersion(string $applicationId, array $data): string
    {
        $student = $data['student'] ?? [];
        $application = $data['application'] ?? [];
        $parents = $data['parents'] ?? [];

        $studentName = $student['full_name'] ?? 'Applicant';
        $classApplying = $student['class_applying'] ?? 'N/A';
        $submittedAt = date('F j, Y at g:i A', strtotime($application['submitted_at'] ?? 'now'));

        $parentInfo = '';
        foreach ($parents as $parent) {
            $type = ucfirst($parent['parent_type']);
            $name = $parent['full_name'] ?? 'N/A';
            $parentInfo .= "- {$type}: {$name}\n";
        }

        $schoolName = $this->config['school_name'];
        $schoolPhone = $this->config['school_phone'];

        return <<<TEXT
{$schoolName} - Admission Portal
================================

APPLICATION RECEIVED!

Thank you for submitting your admission application. We have received your application and it is currently under review.

APPLICATION DETAILS
-------------------
Application ID: {$applicationId}
Student Name: {$studentName}
Class Applied For: {$classApplying}
Submitted On: {$submittedAt}

GUARDIAN INFORMATION
--------------------
{$parentInfo}

WHAT'S NEXT?
------------
- Our admissions team will review your application
- You may be contacted for additional documents or an interview
- Please save your Application ID for future reference

If you have any questions, please contact us at: {$schoolPhone}

---
This is an automated email. Please do not reply directly to this message.
TEXT;
    }

    /**
     * Log email sending
     */
    private function logEmail(string $to, string $subject, bool $success): void
    {
        $status = $success ? 'SUCCESS' : 'FAILED';
        $logMessage = "[{$status}] Email to: {$to} | Subject: {$subject}";
        error_log($logMessage);
    }
}
