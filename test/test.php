<?php

use App\Models\DB;

// use App\Http\Controllers\Api\UserDataApiController;

// $test_api = new UserDataApiController();
// echo '<pre>';
// print_r($test_api->getData());
// echo '</pre>';

$id = (new DB)->execute("SELECT id FROM users WHERE email='kingsley@flowquest.io' LIMIT 1");
echo $id['id'];
