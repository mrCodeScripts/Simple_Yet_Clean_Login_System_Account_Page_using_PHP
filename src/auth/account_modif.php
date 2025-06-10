<?php

declare(strict_types=1);

include_once __DIR__ . "/../bootstrap.php";

destroyIfUserNonexist($connection, $_SESSION["CURRENT_SESSION_DATA"]["UUID"]);

if (strtolower($_SERVER["REQUEST_METHOD"]) !== "post") http_response_code(404);

// COLLECT THE DATA
$dataCollection = [
  "user_account" => [
    "acc_username" => $_POST["user-username"] ?? null,
  ],
  "user_info" => [
    "user_firstname" => $_POST["user-firstname"] ?? null,
    "user_lastname" => $_POST["user-lastname"] ?? null,
    "user_birthdate" => $_POST["user-birthdate"] ?? null,
    "user_gender_id" => $_POST["user-gender"] ?? null,
    "user_email" => $_POST["user-email"] ?? null,
    "user_mobile_number" => $_POST["user-mobile-number"] ?? null,
    "user_weight" => $_POST["user-weight"] ?? null,
    "user_height" => $_POST["user-height"] ?? null
  ]
];

foreach ($dataCollection as $table => $column_data) {
  foreach ($column_data as $column => $data) {
    updateAcc($connection, $_SESSION["CURRENT_SESSION_DATA"]["UUID"], $table, $column, $data);
  }
}

header("Location: ./../pages/account.php");
