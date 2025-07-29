<?php
// dir:App/Http/Controllers/FreelancerController.php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Api\UserDataApiController;
use App\Models\Freelancer;

class FreelancerController
{
    public function processRegistration(array $registration_data = [])
    {
        $controller = new Freelancer();
        $controller->register($registration_data);
    }

    public function getData()
    {
        $controller = new UserDataApiController();
        // $controller->getData();
    }
}
