<?php

declare(strict_types=1);

require_once __DIR__ . "/../bootstrap.php";

if (isAlreadyLoggedIn()) header("Location: ./../pages/account.php");

if (strtolower($_SERVER["REQUEST_METHOD"]) !== "post")
  http_response_code(404);

$username = trim($_POST["login-username"] ?? "");
$password = trim($_POST["login-password"] ?? "");

if (empty($username) || empty($password)) {
  http_response_code(404);
} else {
  $username = htmlspecialchars(stripslashes(strip_tags($_POST["login-username"])));
  $password = htmlspecialchars(stripslashes(strip_tags($_POST["login-password"])));

  if (!isUsernameAlreadyUsed($connection, $username))
    http_response_code(404);

  $findAccount = findAccount($connection, $username);

  if (password_verify($password, $findAccount["acc_password"])) {
    $accountData = getAccountData($connection, $findAccount["acc_uuid"]);
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
  } else {
    header("Location: ./../pages/login.php");
  }
}

header("Location: ./../pages/login.php");
