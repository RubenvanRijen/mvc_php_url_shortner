<?php

require 'vendor/autoload.php'; // Include any necessary autoloader or bootstrap file
use MvcPhpUrlShortner\Database\Seeders\AppSeeder;

$appSeeder = new AppSeeder();
$appSeeder->seedApplication();
