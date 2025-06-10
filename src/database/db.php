<?php

declare(strict_types=1);

$DATABASE_HOST = "localhost";
$DATABASE_NAME = "login_signup_system";
$DATABASE_USERNAME = "root";
$DATABASE_PASSWORD = "";
$DATABASE_OPTIONS = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

$DATABASE_DSN = "mysql:host={$DATABASE_HOST};dbname={$DATABASE_NAME};charset=utf8";

try {
  $connection = new PDO(
    $DATABASE_DSN,
    $DATABASE_USERNAME,
    $DATABASE_PASSWORD,
    $DATABASE_OPTIONS
  );
} catch (PDOException $e) {
  die($e->getMessage());
}
