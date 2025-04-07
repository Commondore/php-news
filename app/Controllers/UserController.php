<?php

namespace App\Controllers;

use App\Config\View;
use App\Models\User;
use App\Validators\RegisterValidator;

class UserController
{
  private User $userModel;
  private RegisterValidator $registerValidator;

  public function __construct() {
    $this->userModel = new User();
    $this->registerValidator = new RegisterValidator();
  }

  public function index()
  {
    $users = $this->userModel->getAllUsers();
    View::render('users/index.twig', ['users' => $users]);
  }

  public function register()
  {
    if($_SERVER['REQUEST_METHOD'] === 'GET') {
      View::render('users/register.twig', [
        'name' => '',
        'email' => '',
        'errors' => []
      ]);
      return;
    }

    $name = $_POST['name'] ?? null;
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;


    $errors = $this->registerValidator->validate($_POST);

    if(empty($errors)) {
      $user = $this->userModel->createUser($name, $email, $password);
      if($user) {
        header('Location: /news.kg/login');
      }
    }


    View::render('users/register.twig', [
      'name' => $name ?? '',
      'email' => $email ?? '',
      'errors' => $errors
    ]);
  }
}