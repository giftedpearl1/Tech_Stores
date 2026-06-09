<?php

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();

echo "<pre>";

echo "DB_HOST via getenv(): ";
var_dump(getenv('DB_HOST'));

echo "DB_HOST via _ENV: ";
var_dump($_ENV['DB_HOST'] ?? null);

exit;