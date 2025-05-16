<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthApi
{
  private static ?string $secret = null;

  private static function getSecret(): string
  {
    if(self::$secret === null) {
      self::$secret = $_ENV['JWT_SECRET'];
    }
    return self::$secret;
  }

  public static function user(): ?array
  {
    if (!isset($_COOKIE['token'])) return null;

    try {
      $decode = JWT::decode($_COOKIE['token'], new Key(self::getSecret(), 'HS256'));
      return (array) $decode;
    }
    catch (\Exception $e)
    {
      return null;
    }
  }

  public static function check(): bool
  {
    return self::user() !== null;
  }
}