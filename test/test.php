<?php

use App\Http\Controllers\Api\UserDataApiController;

$test_api = new UserDataApiController();
echo '<pre>';
print_r($test_api->data());
echo '</pre>';
