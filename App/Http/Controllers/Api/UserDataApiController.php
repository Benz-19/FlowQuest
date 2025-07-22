<?php
// File: App/Http/Controllers/Api/UserDataApiController.php

namespace App\Http\Controllers\Api;

use App\Services\Auth\AuthService;



class UserDataApiController
{
    public function checkEmail()
    {
        $email = $_GET['email'] ?? '';
        $user_type = $_GET['user_type'] ?? '';
        echo json_encode(AuthService::checkEmail($email, $user_type));
    }

    public function sendCode()
    {
        $email = $_POST['email'] ?? '';
        $name  = $_POST['name'] ?? '';
        echo json_encode(AuthService::sendCode($email, $name));
    }

    public function verifyCode()
    {
        $email = $_POST['email'] ?? '';
        $code = $_POST['code'] ?? '';
        echo json_encode(AuthService::verifyCode($email, $code));
    }

    public function registerUser()
    {
        $data = $_POST;
        echo json_encode(AuthService::registerUser($data));
    }
}
