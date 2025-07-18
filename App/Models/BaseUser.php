<?php

namespace App\Models;

use Exception;
use PDOException;
use App\Models\DB;
use App\Models\Interfaces\UserInterface;
use PDOStatement;

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

    /**
     * The isUser method is resposible for determining if a user exists
     * @param string $user_email is used to search of a user exists
     * @param return bool true | false
     */
    public function isUser(string $user_email): ?bool
    {
        try {
            $query = "SELECT * FROM users WHERE email=:email LIMIT 1";
            $params = [':email' => $user_email];
            $result = $this->fetchSingleData($query, $params);
            if ($result === null) {
                return false; // if user does not exists
            }
            return true;
        } catch (PDOException | Exception $error) {
            error_log("Error in BaseUser::isUser - " . $error->getMessage());
            return false;
        }
    }

    public function register(array $params = [])
    {
        try {
            $this->manageUser('create', $params);
        } catch (PDOException | Exception | PDOStatement $error) {
            error_log('Error in BaseUser::register - ' . $error->getMessage());
        }
    }

    /**
     * The getUserDetailsById method gets a specific user data in relations to the users and user_details table
     * the user_details table consists of (admin_details, client_details, freelancer_etails)
     * @param object $this->detailsTable could be admin_details, client_details, or freelancer_details
     * @param int $user_id is the id of the user we would like to retrieve their data
     */
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

    /**
     * The method below retrieves all the users data in relations to the users and user_details table
     * the user_details table consists of (admin_details, client_details, freelancer_etails)
     * @param string $query is stores the SQL query needed to retrieve data
     */
    public function getAllUserData()
    {

        try {
            $query = "SELECT u.username, u.email, u.user_type, u.email_verified, u.status,
                             d.*
                      FROM users AS u
                      JOIN {$this->detailsTable} AS d ON u.id = d.user_id";

            return $this->fetchAllData($query);
        } catch (PDOException | Exception $error) {
            error_log("Error in BaseUser::getAllUserData - " . $error->getMessage());
            return null;
        }
    }
}
