<?php

declare(strict_types=1);

require_once __DIR__ . "/../bootstrap.php";

if (isAlreadyLoggedIn()) header("Location: ./../pages/account.php");

$username = $_POST["signup-username"] ?? null;
$create_password = $_POST["signup-create-password"] ?? null;
$confirm_password = $_POST["signup-confirm-password"] ?? null;

if (strtolower($_SERVER["REQUEST_METHOD"]) !== "post") {
  http_response_code(404);
  die();
}

if (empty($username) || empty($create_password) || empty($confirm_password)) {
  http_response_code(404);
  die();
}

if (isUsernameAlreadyUsed($connection, $username))
  die(json_encode(["error" => "Username already exist!"]));

$passwordCreationValidation = passwordCreationValidation(
  $create_password,
  $confirm_password,
  true
);

if (!$passwordCreationValidation) header("Location: ./../pages/signup.php");

if (isUsernameAlreadyUsed($connection, $username)) http_response_code(404);

$uuid = createAccount($connection, uuidv4(), $username, $passwordCreationValidation, true);

if (!$uuid) http_response_code(404);

$accountData = getAccountData($connection, $uuid);
setAccountData(
  $accountData["acc_uuid"],
  $accountData["acc_username"],
  $accountData["acc_password"],
  $accountData["user_firstname"],
  $accountData["user_lastname"],
  $accountData["user_age"],
  $accountData["user_birthdate"],
  $accountData["gender_name"],
  $accountData["user_bio"],
  $accountData["user_profile_img_id"],
  $accountData["user_profile_filepath"],
  $accountData["user_profile_date_added"]
);
session_regenerate_id(true);
header("Location: ./../pages/account.php");
