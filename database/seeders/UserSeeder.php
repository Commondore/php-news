<?php

use App\Models\User;

require_once __DIR__ . '/../../vendor/autoload.php';

$userModel = new User();

$userModel->createUser("Admin", "admin@example.com", "password123");
$userModel->createUser("John", "john@example.com", "secret456");
