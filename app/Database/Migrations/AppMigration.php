<?php

namespace MvcPhpUrlShortner\Database\Migrations;

use MvcPhpUrlShortner\Database\Database;
use PDO;

class  AppMigration
{

    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();;
    }

    public function migrateApplication()
    {
        $urlMigration = new UrlMigration($this->db);
        $urlMigration->up();
    }

    public function unMigrateApplication()
    {
        $urlMigration = new UrlMigration($this->db);
        $urlMigration->down();
    }

}
