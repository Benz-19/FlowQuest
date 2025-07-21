<?php
//dir App/Http/Cpntollers/Auth
namespace App\Http\Controllers\Auth;

use App\Models\Admin;
use App\Models\Client;
use App\Models\Freelancer;
use Exception;
use PDOException;

header('Content-Type: application/json');

class AuthController
{
    private function redirectToLogin(string $user)
    {
        $path = '';

        //determine path to user (admin, client, freelancer) registration page
        if ($user === 'client') {
            $path = '/register-client';
        } else if ($user === 'freelancer') {
            $path = '/register-freelancer';
        } else {
            $path = '/register-admin';
        }
        header("Location: $path");
        exit;
    }

    public function register(array $params = [])
    {
        if (!isset($params[':user_type'])) {
            error_log('User Type was not specified');
            header('Location: /register');
            exit;
        }
        $user_type = $params[':user_type'];
        try {
            $user = match ($user_type) {
                'admin' => new Admin(),
                'freelancer' => new Freelancer(),
                'client' => new Client(),
                default => null
            };

            $result = $user->register($params);
            return $result;
        } catch (PDOException $error) {
            error_log('New user registration failed at AuthController::register. ErrorType: ' . $error->getMessage());
            return false;
        } catch (Exception $error) {
            error_log('Something went wrong at AuthController::register');
            return false;
        }
    }

    public function login()
    {
        // login
    }

    public function logout()
    {
        // logout
    }
}
