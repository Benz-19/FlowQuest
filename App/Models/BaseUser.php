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
     * Determine if a user exists
     * @param string $user_email
     * @return bool
     */
    public function isUser(string $user_email): ?bool
    {
        try {
            $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
            $params = [':email' => $user_email];
            $result = $this->fetchSingleData($query, $params);
            return $result !== null;
        } catch (PDOException | Exception $error) {
            error_log("Error in BaseUser::isUser - " . $error->getMessage());
            return false;
        }
    }

    /**
     * Check if a user's account is verified
     * @param string $email
     * @return bool
     */
    public function isVerified(string $email): ?bool
    {
        try {
            $query = "SELECT is_verified FROM users WHERE email = :email LIMIT 1";
            $params = [':email' => $email];
            $result = $this->fetchSingleData($query, $params);
            return isset($result['is_verified']) && $result['is_verified'] == 1;
        } catch (PDOException | Exception $e) {
            error_log("Error in BaseUser::isVerified - " . $e->getMessage());
            return false;
        }
    }

    /**
     * Mark a user's account as verified
     * @param string $email
     * @return bool
     */
    public function verifyUser(string $email): bool
    {
        try {
            $query = "UPDATE users SET is_verified = 1 WHERE email = :email";
            $params = [':email' => $email];
            return $this->execute($query, $params);
        } catch (PDOException | Exception $e) {
            error_log("Error in BaseUser::verifyUser - " . $e->getMessage());
            return false;
        }
    }

    public function register(array $params = [])
    {
        try {
            // Start transaction
            $this->beginTransaction();

            $user_details = [];

            // remove
            if ($params[':user_type'] === 'client') {
                $user_details = [
                    ':company_name' => $params[':company_name'],
                    ':service_requested' => $params[':service_requested']
                ];
                unset($params[':company_name']);
                unset($params[':service_requested']);
            }

            if ($params[':user_type'] === 'freelancer') {
                $user_details = [
                    ':business_name' => $params[':business_name'],
                    ':service_rendered' => $params[':service_rendered'],
                    ':experience' => $params[':experience']
                ];
                unset($params[':business_name']);
                unset($params[':service_rendered']);
                unset($params[':experience']);
            }

            // Insert user
            $this->manageUser('create', $params);

            // Get the last inserted user_id
            // $email = htmlspecialchars(trim($params[':email']));
            // $userId = $this->getUserIdByEmail($email);
            $userId = $this->lastInsertId();

            $user_details[':user_id'] = $userId;
            // Insert into the appropriate details table
            $userType = $params[':user_type'];

            if ($userType === 'freelancer') {
                $detailsQuery = "INSERT INTO freelancer_details (user_id, business_name, service_rendered, experience)
                             VALUES (:user_id, :business_name, :service_rendered, :experience)";
                $this->execute($detailsQuery, [
                    ':user_id' => $userId,
                    ':business_name' => $user_details[':business_name'],
                    ':service_rendered' => $user_details[':service_rendered'],
                    ':experience' => $user_details[':experience'],
                ]);
            } elseif ($userType === 'client') {
                $detailsQuery = "INSERT INTO client_details (user_id, company_name, service_requested)
                             VALUES (:user_id, :company_name, :service_requested)";
                $this->execute($detailsQuery, [
                    ':user_id' => $userId,
                    ':company_name' => $user_details[':company_name'],
                    ':service_requested' => $user_details[':service_requested']
                ]);
            }

            // Commit transaction
            $this->commit();
            return true;
        } catch (PDOException | Exception $error) {
            // Rollback on error
            $this->rollBack();
            error_log('Error in BaseUser::register - ' . $error->getMessage());
            return false;
        }
    }

    public function login(array $params = []): bool
    {
        $email = $params['email'];
        $password = $params['password'];

        if (!$this->isUser($email)) {
            return false;
        }

        try {
            $query = "SELECT password FROM users WHERE email=:email Limit 1";
            $params = [':email' => $email];
            $result = $this->fetchSingleData($query, $params);

            if (password_verify($password, $result['password'])) {
                return true;
            }
            error_log('password verification failed.');
            return false;
        } catch (PDOException | Exception $error) {
            error_log('Error in BaseUser::login - ' . $error->getMessage());
            return false;
        }
    }

    public function updatePassword(array $params = [])
    {
        $email = $params[':email'];
        $password = $params[':password'];
        try {
            $query = "UPDATE users SET password=:password WHERE email=:email";
            $parameters = [
                ':password' => $password,
                ':email' => $email
            ];

            $result = $this->execute($query, $parameters);

            return $result ? true : false;
        } catch (PDOException | Exception $error) {
            error_log('Error in BaseUser::updatePassword - ' . $error->getMessage());
            return false;
        }
    }

    public function getUserType(string $email)
    {
        try {
            $query = "SELECT user_type FROM users WHERE email=:email LIMIT 1";
            $params = [':email' => $email];
            $res = $this->fetchSingleData($query, $params);

            return $res['user_type'];
        } catch (PDOException | Exception $error) {
            error_log('Error in BaseUser::login - ' . $error->getMessage());
            return;
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
     * @param string $query stores the SQL query needed to retrieve data
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


    /**
     * The method below retrieves all the users id using their email
     * @param string $user_email stores the user's email
     * @param string $query stores the SQL query needed to retrieve data
     */
    public function getUserIdByEmail(string $user_email): ?string
    {
        try {
            $query = "SELECT id FROM users WHERE email=:email LIMIT 1";
            $params = [
                ":email" => $user_email
            ];
            $id =  $this->fetchSingleData($query, $params);
            return $id['id'];
        } catch (PDOException | Exception $error) {
            error_log("Error in BaseUser::getAllUserData - " . $error->getMessage());
            return null;
        }
    }
}
