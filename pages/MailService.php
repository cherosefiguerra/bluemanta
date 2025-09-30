<?php
require __DIR__ . '/../vendor/autoload.php'; // Composer autoload

use PHPMailer\PHPMailer\Exception;

class MailService
{
    public static function sendMail($to, $subject, $body, $fromEmail, $fromName = '', $tmpPath = null, $fileName = null)
    {
        $mail = MailerConfig::getMailer();

        try {
            // Sender & recipient
            $mail->setFrom($fromEmail, $fromName ?: $fromEmail);
            $mail->addAddress($to);

            // Email content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;

            // Attachment (optional)
            if ($tmpPath && $fileName) {
                $mail->addAttachment($tmpPath, $fileName);
            }

            $mail->send();
            return true;
        } catch (Exception $e) {
            return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
