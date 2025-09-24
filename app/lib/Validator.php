<?php

namespace App\Lib;

class Validator
{
    private array $errors = [];

    public function require(string $field, $value, string $message): void
    {
        if ($value === null || $value === '') {
            $this->errors[$field][] = $message;
        }
    }

    public function email(string $field, ?string $value, string $message): void
    {
        if ($value && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field][] = $message;
        }
    }

    public function maxLength(string $field, ?string $value, int $length, string $message): void
    {
        if ($value !== null && mb_strlen($value) > $length) {
            $this->errors[$field][] = $message;
        }
    }

    public function numeric(string $field, $value, string $message): void
    {
        if ($value !== null && $value !== '' && !is_numeric($value)) {
            $this->errors[$field][] = $message;
        }
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function passes(): bool
    {
        return empty($this->errors);
    }
}
