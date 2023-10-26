<?php

namespace MvcPhpUrlShortner\Database\Migrations;

use MvcPhpUrlShortner\Interfaces\MigrationInteface;
use PDO;

abstract class BaseMigration implements MigrationInteface
{

    private PDO $db;

    /**
     * constructor
     * @param PDO $db
     */
    public function __construct(PDO $db)
    {
        $this->setDb($db);
    }

    public function getDb(): PDO
    {
        return $this->db;
    }

    public function setDb(PDO $db): void
    {
        $this->db = $db;
    }

}