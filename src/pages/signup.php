<?php

require __DIR__ . "/../bootstrap.php";

if (isAlreadyLoggedIn()) header("Location: ./account.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./../../assets/css/variable.css">
  <link rel="stylesheet" href="./../../assets/css/login_signup.css">
  <title>Signup Page</title>
</head>

<body>
  <form action="./../auth/signup_auth.php" method="POST">
    <div class="introduction">
      <h1>Welcome User!</h1>
      <h4>Create an account and join us on a new journey!</h4>
    </div>
    <div class="input-wrapper">
      <input type="text" name="signup-username" id="signup-username" placeholder="Username" autocomplete="off">
      <div class="input-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user">
          <path stroke="none" d="M0 0h24v24H0z" fill="none" />
          <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
          <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
        </svg>
      </div>
    </div>
    <div class="input-wrapper">
      <input type="password" name="signup-create-password" id="signup-create-password" placeholder="Create Password" autocomplete="off">
      <div class="input-icon">
        <div class="password-switch">
          <div class="eye eye-open" id="eye-open">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
              <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
            </svg>
          </div>
          <div class="eye eye-close hidden" id="eye-close">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye-closed">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M21 9c-2.4 2.667 -5.4 4 -9 4c-3.6 0 -6.6 -1.333 -9 -4" />
              <path d="M3 15l2.5 -3.8" />
              <path d="M21 14.976l-2.492 -3.776" />
              <path d="M9 17l.5 -4" />
              <path d="M15 17l-.5 -4" />
            </svg>
          </div>
        </div>
      </div>
    </div>
    <div class="input-wrapper">
      <input type="password" name="signup-confirm-password" id="signup-confirm-password" placeholder="Confirm Password" autocomplete="off">
      <div class="input-icon">
        <div class="password-switch">
          <div class="eye-open" id="eye-open">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
              <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
            </svg>
          </div>
          <div class="eye-close hidden" id="eye-close">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye-closed">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M21 9c-2.4 2.667 -5.4 4 -9 4c-3.6 0 -6.6 -1.333 -9 -4" />
              <path d="M3 15l2.5 -3.8" />
              <path d="M21 14.976l-2.492 -3.776" />
              <path d="M9 17l.5 -4" />
              <path d="M15 17l-.5 -4" />
            </svg>
          </div>
        </div>
      </div>
    </div>
    <button type="submit">
      Create Account
    </button>
    <p class="last-option">
      Already have an account? 
      <a href="./login.php">Login</a>
    </p>
  </form>
</body>
<script src="./../../assets/js/signup.js"></script>
</html>