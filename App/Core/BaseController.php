<?php

namespace App\Core;


class BaseController
{
    public function renderView($view, $data = [])
    {
        extract($data);
        $path = dirname(__DIR__, 2) . "/resources/Views/$view.php";

        if (file_exists($path)) {
            require $path;
        } else {
            http_response_code(500);
            echo "View not found: $path";
        }
    }
}
