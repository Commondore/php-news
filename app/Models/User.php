<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class User
{
  private PDO $db;

  public function __construct()
  {
    $this->db = Database::connect();
  }

  public function getAllUsers(): array
  {
    $stmt = $this->db->query("SELECT * FROM users");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function createUser($name, $email, $password)
  {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = 'INSERT INTO users (name, email, password) VALUES (:name, :email, :password)';
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([
      ':name' => $name,
      ':email' => $email,
      ':password' => $hashedPassword
    ]);
  }
}