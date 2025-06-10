<?php

declare(strict_types=1);

require_once __DIR__ . "/../bootstrap.php";

if (strtolower($_SERVER["REQUEST_METHOD"]) !== "post") {
  http_response_code(404);
  exit;
}

$uploadedFile = $_FILES["user-profile-img-file"] ?? null;
$folder = "./../../uploads/user_profile_img";

if (!$uploadedFile || $uploadedFile['error'] !== UPLOAD_ERR_OK) {
  http_response_code(400);
  exit;
}

if (!is_dir($folder)) {
  mkdir($folder, 0777, true);
}

$file_tmp_name = $uploadedFile["tmp_name"];
$file_type = $uploadedFile["type"];
$file_size = $uploadedFile["size"];
$file_name = basename($uploadedFile["name"]); // Prevent directory traversal

// Modify the file name before saving
$SESSION_DATA = $_SESSION["CURRENT_SESSION_DATA"];
$extension = pathinfo($file_name, PATHINFO_EXTENSION);
$file_name = $SESSION_DATA["UUID"] . $SESSION_DATA["ACC_INF"]["Username"];
$new_file_name = $file_name . "." . $extension;
$destination = $folder . "/" . $new_file_name;

foreach (glob($folder . "/" . $file_name . ".*") as $existingFile) unlink($existingFile); 
if (move_uploaded_file($file_tmp_name, $destination)) {
  echo json_encode([
    "success" => true,
    "file_name" => $new_file_name,
    "file_type" => $file_type,
    "file_size" => $file_size,
    "file_path" => $destination
  ]);
} else {
  http_response_code(500);
  echo json_encode(["error" => "Failed to move uploaded file"]);
}

if (isUserHasProfileImg($connection, $SESSION_DATA["UUID"])) {
  updateAccProfileImgData($connection, $destination, $SESSION_DATA["ACC_INF"]["Profile_Image"]["id"]);
} else {
  storeAccProfileImgData($connection, $SESSION_DATA["UUID"], $destination);
}

header("Location: ./../pages/account.php");
