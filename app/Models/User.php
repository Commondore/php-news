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

  public function getAllUsers()
  {
    $stmt = $this->db->query("SELECT * FROM users");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}