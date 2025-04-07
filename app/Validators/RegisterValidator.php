<?php

namespace App\Validators;

class RegisterValidator implements ValidatorInterface {

  private array $errors = [];

  public function validate(array $data): array
  {
    $this->validateName($data['name']);
    $this->validateEmail($data['email']);
    $this->validatePassword($data['password']);

    return $this->errors;
  }

  public function getErrors(): array
  {
    return $this->errors;
  }

  public function getError(string $field): string
  {
    return $this->errors[$field] ?? '';
  }

  private function validateName(?string $name): void
  {
    if(empty($name)) {
      $this->errors['name'] = 'Имя пользователя обязательно';
    }
  }

  private function validateEmail(?string $email): void
  {
    if(empty($email)){
      $this->errors['email'] = 'Email обязательный';
      return;
    }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
      $this->errors['email'] = 'Некорректный email';
      return;
    }
  }

  private function validatePassword(?string $password): void
  {
    if(empty($password)){
      $this->errors['password'] = 'Пароль обязательный';
      return;
    }
    if(strlen($password) < 8){
      $this->errors['password'] = 'Пароль должен быть не менее 8 символов';
      return;
    }

    if(!preg_match('/[0-9]/', $password)) {
      $this->errors['password'] = 'Пароль должен содержать хотя бы одну цифру';
    }

    if(!preg_match('/[A-Z]/', $password)) {
      $this->errors['password'] = 'Пароль должен содержать хотя бы одну заглавную букву';
    }


  }

}