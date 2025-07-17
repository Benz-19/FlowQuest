<?php
//dir:App/Models/Freelancer.php
namespace App\Models;

class Freelancer extends BaseUser
{
    protected string $detailsTable = 'freelancer_details';
}
