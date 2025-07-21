<?php
// App/Http/Controllers/Api/UserDataApiController.php

namespace App\Http\Controllers\Api;

class UserDataApiController
{
    public function checkEmail()
    {
        require_once __DIR__ . '/../../../Helper/api_functions.php';
        echo processRequest('user-email-check');
    }

    public function sendCode()
    {
        require_once __DIR__ . '/../../../Helper/api_functions.php';
        echo processRequest('send_code');
    }

    public function verifyCode()
    {
        require_once __DIR__ . '/../../../Helper/api_functions.php';
        echo processRequest('verify_code');
    }

    public function registerUser()
    {
        require_once __DIR__ . '/../../../Helper/api_functions.php';
        echo processRequest('register_user');
    }
}
