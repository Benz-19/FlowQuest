<?php
//dir App/Http/Cpntollers/Auth
namespace App\Http\Controllers\Auth;

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

    public function register()
    {
        if (isset($_POST['experience'])) {
            $user = htmlspecialchars(trim($_POST['user_type']));
            $this->redirectToLogin($user);
        }

        header('Location: /');
        exit;
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
