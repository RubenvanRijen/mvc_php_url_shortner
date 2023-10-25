<?php

use MvcPhpUrlShortner\Database\Migrations\AppMigration;

require 'vendor/autoload.php';

$appSeeder = new AppMigration();
$appSeeder->unMigrateApplication();
