<?php

// use App\Http\Controllers\Api\UserDataApiController;

// $test_api = new UserDataApiController();
// echo '<pre>';
// print_r($test_api->getData());
// echo '</pre>';

use App\Helper\Mailer;

$mail = new Mailer();
$code = rand(1000, 9999);

$result = $mail->sendVerificationCode('ugwukingsley2019@gmail.com', 'Ugwu Kingsley', $code);

if ($result) {
    echo  'Mail was sent successfully!';
} else {
    echo 'Failed to send this email';
}
