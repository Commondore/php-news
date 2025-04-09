<?php

namespace App\Helpers;

class Auth
{
  public static function check(): bool
  {
    return isset($_SESSION['user']);
  }

  public static function user(): ?object
  {
    return $_SESSION['user'] ?? null;
  }

  public static function login(array $user): void
  {
    $_SESSION['user'] = $user;
  }

  public static function logout(): void
  {
    unset($_SESSION['user']);
    session_destroy();
  }
}