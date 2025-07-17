<?php
//dir:App/Models/Client.php
namespace App\Models;

class Client extends BaseUser
{
    protected string $detailsTable = 'client_details';
}
