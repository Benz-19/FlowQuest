<?php
//dir:App/Models/Interfaces/UserInterface.php
namespace App\Models\Interfaces;

interface UserInterface
{
    public function manageUser(string $action, array $params);
    public function getUserDetailsById(int $user_id);
};
