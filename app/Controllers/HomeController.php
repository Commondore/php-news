<?php

namespace App\Controllers;

use App\Config\View;

class HomeController
{
  public function index()
  {
    View::render('index.twig', ['title' => 'Главная страница']);
  }
}