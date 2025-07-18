<?php
// dir: App/Helper/api_functions.php

use App\Models\DB;
use App\Models\Freelancer;

/**
 * Handles incoming requests (GET, POST, etc.)
 */
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

    // Output as JSON
    header('Content-Type: application/json');
    echo $jsonResponse;
    exit;
}

function handleGetMethod($request_data)
{
    // Email existence check
    if ($request_data === 'user-email-check' && isset($_GET['email'])) {
        $email = htmlspecialchars(trim($_GET['email']));
        $freelancer = new Freelancer();
        $exists = $freelancer->isUser($email);

        return json_encode([
            'exists' => $exists
        ]);
    }

    // Generic table data fetch
    if (!empty($request_data)) {
        $query = "SELECT * FROM $request_data";
        $db = new DB();
        $result = $db->fetchAllData($query);

        return json_encode([
            'data' => $result,
            'status' => 200,
            'message' => 'Data fetched successfully'
        ]);
    }

    return json_encode([
        'data' => null,
        'status' => 400,
        'message' => 'Missing or invalid request parameter'
    ]);
}

function handlePostMethod($request_data)
{
    // Placeholder for POST logic (e.g. new registration)
    return json_encode([
        'status' => 501,
        'message' => 'POST method not implemented yet'
    ]);
}

function handleServerError(string $request_method)
{
    return json_encode([
        'data' => null,
        'status' => 500,
        'message' => "Server Error. Unknown request method: $request_method"
    ]);
}
