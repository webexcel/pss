<?php
/**
 * Confirmation Email - Clarion PSMUN
 */

require_once __DIR__ . '/functions.php';
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as MailException;

/**
 * Load SMTP settings, or null when mail-config.php hasn't been set up
 */
function getMailConfig(): ?array {
    $file = __DIR__ . '/mail-config.php';
    if (!is_file($file)) {
        return null;
    }
    $config = require $file;
    return (is_array($config) && !empty($config['password'])) ? $config : null;
}

/**
 * Send the payment confirmation for a COMPLETED registration.
 * Records email_sent_at on success.
 */
function sendConfirmationEmail(array $payment): bool {
    if (!filter_var($payment['email'], FILTER_VALIDATE_EMAIL)) {
        error_log("PSMUN mail: skipped for order {$payment['order_id']} - no email address");
        return false;
    }

    $config = getMailConfig();
    if (!$config) {
        error_log("PSMUN mail: skipped for order {$payment['order_id']} - mail-config.php not set up");
        return false;
    }

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = $config['host'];
        $mail->Port = (int) $config['port'];
        $mail->SMTPAuth = true;
        $mail->Username = $config['username'];
        $mail->Password = $config['password'];
        $mail->SMTPSecure = $config['secure'] === 'ssl' ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Timeout = 15;
        $mail->CharSet = PHPMailer::CHARSET_UTF8;

        $mail->setFrom($config['from_email'], $config['from_name']);
        $mail->addReplyTo($config['reply_to'] ?: $config['from_email']);
        $mail->addAddress($payment['email'], $payment['contact_name']);
        if (!empty($config['bcc'])) {
            $mail->addBCC($config['bcc']);
        }

        $mail->isHTML(true);
        $mail->Subject = 'Registration Confirmed - ' . MUN_EVENT_NAME . ' (' . $payment['receipt'] . ')';
        $mail->Body = buildConfirmationHtml($payment);
        $mail->AltBody = buildConfirmationText($payment);

        $mail->send();
    } catch (MailException $e) {
        error_log("PSMUN mail: failed for order {$payment['order_id']} - " . $mail->ErrorInfo);
        return false;
    }

    $stmt = getDBConnection()->prepare("UPDATE psmun_fee_payments SET email_sent_at = NOW() WHERE id = ?");
    $stmt->execute([$payment['id']]);

    error_log("PSMUN mail: sent for order {$payment['order_id']} to {$payment['email']}");
    return true;
}

/**
 * Receipt rows shared by the HTML and text versions
 */
function getConfirmationRows(array $payment): array {
    $delegates = json_decode($payment['delegates'], true) ?: [];
    $rows = [];

    if ($payment['student_type'] === MUN_TYPE_INTERNAL) {
        $rows['Student Name'] = $delegates[0]['name'] ?? $payment['contact_name'];
        $rows['Admission No.'] = $payment['adno'];
        $rows['Class'] = $delegates[0]['class'] ?? '';
    } else {
        $rows['School'] = $payment['school_name'] . ($payment['branch'] ? ', ' . $payment['branch'] : '');
        $rows['Contact Person'] = $payment['contact_name'];
        $rows['No. of Delegates'] = (string) $payment['delegate_count'];
    }

    $amount = formatAmount((float) $payment['amount']);
    if ((int) $payment['delegate_count'] > 1) {
        $amount .= ' (' . (int) $payment['delegate_count'] . ' x ' . formatAmount(MUN_FEE_PER_DELEGATE_DISPLAY) . ')';
    }

    $rows['Amount Paid'] = $amount;
    $rows['Transaction ID'] = (string) $payment['payment_id'];
    $rows['Receipt No.'] = $payment['receipt'];
    $rows['Paid On'] = date('d M Y, h:i A', strtotime($payment['end_time'] ?? 'now'));

    return [$rows, $delegates];
}

function buildConfirmationHtml(array $payment): string {
    [$rows, $delegates] = getConfirmationRows($payment);

    $rowsHtml = '';
    foreach ($rows as $label => $value) {
        $rowsHtml .= '<tr><td style="padding:8px 0;color:#64748b;font-size:14px;width:40%;">' . e($label) . '</td>'
            . '<td style="padding:8px 0;color:#1e293b;font-size:14px;font-weight:600;">' . e($value) . '</td></tr>';
    }

    $delegatesHtml = '';
    if ($payment['student_type'] === MUN_TYPE_EXTERNAL) {
        $items = '';
        foreach ($delegates as $delegate) {
            $items .= '<li style="padding:2px 0;">' . e($delegate['name']) . ' <span style="color:#64748b;">(' . e($delegate['class']) . ')</span></li>';
        }
        $delegatesHtml = '<h3 style="color:#1e293b;font-size:16px;margin:24px 0 8px;">Delegates</h3>'
            . '<ol style="color:#334155;font-size:14px;margin:0;padding-left:20px;line-height:1.6;">' . $items . '</ol>';
    }

    $greeting = e($payment['contact_name']);
    $event = e(MUN_EVENT_NAME) . ' &middot; ' . e(MUN_EDITION);
    $school = e(SCHOOL_NAME);
    $support = e(SUPPORT_EMAIL);

    return <<<HTML
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"></head>
<body style="margin:0;padding:0;background:#f1f5f9;font-family:'Segoe UI',Arial,sans-serif;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:600px;margin:0 auto;background:#ffffff;">
    <tr>
        <td style="background:#122D57;padding:28px;text-align:center;">
            <h1 style="color:#ffffff;margin:0;font-size:22px;">{$event}</h1>
            <p style="color:#cbd5e1;margin:8px 0 0;font-size:14px;">{$school}</p>
        </td>
    </tr>
    <tr>
        <td style="padding:32px 30px;">
            <h2 style="color:#059669;margin:0 0 12px;font-size:20px;">&#10004; Registration Confirmed</h2>
            <p style="color:#334155;font-size:14px;line-height:1.6;margin:0 0 20px;">
                Dear {$greeting},<br>
                Thank you for registering for {$event}. We have received your payment.
            </p>
            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-top:1px solid #e2e8f0;border-bottom:1px solid #e2e8f0;">
                {$rowsHtml}
            </table>
            {$delegatesHtml}
            <p style="color:#64748b;font-size:13px;line-height:1.6;margin:24px 0 0;">
                Please keep this email for your records. For any queries, write to
                <a href="mailto:{$support}" style="color:#1d4ed8;">{$support}</a>.
            </p>
        </td>
    </tr>
    <tr>
        <td style="background:#f8fafc;padding:16px;text-align:center;color:#94a3b8;font-size:12px;">
            This is an automated email from {$school}.
        </td>
    </tr>
</table>
</body>
</html>
HTML;
}

function buildConfirmationText(array $payment): string {
    [$rows, $delegates] = getConfirmationRows($payment);

    $text = MUN_EVENT_NAME . ' - ' . MUN_EDITION . "\n" . SCHOOL_NAME . "\n\n"
        . "REGISTRATION CONFIRMED\n\n"
        . "Dear {$payment['contact_name']},\n"
        . 'Thank you for registering for ' . MUN_EVENT_NAME . ". We have received your payment.\n\n";

    foreach ($rows as $label => $value) {
        $text .= str_pad($label . ':', 18) . $value . "\n";
    }

    if ($payment['student_type'] === MUN_TYPE_EXTERNAL) {
        $text .= "\nDelegates:\n";
        foreach ($delegates as $i => $delegate) {
            $text .= ($i + 1) . ". {$delegate['name']} ({$delegate['class']})\n";
        }
    }

    return $text . "\nFor any queries, write to " . SUPPORT_EMAIL . "\n";
}

/**
 * Mark an order paid and, if this call is the one that completed it, send the email.
 * verify-payment.php and webhook.php can both reach here; only the first one sends.
 */
function completePaymentAndNotify(string $orderId, string $paymentId, string $signature, string $paydetails): bool {
    if (!updatePaymentCompleted($orderId, $paymentId, $signature, $paydetails)) {
        return false;
    }

    $payment = getPaymentByOrderId($orderId);
    if ($payment) {
        sendConfirmationEmail($payment);
    }
    return true;
}
