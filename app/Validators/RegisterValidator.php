<?php

namespace App\Validators;

class RegisterValidator implements ValidatorInterface {

  private array $errors = [];

  public function validate(array $data): array
  {
  }

  public function getErrors(): array
  {}

  public function getError(string $field): string
  {}

  private function validateEmail(?string $email)
  {
    if(empty($email)){
      $this->errors[] = 'Email обязательный';
      return;
    }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
      $this->errors[] = 'Некорректный email';
      return;
    }
  }

}