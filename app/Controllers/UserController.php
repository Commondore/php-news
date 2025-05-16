<?php

namespace App\Controllers;

use App\Config\View;
use App\Helpers\AuthApi;
use App\Models\User;
use App\Validators\RegisterValidator;
use Firebase\JWT\JWT;

class UserController
{
  private User $userModel;
  private RegisterValidator $registerValidator;

  public function __construct() {
    $this->userModel = new User();
    $this->registerValidator = new RegisterValidator();
  }

  public function index(): void
  {
    $users = $this->userModel->getAllUsers();
    View::render('users/index.twig', ['users' => $users]);
  }

  public function register(): void
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

  public function login(): void
  {
    if($_SERVER['REQUEST_METHOD'] === 'GET') {
      View::render('users/login.twig', [
        'errors' => []
      ]);
      return;
    }

    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    $user = $this->userModel->getUserByEmail($email);

    if(!$user) {
       View::render('users/login.twig', [
        'errors' => [
          "email" => 'Нет такого пользователя'
        ]
      ]);
       return;
    }

    $hashedPassword = $user['password'];
    if(!password_verify($password, $hashedPassword)) {
      View::render('users/login.twig', [
        'errors' => [
          "password" => 'Пароль не верный'
        ]
      ]);
      return;
    }

    $payload = [
      'id' => $user['id'],
      'email' => $user['email'],
      'name' => $user['name']
    ];

    $token = JWT::encode($payload, $_ENV['JWT_SECRET'], 'HS256');

    setcookie('token', $token, [
     "httponly" => true,
      "secure" => true,
      "samesite" => 'Lax',
      "path" => "/",
      "expires" => time() + 3600 * 24 * 30
    ]);
    header('Location: /');
  }

  public function getMeJSON()
  {
    header('Content-Type: application/json');
    $user = AuthApi::user();

    echo json_encode([
      "success" => true,
      "data" => $user
    ]);
  }
}