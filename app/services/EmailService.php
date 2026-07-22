<?php

declare(strict_types=1);

namespace App\Services;

use Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../config');
$dotenv->load();

class EmailService
{
    public function sendEmail(string $recipient_email, string $recipient_name, string $subject, string $body, ?string $attachment = null, ?string $attachment_name = null): bool
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['MAIL_USER'];
            $mail->Password = $_ENV['MAIL_PASSWORD'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            //Recipients
            $mail->setFrom($_ENV['MAIL_USER'], 'St. Thomas Events');
            $mail->addAddress($recipient_email, $recipient_name);

            //Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;
            
            if ($attachment) {
                $mail->addStringAttachment($attachment, $attachment_name, 'base64', 'application/pdf');
            }

            $mail->send();
        } catch (Exception $e) {
            return false;
        }

        return true;
    }
}