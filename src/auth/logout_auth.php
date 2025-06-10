<?php

declare(strict_types=1);

require_once __DIR__ . "/../bootstrap.php";

logout(function () {
  header("Location: ./../pages/login.php");
  die();
});
