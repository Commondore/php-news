<?php

namespace App\Controllers;

use App\Config\View;
use App\Models\User;

class UserController
{
  private User $userModel;

  public function __construct() {
    $this->userModel = new User();
  }

  public function index()
  {
    $users = $this->userModel->getAllUsers();
    View::render('users/index.twig', ['users' => $users]);
  }

  public function register()
  {
    $name = $_POST['name'] ?? null;
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    View::render('users/register.twig', ['user' => [
      'name' => $name,
      'email' => $email,
    ]]);
  }
}