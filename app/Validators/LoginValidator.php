<?php

namespace App\Validators;

class LoginValidator extends Validator
{
  public function validate(array $data): array
  {
    $this->validateEmail($data['email']);
    $this->validatePassword($data['password']);
    return $this->errors;
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
      $this->errors['password'] = 'Укажите пароль';
      return;
    }
  }
}