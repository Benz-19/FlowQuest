<?php
// dir App/Models/DB.php
namespace App\Models;

use PDO;
use Exception;
use PDOException;

class DB
{
    private $conn;

    public function __construct()
    {
        $db_config_path =  __DIR__ . '/../../config/database.php';
        if (!file_exists($db_config_path)) {
            throw new Exception('database configuration file does not exists...');
            error_log('Error:No database config file found.');
        }

        $db_config = require $db_config_path;
        // ensure we have some values
        if (empty($db_config)) {
            throw new Exception('database configuration file is empty, ensure it has some values...');
            error_log('Error: Database config file return nothing. Review the file.');
        }

        try {
            $dsn = "mysql:host={$db_config['db_host']};dbname={$db_config['db_name']};port={$db_config['port']};charset={$db_config['charset']};";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ];
            $this->conn = new PDO($dsn, $db_config['db_username'], $db_config['db_password'], $options);
        } catch (PDOException $error) {
            error_log('Database connection error. ErrorType: ' . $error->getMessage());
        } catch (Exception $error) {
            error_log('Something went wrong in the DB class. ErrorType: ' . $error->getMessage());
        }
    }

    // Verifies a db connection
    public function verify_connection()
    {
        if (!$this->conn) {
            $this->__construct();
        }
    }

    // verifies and returns a connection to the db
    public function connection()
    {
        $this->verify_connection();
        return $this->conn;
    }

    // closes the db connection
    public function close_connection()
    {
        $this->conn = null;
    }

    /**
     * Responsible for executing all SQL commands (SELECT, UPDATE, DELETE, etc...)
     * based on the query and params specified
     * @param string $query stores the SQL query to be executed
     * @param array $params is an associative array that stores the prepared statement
     * @param return the retutn type is an array|null
     */
    public function execute(string $query, $params = [])
    {
        $this->verify_connection();

        $stmt = $this->conn->prepare($query);
        return $stmt->execute($params);
    }

    /**
     * Responsible for retreiving a single db data based on the query and params specified
     * @param string $query stores the SQL query to be executed
     * @param array $params is an associative array that stores the prepared statement
     * @param return the retutn type is an array|null
     */
    public function fetchSingleData(string $query, array $params = []): ?array
    {
        $this->verify_connection();
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res ?: null;
    }

    /**
     * Responsible for retreiving all db data based on the query and params specified
     * @param string $query stores the SQL query to be executed
     * @param array $params is an associative array that stores the prepared statement
     * @param return the retutn type is an array|null
     */
    public function fetchAllData(string $query, array $params = []): ?array
    {
        $this->verify_connection();
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $res ?: null;
    }

    // Added DB features
    public function beginTransaction(): void
    {
        $this->verify_connection();
        $this->conn->beginTransaction();
    }

    public function commit(): void
    {
        $this->verify_connection();
        $this->conn->commit();
    }

    public function rollBack(): void
    {
        $this->verify_connection();
        $this->conn->rollBack();
    }

    public function lastInsertId(): string
    {
        return $this->conn->lastInsertId();
    }
}
