<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class AuthApi
{
    private static string $secret;

    // Статический инициализатор
    public static function init(): void
    {
        self::$secret = $_ENV['JWT_SECRET'];
    }

    public static function user(): ?array
    {
        if (!isset($_COOKIE['token'])) return null;

        try {
            self::init();

            $decoded = JWT::decode($_COOKIE['token'], new Key(self::$secret, 'HS256'));
            return (array)$decoded;
        } catch (Exception $e) {
            return null;
        }
    }

    public static function check(): bool
    {
        return self::user() !== null;
    }
}

