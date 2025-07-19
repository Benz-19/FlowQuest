<?php
//dir:App/Models/Client.php
namespace App\Models;

class Client extends BaseUser
{
    protected string $detailsTable = 'client_details';

    public function isVerified(string $email): bool
    {
        // Placeholder logic (you can customize it)
        return false;
    }

    public function verifyUser(string $email): bool
    {
        // Placeholder logic (you can customize it)
        return true;
    }
}
