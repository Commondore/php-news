<?php

namespace App\Helpers;

class FormHelper
{
    public static function old(string $field, $default = ''): mixed
    {
        return Flash::peek('old')[$field] ?? $default;
    }

    public static function error(string $field): string
    {
        return Flash::peek('errors')[$field] ?? '';
    }

    public static function hasError(string $field): bool
    {
        return isset(Flash::peek('errors')[$field]);
    }

    public static function errorClass(string $field, string $class = 'is-invalid'): string
    {
        return self::hasError($field) ? $class : '';
    }

    public static function checked(string $field, string|int|bool $value): string
    {
        return self::old($field) == $value ? 'checked' : '';
    }

    public static function selected(string $field, string|int $value): string
    {
        return self::old($field) == $value ? 'selected' : '';
    }

    public static function textarea(string $field, string $default = ''): string
    {
        return htmlspecialchars(self::old($field, $default));
    }
}
