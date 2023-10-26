<?php

namespace MvcPhpUrlShortner\Database\Seeders;

use MvcPhpUrlShortner\Database\Database;
use PDO;

class AppSeeder
{
    private PDO $db;
    private array $seeders = [];

    public function __construct()
    {
        $this->db = Database::getInstance();
    }


    /**
     * add all the seeders to be called for a seed.
     * @return void
     */
    private function populateSeeder(): void
    {
        array_push($this->seeders, new UrlSeeder($this->db));

    }


    /**
     * seed the database with data.
     * @return void
     */
    public function seedApplication(): void
    {
        $this->populateSeeder();
        foreach ($this->seeders as $seeder) {
            $seeder->seed();
        }
    }

}
