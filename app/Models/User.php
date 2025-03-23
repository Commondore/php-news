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

    public function createUser(string $name, string $email): bool
    {
        $stmt = $this->db->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");
        return $stmt->execute(['name' => $name, 'email' => $email]);
    }

    public function updateUser(int $id, string $name, string $email): bool
    {
        $stmt = $this->db->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id");
        return $stmt->execute(['id' => $id, 'name' => $name, 'email' => $email]);
    }

    public function deleteUser(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
