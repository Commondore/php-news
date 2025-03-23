<?php
namespace App\Controllers;

use App\Config\View;
use App\Models\User;
use App\Validators\RegisterValidator;

class UserController
{
    private User $userModel;
    private RegisterValidator $registerValidator;

    public function __construct()
    {
        $this->userModel         = new User();
        $this->registerValidator = new RegisterValidator();
    }

    public function index()
    {
        $users = $this->userModel->getAllUsers();
        View::render('users/index.twig', ['users' => $users]);
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            View::render('users/register.twig', [
                'email'  => '',
                'errors' => [],
            ]);
            return;
        }

        $errors = $this->registerValidator->validate($_POST);
        if (empty($errors)) {
            $this->userModel->createUser($_POST['name'], $_POST['email']);
            header('Location: /news.kg/users');
            exit;
        }

        View::render('users/register.twig', [
            'email'  => $_POST['email'] ?? '',
            'errors' => $errors,
        ]);
    }
}
