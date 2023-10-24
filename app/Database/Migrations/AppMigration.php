<?php


use MvcPhpUrlShortner\Database\Database;

$UrlMigration = require __DIR__ . "/UrlMigration.php";

$migratios = [$UrlMigration];

$db = Database::getInstance();
foreach ($migratios as $migration) {
    $db->exec($migration);
}