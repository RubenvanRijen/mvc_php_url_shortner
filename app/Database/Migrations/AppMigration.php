<?php

namespace MvcPhpUrlShortner\Database\Migrations;

use MvcPhpUrlShortner\Database\Database;
use PDO;

class  AppMigration
{

    private PDO $db;
    private array $migrations = [];

    public function __construct()
    {
        $this->db = Database::getInstance();;
    }

    /**
     * add all the migrations to be called for a migration call.
     * @return void
     */
    private function populateMigrations(): void
    {
        array_push($this->migrations, new UrlMigration($this->db));
    }

    /**
     * @return void
     */
    public function migrateApplication(): void
    {
        $this->populateMigrations();
        foreach ($this->migrations as $migration) {
            $migration->up();
        }
    }

    public function unMigrateApplication()
    {
        $this->populateMigrations();
        foreach ($this->migrations as $migration) {
            $migration->down();
        }
    }

}
