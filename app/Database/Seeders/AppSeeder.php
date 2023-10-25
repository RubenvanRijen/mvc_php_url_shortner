<?php

namespace MvcPhpUrlShortner\Database\Seeders;

use MvcPhpUrlShortner\Database\Database;
use PDO;

class AppSeeder
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }


    /**
     * @return void
     */
    function seedApplication(): void
    {
        $urlSeeder = new UrlSeeder($this->db);
        $urlSeeder->seed();
    }

}
