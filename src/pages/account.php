<?php

require __DIR__ . "/../bootstrap.php";
mainAccountPageInitialLoad($connection);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./../../assets/css/variable.css">
  <link rel="stylesheet" href="./../../assets/css/account.css">
  <title>Account Page</title>
</head>

<body>
  <h1>
    Profile
  </h1>
  <div class="upload-profile-img-bg close-upload-profile-img">
    <form action="./../auth/account_profile_upload.php" class="upload-profile-img-input" method="POST" enctype="multipart/form-data">
      <input type="file" name="user-profile-img-file" id='user-profile-img-file'>
      <div class="upload-action-btns">
        <button type="submit" id="upload-btn">
          Upload
        </button>
        <button type="button" id="close-btn">
          Close
        </button>
      </div>
    </form>
  </div>
  <form action="./../auth/account_modif.php" method="POST" class="account-wrapper">
    <section class="account-left-section">
      <div class="user-profile-img">
        <div class="img">
          <?php
          $profile_path = $_SESSION["CURRENT_SESSION_DATA"]["ACC_INF"]["Profile_Image"]["path"] ?? null;
          if (!empty($profile_path)) {
            echo "
              <img src='{$profile_path}' alt='Profile Image' loading='lazy' width='300' height='300'>
              ";
          } else {
            echo "
              <img src='./../../assets/img/no_profile.webp' loading='lazy' alt='Profile Image' width='300' height='300'>
              ";
          }
          ?>
          <button type="button" class="edit-img">
            <div class="edit-icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-camera">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M5 7h1a2 2 0 0 0 2 -2a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1a2 2 0 0 0 2 2h1a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2" />
                <path d="M9 13a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
              </svg>
            </div>
          </button>
        </div>
      </div>
    </section>
    <section class="account-right-section">
      <div class="details user-basic-details">
        <h1>Basic Detail</h1>
        <div class="basic-detail">
          <label for="" class="basic-detail-label">
            Username
          </label>
          <div class="basic-detail-info">
            <input type="text" name="user-username" id="user-username" placeholder="Username" autocomplete="off" spellcheck="false" value='<?= $_SESSION["CURRENT_SESSION_DATA"]["ACC_INF"]["Username"] ?>'>
          </div>
        </div>
        <div class="basic-detail">
          <label for="" class="basic-detail-label">
            Full Name
          </label>
          <div class="basic-detail-info">
            <input type="text" name="user-firstname" id="user-firstname" placeholder="Firstname" autocomplete="off" spellcheck="false" value="<?= $_SESSION["CURRENT_SESSION_DATA"]["ACC_INF"]["Firstname"] ?>">
            <input type="text" name="user-lastname" id="user-lastname" placeholder="Lastname" autocomplete="off" spellcheck="false" value="<?= $_SESSION["CURRENT_SESSION_DATA"]["ACC_INF"]["Lastname"] ?>">
          </div>
        </div>
        <div class="basic-detail">
          <label for="" class="basic-detail-label">
            Date of Birth
          </label>
          <div class="basic-detail-info">
            <input type="date" name="user-birthdate" id="user-birthdate" autocomplete="off" spellcheck="false" value="<?= $_SESSION["CURRENT_SESSION_DATA"]["ACC_INF"]["Birthdate"] ?>">
          </div>
        </div>
        <div class="basic-detail">
          <label for="" class="basic-detail-label">
            Gender
          </label>
          <div class="basic-detail-info choices">
            <?php
            $statement = $connection->prepare("SELECT * FROM user_gender;");
            $statement->execute();
            $genders = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach ($genders as $gender) {
              if ($_SESSION["CURRENT_SESSION_DATA"]["ACC_INF"]["Gender"] === $gender["gender_id"]) {
                echo "
              <div class='choice'>
                <input type='radio' name='user-gender' id='user-{$gender['gender_name']}' value='{$gender['gender_id']}' checked>
                <label for='user-{$gender['gender_name']}' class='basic-detail-info'>{$gender['gender_name']}</label>
              </div>
              ";
              } else {
                echo "
              <div class='choice'>
                <input type='radio' name='user-gender' id='user-{$gender['gender_name']}' value='{$gender['gender_id']}'>
                <label for='user-{$gender['gender_name']}' class='basic-detail-info'>{$gender['gender_name']}</label>
              </div>
              ";
              }
            }
            ?>
          </div>
        </div>
      </div>
      <div class="details user-contact-details">
        <h1>Contact Detail</h1>
        <div class="contact-detail">
          <label for="" class="contact-detail-label">Mobile Number</label>
          <div class="contact-detail-info">
            <input type="tel" id="user-mobile-number" name="user-mobile-number" autocomplete="off" spellcheck="false" placeholder="Enter your mobile number (e.g. 09171234567)" value="<?= $_SESSION["CURRENT_SESSION_DATA"]["ACC_INF"]["Mobile_number"] ?>">
          </div>
        </div>
        <div class="contact-detail">
          <label for="" class="contact-detail-label">
            Email
          </label>
          <div class="contact-detail-info">
            <input type="email" name="user-email" id="user-email" autocomplete="off" spellcheck="false" placeholder="Enter your email address (e.g. you@example.com)" value="<?= $_SESSION["CURRENT_SESSION_DATA"]["ACC_INF"]["Email"] ?>">
          </div>
        </div>
      </div>
      <div class="details user-personal-details">
        <h1>
          Personal Detail
        </h1>
        <div class="personal-detail">
          <label for="" class="personal-detail-label">
            Weight (kg)
          </label>
          <div class="personal-detail-info">
            <input type="number" max='200' min='0' id="user-weight" name="user-weight" spellcheck="false" autocomplete="off" value="<?= $_SESSION["CURRENT_SESSION_DATA"]["ACC_INF"]["Weight"] ?>">
          </div>
        </div>
        <div class="personal-detail">
          <label for="" class="personal-detail-label">
            Height (cm)
          </label>
          <div class="personal-detail-info">
            <input type="number" max='200' min='0' id="user-height" name="user-height" spellcheck="false" autocomplete="off" value="<?= $_SESSION["CURRENT_SESSION_DATA"]["ACC_INF"]["Height"] ?>">
          </div>
        </div>
      </div>
    </section>

    <div class="action-btns">
      <button type="submit" id="save-btn">Save Changes</button>
      <a href="./../auth/logout_auth.php" id="logout-btn">
        Logout
      </a>
    </div>
  </form>
</body>

<script src="./../../assets/js/account.js"></script>

<script>
  document.getElementById("logout-btn").addEventListener("click", async function() {
    const send = {
      "LOGOUT_REQ": true
    };
    const req = await fetch("./../auth/logout_auth.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify(send),
    });
    const json = await req.json();
    console.log(json);
  });
</script>

</html>