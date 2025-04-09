<?php

namespace App\Config;

use App\Helpers\Flash;
use App\Helpers\FormHelper;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

class View
{
  private static ?Environment $twig = null;

  /**
   * @throws SyntaxError
   * @throws RuntimeError
   * @throws LoaderError
   */
  public static function render(string $template, array $data = []): void
  {
    if (self::$twig === null) {
      $loader = new FilesystemLoader(__DIR__ . "/../Views");
      self::$twig = new Environment($loader, [
        "debug" => true,
      ]);

      self::$twig->addExtension(new DebugExtension());

      self::$twig->addFunction(new TwigFunction('flash', fn ($type) => Flash::get($type)));
      self::$twig->addFunction(new TwigFunction('flash_peek', fn ($key) => Flash::peek($key)));

      self::$twig->addFunction(new TwigFunction('old', fn($field, $default = '') => FormHelper::old($field, $default)));
      self::$twig->addFunction(new TwigFunction('error', fn($field) => FormHelper::error($field)));
      self::$twig->addFunction(new TwigFunction('hasError', fn($field) => FormHelper::hasError($field)));
      self::$twig->addFunction(new TwigFunction('errorClass', fn ($field, $class = 'is-invalid') => FormHelper::errorClass($field, $class)));

      self::$twig->addFunction(new TwigFunction('checked', fn($field, $value) => FormHelper::checked($field, $value)));
      self::$twig->addFunction(new TwigFunction('selected', fn($field, $value) => FormHelper::selected($field, $value)));
      self::$twig->addFunction(new TwigFunction('textarea', fn($field, $default = '') => FormHelper::textarea($field, $default)));
    }

    echo self::$twig->render($template, $data);
  }
}