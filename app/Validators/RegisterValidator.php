<?php
namespace App\Validators;

class RegisterValidator implements ValidatorInterface
{
    private array $errors = [];

    public function validate(array $data): array
    {
        $this->validateEmail($data['email'] ?? null);
        $this->validatePassword($data['password'] ?? null);
        return $this->errors;
    }

    private function validateEmail(?string $email): void
    {
        if (empty($email)) {
            $this->errors['email'] = 'Email обязателен';
            return;
        }

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'Неверный формат email';
        }
    }

    public function validatePassword(?string $password): void
    {
        if (empty($password)) {
            $this->errors['password'] = 'Пароль обязателен';
            return;
        }
        if (strlen($password) < 8) {
            $this->errors['password'] = 'Пароль должен содержать не менее 8 символов';
            return;
        }

        if (! preg_match('/[0-9]/', $password)) {
            $this->errors['password'] = 'Пароль должен содержать хотя бы одну цифру';
            return;
        }

        if (! preg_match('/[A-Z]/', $password)) {
            $this->errors['password'] = 'Пароль должен содержать хотя бы одну заглавную букву';
            return;
        }
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getError(string $field): string
    {
        return $this->errors[$field] ?? '';
    }
}
