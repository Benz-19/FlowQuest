<?php

namespace App\Models;

use Exception;
use PDOException;
use App\Models\DB;
use App\Models\Interfaces\UserInterface;

abstract class BaseUser extends DB implements UserInterface
{
    protected string $detailsTable;

    public function manageUser(string $action, array $params)
    {
        $query = match ($action) {
            'create' => "INSERT INTO users (username, email, password, user_type, email_verified, status)
                         VALUES (:username, :email, :password, :user_type, :email_verified, :status)",
            'update' => "UPDATE users SET username=:username, email=:email, password=:password WHERE id=:id",
            'read'   => "SELECT username, email, user_type, email_verified, status FROM users WHERE id=:id",
            'delete' => "DELETE FROM users WHERE id=:id",
            default  => throw new \InvalidArgumentException("Unsupported action '$action'")
        };

        return $this->execute($query, $params);
    }

    public function getUserDetailsById(int $user_id): ?array
    {
        try {
            $query = "SELECT u.username, u.email, u.user_type, u.email_verified, u.status,
                             d.*
                      FROM users AS u
                      JOIN {$this->detailsTable} AS d ON u.id = d.user_id
                      WHERE u.id = :id";

            return $this->fetchSingleData($query, [':id' => $user_id]);
        } catch (PDOException | Exception $error) {
            error_log("Error in BaseUser::getUserDetailsById - " . $error->getMessage());
            return null;
        }
    }
}
