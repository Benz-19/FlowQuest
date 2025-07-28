<?php

use App\Models\Client;
use App\Models\DB;
use App\Models\User;
use App\Services\Auth\AuthService;

// use App\Http\Controllers\Api\UserDataApiController;

// $test_api = new UserDataApiController();
// echo '<pre>';
// print_r($test_api->getData());
// echo '</pre>';

// $id = (new DB)->execute("SELECT id FROM users WHERE email='kingsley@flowquest.io' LIMIT 1");
// echo $id;
$_POST['loginBtn'] = true;
$_POST['email'] = 'code.crafter.crafter@gmail.com';
$_POST['password'] = 55555;

(new AuthService)->login();
