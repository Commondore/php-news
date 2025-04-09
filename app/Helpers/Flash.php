<?php

namespace App\Helpers;

class Flash
{
  public static function init(): void
  {
    if (!isset($_SESSION['flash'])) {
      $_SESSION['flash'] = [];
    }

    $_SESSION['flash']['__next__'] = $_SESSION['flash']['__current__'] ?? [];
    $_SESSION['flash']['__current__'] = [];
  }

  public static function set(string $key, mixed $value): void
  {
    $_SESSION['flash']['__current__'][$key] = $value;
  }

  public static function get(string $key): mixed
  {
    return $_SESSION['flash']['__next__'][$key] ?? null;
  }

  public static function peek(string $key): mixed
  {
    return $_SESSION['flash']['__next__'][$key] ?? null;
  }

  public static function old(string $field): mixed
  {
    return $_SESSION['flash']['__next__']['old'][$field] ?? null;
  }

  public static function setOld(array $data): void
  {
    self::set('old', $data);
  }
}

