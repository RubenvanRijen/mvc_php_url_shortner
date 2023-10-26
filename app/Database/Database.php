<?php

namespace MvcPhpUrlShortner\Database;
require_once __DIR__ . '/config.php';

use PDO;
use PDOException;

class Database
{
    private static ?self $instance = null; // Corrected the type from PDO to self
    private PDO $connection;

    private function __construct()
    {

        try {
            $this->connection = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Handle the exception (e.g., log, display an error message)
            throw $e;
        }
    }

    /**
     * @return PDO
     */
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance->connection;
    }
}