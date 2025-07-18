<?php
// dir: App/Http/Controllers/Api

namespace App\Http\Controllers\Api;

class UserDataApiController
{
    public function getData()
    {
        require_once __DIR__ . '/../../../Helper/api_functions.php';

        // Check if request includes `email` param for existence check
        if (isset($_GET['email'])) {
            return processRequest('user-email-check');
        }

        // Otherwise, default table data fetch (e.g. 'users')
        return processRequest('users');
    }

    public function postData() {}
}
