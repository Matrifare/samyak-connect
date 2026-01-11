<?php
/**
 * Validator Class
 * Provides input validation with fluent interface
 */

namespace App\Core;

class Validator
{
    protected array $data;
    protected array $errors = [];
    protected array $customMessages = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function required(string $field, ?string $message = null): self
    {
        if (!isset($this->data[$field]) || trim($this->data[$field]) === '') {
            $this->addError($field, $message ?? "{$field} is required");
        }
        return $this;
    }

    public function email(string $field, ?string $message = null): self
    {
        if (!empty($this->data[$field]) && !filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
            $this->addError($field, $message ?? "Invalid email address");
        }
        return $this;
    }

    public function mobile(string $field, ?string $message = null): self
    {
        if (!empty($this->data[$field])) {
            $mobile = preg_replace('/[^0-9]/', '', $this->data[$field]);
            if (strlen($mobile) !== 10) {
                $this->addError($field, $message ?? "Invalid mobile number");
            }
        }
        return $this;
    }

    public function minLength(string $field, int $min, ?string $message = null): self
    {
        if (!empty($this->data[$field]) && strlen($this->data[$field]) < $min) {
            $this->addError($field, $message ?? "{$field} must be at least {$min} characters");
        }
        return $this;
    }

    public function maxLength(string $field, int $max, ?string $message = null): self
    {
        if (!empty($this->data[$field]) && strlen($this->data[$field]) > $max) {
            $this->addError($field, $message ?? "{$field} must not exceed {$max} characters");
        }
        return $this;
    }

    public function numeric(string $field, ?string $message = null): self
    {
        if (!empty($this->data[$field]) && !is_numeric($this->data[$field])) {
            $this->addError($field, $message ?? "{$field} must be a number");
        }
        return $this;
    }

    public function in(string $field, array $values, ?string $message = null): self
    {
        if (!empty($this->data[$field]) && !in_array($this->data[$field], $values)) {
            $this->addError($field, $message ?? "Invalid {$field} value");
        }
        return $this;
    }

    public function date(string $field, string $format = 'Y-m-d', ?string $message = null): self
    {
        if (!empty($this->data[$field])) {
            $d = \DateTime::createFromFormat($format, $this->data[$field]);
            if (!$d || $d->format($format) !== $this->data[$field]) {
                $this->addError($field, $message ?? "Invalid date format");
            }
        }
        return $this;
    }

    public function custom(string $field, callable $callback, ?string $message = null): self
    {
        if (!$callback($this->data[$field] ?? null, $this->data)) {
            $this->addError($field, $message ?? "{$field} is invalid");
        }
        return $this;
    }

    public function match(string $field, string $otherField, ?string $message = null): self
    {
        if (($this->data[$field] ?? '') !== ($this->data[$otherField] ?? '')) {
            $this->addError($field, $message ?? "{$field} does not match {$otherField}");
        }
        return $this;
    }

    protected function addError(string $field, string $message): void
    {
        $this->errors[$field][] = $message;
    }

    public function fails(): bool
    {
        return !empty($this->errors);
    }

    public function passes(): bool
    {
        return empty($this->errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getAllErrors(): array
    {
        $all = [];
        foreach ($this->errors as $fieldErrors) {
            $all = array_merge($all, $fieldErrors);
        }
        return $all;
    }

    public function getFirstError(string $field): ?string
    {
        return $this->errors[$field][0] ?? null;
    }
}
