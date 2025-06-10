<?php

declare(strict_types=1);
session_name("login_signup_systemp");
session_start();

include_once __DIR__ . "/database/db.php";
include_once __DIR__ . "/auth/account_operations.php";