<?php
// dir: App/Http/Controllers/Api
namespace App\Http\Controllers\Api;

// Responsible for all users(admin, freelancer, client) data handling
// UserDataApiController should be able to retrieve and send user related data from and to the database
class UserDataApiController
{
    public function data()
    {
        require __DIR__ . '/../../../Helper/api_functions.php';
        return processRequest('users');
    }
}
