<?php

use MvcPhpUrlShortner\Database\Database;

require_once 'app/Database/Database.php';

return $createTableSQL = "CREATE TABLE IF NOT EXISTS urls (
    id INT AUTO_INCREMENT PRIMARY KEY,
    original_url VARCHAR(255) NOT NULL,
    short_url VARCHAR(255) NOT NULL
)";

