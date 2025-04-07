<?php

namespace App\Validators;

interface ValidatorInterface
{
  public function validate(array $data): array;
  public function getErrors(): array;
  public function getError(string $field): string;
}