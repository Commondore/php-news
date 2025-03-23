<?php

namespace App\Config;

use PDO;
use PDOException;

class Database
{
  private static ?PDO $instance = null;

  public static function connect(): PDO
  {
    if(self::$instance === null) {
      try {
        self::$instance = new PDO("mysql:host=localhost;dbname=blog", "root", "");
        self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
        die("Подлкючение к базе данных - ошибка: " . $e->getMessage());
      }
    }
    return self::$instance;
  }
}