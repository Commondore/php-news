<?php

namespace App\Config;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class View {
  private static ?Environment $twig = null;

  public static function render(string $template, array $data = [])
  {
    if(self::$twig == null) {
      $loader = new FilesystemLoader(__DIR__ . "/../Views");
      self::$twig = new Environment($loader);
    }

    echo self::$twig->render($template, $data);
  }
}