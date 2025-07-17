<?php
// dir:App/Helper/api_functions.php

use App\Models\DB;

function processRequest(string $table)
{
    $request_method = $_SERVER['REQUEST_METHOD'];

    $jsonResponse = [];
    switch ($request_method) {
        case 'GET':
            $jsonResponse = handleGetMethod($table);
            break;

        case 'POST':
            $jsonResponse = handlePostMethod($table);
            break;

        default:
            $jsonResponse = handleServerError($request_method); //handles potential server error
            break;
    }
    return $jsonResponse;
}

function handleGetMethod(string $table)
{
    $query = "SELECT * FROM $table";
    $db = new DB();
    $result = $db->fetchAllData($query);

    $data = [];

    if ($result === null || empty($result)) {
        $data = [
            'data' => null,
            'status' => 404,
            'message' => 'No data found.',
        ];
    } else {
        $data = [
            'data' => $result,
            'status' => 200,
            'message' => 'Successfully obtained the data',
        ];
    }

    return json_encode($data);
}

function handlePostMethod()
{
    //
}

function handlePutMethod()
{
    //
}

function handleDeleteMethod()
{
    //
}

function handleServerError(string $request_method)
{
    $data = [
        'data' => null,
        'status' => 500,
        'message' => 'Server Error. Unknown request method' . $request_method
    ];
    return json_encode($data);
}
