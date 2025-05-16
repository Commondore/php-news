<?php

namespace App\Controllers;

use App\Config\View;
use App\Helpers\Auth;
use App\Helpers\AuthApi;
use App\Helpers\Flash;
use App\Models\User;
use App\Validators\LoginValidator;
use App\Validators\RegisterValidator;
use Firebase\JWT\JWT;
use JetBrains\PhpStorm\NoReturn;

class UserController
{
  private User $userModel;
  private RegisterValidator $registerValidator;
  private LoginValidator $loginValidator;

  public function __construct()
  {
    $this->userModel = new User();
    $this->registerValidator = new RegisterValidator();
    $this->loginValidator = new LoginValidator();
  }

  public function index(): void
  {
    $users = $this->userModel->getAllUsers();
    View::render('users/index.twig', ['users' => $users]);
  }

  public function register(): void
  {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      View::render('users/register.twig');
      return;
    }


    $errors = $this->registerValidator->validate($_POST);

    if (empty($errors)) {
      $name = $_POST['name'] ?? null;
      $email = $_POST['email'] ?? null;
      $password = $_POST['password'] ?? null;

      $user = $this->userModel->createUser($name, $email, $password);
      if ($user) {
        header('Location: /news.kg/login');
      }
    } else {
      Flash::set('error', 'Ошибка Регистрации');
      Flash::set('errors', $errors);
      Flash::setOld($_POST);
      header('Location: /register');
      exit;
    }


    View::render('users/register.twig');
  }

  public function login(): void
  {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      View::render('users/login.twig');
      return;
    }

    $errors = $this->loginValidator->validate($_POST);

    if (!empty($errors)) {
      Flash::set('error', 'Ошибка авторизации');
      Flash::set('errors', $errors);
      Flash::setOld($_POST);
      header('Location: /login');
      exit;
    }

    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    $user = $this->userModel->getUser($email);

    if (!$user || !password_verify($password, $user['password'])) {
      Flash::set('error', 'Неверный логин или пароль');
      Flash::set('old', $_POST);
      header('Location: /login');
      exit;
    }

    $payload = [
      'id' => $user['id'],
      'email' => $user['email'],
      'name' => $user['name'],
      'exp' => time() + 3600,
    ];

    $jwt = JWT::encode($payload, $_ENV['JWT_SECRET'], 'HS256');

    setcookie('token', $jwt, [
      'httponly' => true,
      'secure' => true,
      'samesite' => 'Lax',
      'path' => '/',
    ]);

    Flash::set('success', 'Добро пожаловать, ' . $user['name']);
    header('Location: /');
    exit;
  }

  #[NoReturn] public function logout(): void
  {
    Auth::logout();

    Flash::set('success', 'Вы вышли из системы');
    header('Location: /login');
    exit;
  }

  public function me(): void
  {
    header('Content-Type: application/json');
    $user = AuthApi::user();

    echo json_encode([
      'success' => true,
      'data' => [
        'id' => $user['id'],
        'email' => $user['email'],
        'name' => $user['name'],
      ]
    ]);
  }
}