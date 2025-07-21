<?php
// File: App/Helper/api_functions.php

use App\Models\DB;
use App\Models\Admin;
use App\Models\Client;
use App\Models\Freelancer;
use App\Helper\Mailer;
use App\Http\Controllers\Auth\AuthController;

function processRequest($request_data)
{
    $request_method = $_SERVER['REQUEST_METHOD'];
    $jsonResponse = [];

    switch ($request_method) {
        case 'GET':
            $jsonResponse = handleGetMethod($request_data);
            break;

        case 'POST':
            $jsonResponse = handlePostMethod($request_data);
            break;

        default:
            $jsonResponse = handleServerError($request_method);
            break;
    }

    header('Content-Type: application/json');
    echo $jsonResponse;
    exit;
}

function handleGetMethod($request_data)
{
    if ($request_data === 'user-email-check' && isset($_GET['email'])) {
        $email = htmlspecialchars(trim($_GET['email']));
        $user_type = $_GET['user_type'];

        $user = match ($user_type) {
            'freelancer' => new Freelancer(),
            'client'     => new Client(),
            'admin'      => new Admin(),
            default      => null
        };

        $exists = $user && $user->isUser($email);

        return json_encode(['exists' => $exists]);
    }

    return json_encode([
        'data' => null,
        'status' => 400,
        'message' => 'Missing or invalid request parameter'
    ]);
}

function handlePostMethod($request_data)
{
    if ($request_data === 'send_code' && isset($_POST['email']) && isset($_POST['name'])) {
        $email = htmlspecialchars(trim($_POST['email']));
        $name = htmlspecialchars(trim($_POST['name']));
        $code = rand(100000, 999999);

        // Store the code in session
        $_SESSION['verification_code'][$email] = $code;

        $mailer = new \App\Helper\Mailer();
        $sent = $mailer->sendVerificationCode($email, $name, $code);

        return json_encode([
            'success' => $sent,
            'status' => $sent ? 200 : 500,
            'message' => $sent ? 'Verification code sent' : 'Failed to send email'
        ]);
    }

    if ($request_data === 'verify_code' && isset($_POST['email']) && isset($_POST['code'])) {
        $email = htmlspecialchars(trim($_POST['email']));
        $code = trim($_POST['code']);

        $storedCode = $_SESSION['verification_code'][$email] ?? null;
        $isValid = $storedCode && ((string)$storedCode === $code); // Cast both to string for safe compare

        return json_encode([
            'valid' => $isValid
        ]);
    }

    if ($request_data === 'register_user') {
        $controller = new AuthController();

        $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
        $username = htmlspecialchars(trim($_POST['name']));
        $password = password_hash(htmlspecialchars(trim($_POST['password'])), PASSWORD_DEFAULT);
        $user_type = htmlspecialchars(trim($_POST['user_type'] ?? 'client'));
        $email_verified = isset($_POST['is_verified']) ? 1 : 0;

        $params = [
            ':username' => $username,
            ':email' => $email,
            ':password' => $password,
            ':user_type' => $user_type,
            ':email_verified' => $email_verified,
            ':status' => 'inactive'
        ];

        // Add these conditionally for clients
        if ($user_type === 'client') {
            $params[':company_name'] = htmlspecialchars(trim($_POST['company']));
            $params[':service_requested'] = htmlspecialchars(trim($_POST['service']));
        }

        $result = $controller->register($params);

        unset($_SESSION['verification_code'][$email]);

        return json_encode([
            'status' => $result ? 200 : 400,
            'message' => $result ? 'Registration Success' : 'Registration Failure...'
        ]);
    }


    return json_encode([
        'status' => 400,
        'message' => 'Missing or invalid request data'
    ]);
}


function handleSendVerificationCode()
{
    $input = json_decode(file_get_contents("php://input"), true);
    $email = filter_var($input['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $name  = htmlspecialchars(trim($input['name'] ?? '')); // Optional: name for email salutation

    if (!$email) {
        return json_encode(['success' => false, 'message' => 'Invalid email address.']);
    }

    $code = rand(100000, 999999);
    $_SESSION['verification_code'] = $code;
    $_SESSION['verification_email'] = $email;

    $mailer = new Mailer();
    $sent = $mailer->sendVerificationCode($email, $name ?: 'User', $code);

    return json_encode([
        'success' => $sent,
        'message' => $sent ? 'Verification code sent.' : 'Failed to send verification code.'
    ]);
}

function handleVerifyCode()
{
    $input = json_decode(file_get_contents("php://input"), true);
    $code = trim($input['code'] ?? '');
    $email = trim($input['email'] ?? '');

    if ($_SESSION['verification_code'] === (int)$code && $_SESSION['verification_email'] === $email) {
        return json_encode(['valid' => true]);
    }

    return json_encode(['valid' => false]);
}

function handleServerError(string $request_method)
{
    return json_encode([
        'data' => null,
        'status' => 500,
        'message' => "Server Error. Unknown request method: $request_method"
    ]);
}
