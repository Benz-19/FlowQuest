<?php

namespace App\Helper;

use App\Helper\Mailer;
use PHPMailer\PHPMailer\Exception;

class ResetPasswordMailer extends Mailer
{
    // contructor same as Mailer

    public function sendVerificationCode(string $to, string $name, string $code): bool
    {

        try {
            $this->mail->addAddress($to, $name);
            $this->mail->Subject = "Your FlowQuest Verification Code";

            $this->mail->Body = "
                <div style='font-family: Roboto, sans-serif; padding: 20px; background-color: #f9f9f9;'>
                    <img src='https://raw.githubusercontent.com/benz-19/FlowQuest/main/public/images/logo.png' alt='FlowQuest Logo' style='width: 120px; margin-bottom: 20px;'>
                    <h2 style='color: #333;'>Hey {$name},</h2>
                    <p>A new password reset was requested on your account! To verify your email, please enter the code below:</p>
                    <div style='font-size: 28px; font-weight: bold; margin: 20px 0; color: #007bff;'>{$code}</div>
                    <p>This code will expire in 10 minutes. <span style='color:green;'>If you didn’t request this, you can safely ignore this email.</span></p>
                    <p style='color: #888; margin-top: 40px;'>— The FlowQuest Team</p>
                </div>
            ";

            $this->mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Email error: " . $e->getMessage());
            return false;
        }
    }
}
