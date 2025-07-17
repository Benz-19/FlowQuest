<?php
//dir:App/Models/Admin.php
namespace App\Models;

class Admin extends BaseUser
{
    protected string $detailsTable = 'admin_details';
}
