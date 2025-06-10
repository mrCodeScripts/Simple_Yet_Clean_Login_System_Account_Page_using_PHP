<?php

use PHPUnit\Framework\Constraint\Callback;

function isAlreadyLoggedIn(): bool
{
  return !empty($_SESSION["CURRENT_SESSION_DATA"]["UUID"]);
}

// CHECK IF USERNAME ALREADY EXIST
function isUsernameAlreadyUsed(PDO $connection, string $username): bool
{
  $query = "SELECT acc_uuid FROM user_account WHERE acc_username = :acc_username";
  $statement = $connection->prepare($query);
  $statement->bindParam(":acc_username", $username);
  $statement->execute();
  $data = $statement->fetchAll(PDO::FETCH_ASSOC) ?? null;
  return !empty($data);
};

function passwordCreationValidation(
  string $created,
  string $confirmed,
  bool $returnHashPwd
): string|bool {
  if ($created !== $confirmed) return false;
  return $returnHashPwd ? password_hash($confirmed, PASSWORD_BCRYPT) : true;
}

// GENERATE UNIQUE ID FOR THE ACCOUNT
function uuidv4()
{
  $data = random_bytes(16);
  $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
  $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
  return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

// CREATE ACCOUNT
function createAccount(
  PDO $connection,
  string $uuid,
  string $username,
  string $password,
  bool $returnUUID
): bool | string {
  try {
    $filteredUsername = htmlspecialchars(stripslashes(strip_tags($username)));
    $createAcc = "INSERT INTO user_account (
      acc_uuid, 
      acc_username, 
      acc_password
    ) 
    VALUES (
      :acc_uuid, 
      :acc_username, 
      :acc_password
    );";
    $statement_1 = $connection->prepare($createAcc);
    $statement_1->bindParam(":acc_username", $filteredUsername);
    $statement_1->bindParam(":acc_uuid", $uuid);
    $statement_1->bindParam(":acc_password", $password);

    $initializeAccInfo = "INSERT INTO user_info (acc_uuid) VALUES (:uuid);";
    $statement_2 = $connection->prepare($initializeAccInfo);
    $statement_2->bindParam(":uuid", $uuid);

    if (isUsernameAlreadyUsed($connection, $filteredUsername)) {
      throw new Exception(json_encode([
        "error" => "Username already used. Please try again."
      ]));
    }

    $exec_1 = $statement_1->execute();
    $exec_2 = $statement_2->execute();

    if (!($exec_1 && $exec_2)) return false;
    return $returnUUID ? $uuid : true;
  } catch (Exception $e) {
    die($e->getMessage());
  }
}

function getAccountData(PDO $connection, string $uuid): array|null
{
  $query = "SELECT * 
    FROM user_account AS ua
    LEFT JOIN user_info AS ui 
      ON ua.acc_uuid = ui.acc_uuid
    LEFT JOIN user_profile_img AS upi 
      ON ui.user_profile_img_id = upi.user_profile_img_id
    LEFT JOIN user_gender AS ug 
      ON ui.user_gender_id = ug.gender_id
    WHERE ua.acc_uuid = :uuid;";
  $statement = $connection->prepare($query);
  $statement->bindParam(":uuid", $uuid);
  $statement->execute();
  $data = $statement->fetchAll(PDO::FETCH_ASSOC) ?? null;
  return $data[0];
}

function setAccountData(
  string $uuid,
  string $username,
  string $hashedPassword,
  ?string $firstname = null,
  ?string $lastname = null,
  ?string $birthDate = null,
  ?string $gender = null,
  ?string $mobileNumber = null,
  ?string $email = null,
  ?string $weight = null,
  ?string $height = null,
  ?string $profile_img_path = null,
  ?string $profile_img_id = null,
  ?string $profile_img_date_added = null
): bool | array {
  if (session_status() === PHP_SESSION_NONE) return false;
  $data = [
    "UUID" => $uuid,
    "ACC_INF" => [
      "Username" => $username,
      "Password" => $hashedPassword,
      "Firstname" => $firstname,
      "Lastname" => $lastname,
      "Birthdate" => $birthDate,
      "Gender" => $gender,
      "Mobile_number" => $mobileNumber,
      "Email" => $email,
      "Weight" => $weight,
      "Height" => $height,
      "Profile_Image" => [
        "id" => $profile_img_id,
        "path" => $profile_img_path,
        "date" => $profile_img_date_added
      ]
    ],
  ];
  $_SESSION["CURRENT_SESSION_DATA"] = $data;
  return $data;
}

function logout(?callable $callback = null): void
{
  $_SESSION["CURRENT_SESSION_DATA"] = null;
  session_regenerate_id(true);
  $callback();
}

function spillJSON(array $keys): array
{
  $collected = [];
  $JSON = json_decode(file_get_contents("php://input"), true);
  foreach ($keys as $k) {
    $collected[$k] = $JSON[$k];
  }
  return $collected;
}

function findAccount(PDO $connection, string $username): array | string | bool
{
  $query = "SELECT * FROM user_account WHERE acc_username = :username;";
  $statement = $connection->prepare($query);
  $statement->bindParam(":username", $username);
  $statement->execute();
  return $statement->fetchAll(PDO::FETCH_ASSOC)[0] ?? false;
}

function updateAcc(
  PDO $connection,
  ?string $uuid = null,
  ?string $tableName = null,
  ?string $columnName = null,
  mixed $columnData
): bool {
  if (
    !empty($connection) && !empty($uuid) && !empty($tableName) && !empty($columnName) && !empty($columnData)
  ) {
    $filteredColumnData = htmlspecialchars(stripslashes(strip_tags($columnData)));
    $query = "UPDATE {$tableName} SET {$columnName} = :new_data WHERE acc_uuid = :uuid;";
    $statement = $connection->prepare($query);
    $statement->bindParam(":new_data", $filteredColumnData);
    $statement->bindParam(":uuid", $uuid);
    return boolval($statement->execute());
  } else {
    return false;
  }
}

function isUserExist(PDO $connection, string $uuid): bool
{
  $findAcc = getAccountData($connection, $uuid);
  return !empty($findAcc) ? true : false;
}

function destroyIfUserNonexist(PDO $connection, string $uuid)
{
  if (!isUserExist($connection, $uuid)) {
    $_SESSION["CURRENT_SESSION_DATA"] = null;
    session_regenerate_id(true);
    session_destroy();
  }
}

function mainAccountPageInitialLoad(PDO $connection)
{
  destroyIfUserNonexist($connection, $_SESSION["CURRENT_SESSION_DATA"]["UUID"]);
  if (!isAlreadyLoggedIn()) header("Location: ./login.php");
  $accountData = getAccountData($connection, $_SESSION["CURRENT_SESSION_DATA"]["UUID"]);
  setAccountData(
    $accountData["acc_uuid"],
    $accountData["acc_username"],
    $accountData["acc_password"],
    $accountData["user_firstname"],
    $accountData["user_lastname"],
    $accountData["user_birthdate"],
    $accountData["gender_id"],
    $accountData["user_mobile_number"],
    $accountData["user_email"],
    $accountData["user_weight"],
    $accountData["user_height"],
    $accountData["user_profile_filepath"],
    $accountData["user_profile_img_id"],
    $accountData["user_profile_date_added"]
  );
}

function isUserHasProfileImg (PDO $connection, string $uuid): bool {
  $query = "SELECT user_profile_img_id FROM user_info WHERE acc_uuid = :uuid;";
  $statement = $connection->prepare($query);
  $statement->bindParam(":uuid", $uuid);
  $statement->execute();
  $data = $statement->fetchAll(PDO::FETCH_ASSOC);
  return !empty($data[0]["user_profile_img_id"]) ? true : false;
}

function storeAccProfileImgData(PDO $connection, string $uuid, string $filePath): bool
{
  $id = uuidv4();
  $query = "INSERT INTO user_profile_img (user_profile_img_id, user_profile_filepath) VALUES (:id, :filepath);";
  $statement = $connection->prepare($query);
  $statement->bindParam(":id", $id);
  $statement->bindParam(":filepath", $filePath);
  $execution = $statement->execute();
  $update = updateAcc($connection, $uuid, "user_info", "user_profile_img_id", $id);
  return boolval($execution && $update);
}


function updateAccProfileImgData (PDO $connection, string $filePath, string $profile_img_id): bool
{
  $id = uuidv4();
  $query = "UPDATE user_profile_img SET user_profile_filepath = :filepath WHERE user_profile_img_id = :img_id;";
  $statement = $connection->prepare($query);
  $statement->bindParam(":img_id", $profile_img_id);
  $statement->bindParam(":filepath", $filePath);
  $update = $statement->execute();
  return boolval($update);
}