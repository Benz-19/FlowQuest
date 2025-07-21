<?php
// App/Http/Controllers/Api/UserDataApiController.php

namespace App\Http\Controllers\Api;

class UserDataApiController
{
    public function getData()
    {
        require_once __DIR__ . '/../../../Helper/api_functions.php';

        // Verification code email
        if (isset($_GET['send_code'])) {
            return processRequest('send-verification-code');
        }

        // Code verification check
        if (isset($_GET['verify_code'])) {
            return processRequest('verify-code');
        }

        // Email check (e.g. ?email=abc@example.com)
        if (isset($_GET['email'])) {
            return processRequest('user-email-check');
        }

        // Generic fallback (e.g. /api/users)
        return processRequest('users');
    }

    public function postData()
    {
        require_once __DIR__ . '/../../../Helper/api_functions.php';

        if (isset($_GET['send_code'])) {
            return processRequest('send_code');
        }

        if (isset($_GET['verify_code'])) {
            return processRequest('send_code');
        }

        // fallback
        return json_encode([
            'status' => 400,
            'message' => 'Missing POST parameter'
        ]);
    }
}
