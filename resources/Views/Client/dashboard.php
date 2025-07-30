<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client</title>
</head>

<body>
    <h1>Client</h1>
</body>

</html>

<?php
// public/api/dashboard.php


use App\Http\Controllers\Api\Dashboard\DashboardController;

if (!isset($_SESSION['user_details'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$user = $_SESSION['user_details'];
$controller = new DashboardController($user['user_type'], $user['id']);
print_r($controller->getDashboardData());
?>
