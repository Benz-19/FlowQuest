<?php
// File: App/Services/Auth/AuthService.php

namespace App\Services\Auth;

use App\Models\Freelancer;
use App\Models\Client;
use App\Models\Admin;
use App\Helper\Mailer;
use App\Http\Controllers\Auth\AuthController;

class AuthService
{
    public static function checkEmail(string $email, string $user_type): array
    {
        $email = htmlspecialchars(trim($email));
        $user = match ($user_type) {
            'freelancer' => new Freelancer(),
            'client'     => new Client(),
            'admin'      => new Admin(),
            default      => null
        };

        return ['exists' => $user && $user->isUser($email)];
    }

    public static function sendCode(string $email, string $name): array
    {
        $email = htmlspecialchars(trim($email));
        $name = htmlspecialchars(trim($name));
        $code = rand(100000, 999999);
        $_SESSION['verification_code'][$email] = $code;

        $mailer = new Mailer();
        $sent = $mailer->sendVerificationCode($email, $name, $code);

        return [
            'success' => $sent,
            'status' => $sent ? 200 : 500,
            'message' => $sent ? 'Verification code sent' : 'Failed to send email'
        ];
    }

    public static function verifyCode(string $email, string $code): array
    {
        $email = htmlspecialchars(trim($email));
        $code = trim($code);

        $storedCode = $_SESSION['verification_code'][$email] ?? null;
        $isValid = $storedCode && ((string)$storedCode === $code);

        return ['valid' => $isValid];
    }

    public static function registerUser(array $data): array
    {
        $controller = new AuthController();

        $email = filter_var($data['email'] ?? '', FILTER_VALIDATE_EMAIL);
        $username = htmlspecialchars(trim($data['name']));
        $password = password_hash(htmlspecialchars(trim($data['password'])), PASSWORD_DEFAULT);
        $user_type = htmlspecialchars(trim($data['user_type'] ?? 'client'));
        $email_verified = isset($data['is_verified']) ? 1 : 0;

        $params = [
            ':username' => $username,
            ':email' => $email,
            ':password' => $password,
            ':user_type' => $user_type,
            ':email_verified' => $email_verified,
            ':status' => 'inactive'
        ];

        if ($user_type === 'client') {
            $params[':company_name'] = htmlspecialchars(trim($data['company']));
            $params[':service_requested'] = htmlspecialchars(trim($data['service']));
        }

        if ($user_type === 'freelancer') {
            $params[':business_name'] = htmlspecialchars(trim($data['business']));
            $params[':service_rendered'] = htmlspecialchars(trim($data['services']));
            $params[':experience'] = htmlspecialchars(trim($data['experience']));
        }

        $result = $controller->register($params);

        unset($_SESSION['verification_code'][$email]);

        return [
            'status' => $result ? 200 : 400,
            'message' => $result ? 'Registration Success' : 'Registration Failure...'
        ];
    }
}
