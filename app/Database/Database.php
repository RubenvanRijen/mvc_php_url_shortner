<?php

namespace MvcPhpUrlShortner\Database;

require_once __DIR__ . '/config.php';

use PDO;
use PDOException;

class Database
{
    private static ?self $instance = null;
    private PDO $connection;

    private function __construct(bool $mocking = false)
    {
        try {
            if (!$mocking) {
                $this->connection = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
            } else {
                $this->connection = new PDO("mysql:host=" . DB_HOST_TEST . ";dbname=" . DB_NAME_TEST, DB_USER_TEST, DB_PASSWORD_TEST);
            }
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    /**
     * get the instance of the database
     * @return PDO
     */
    public static function getInstance(bool $mocking = false): PDO
    {
        if (self::$instance === null) {
            self::$instance = new self($mocking);
        }
        return self::$instance->connection;
    }
}
