<?php

namespace App\Validators;

class Validator implements ValidatorInterface
{
  protected array $errors = [];

  public function validate(array $data): array
  {
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
}