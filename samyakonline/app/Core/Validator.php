<?php
/**
 * Input Validation Class
 * Provides comprehensive validation methods
 */

namespace App\Core;

class Validator
{
    private array $errors = [];
    private array $data = [];

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * Set data to validate
     */
    public function setData(array $data): self
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Validate required field
     */
    public function required(string $field, string $message = null): self
    {
        $value = $this->getValue($field);
        if ($value === null || $value === '' || $value === []) {
            $this->addError($field, $message ?? "{$field} is required");
        }
        return $this;
    }

    /**
     * Validate email
     */
    public function email(string $field, string $message = null): self
    {
        $value = $this->getValue($field);
        if ($value && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->addError($field, $message ?? "Invalid email address");
        }
        return $this;
    }

    /**
     * Validate minimum length
     */
    public function minLength(string $field, int $length, string $message = null): self
    {
        $value = $this->getValue($field);
        if ($value && strlen($value) < $length) {
            $this->addError($field, $message ?? "{$field} must be at least {$length} characters");
        }
        return $this;
    }

    /**
     * Validate maximum length
     */
    public function maxLength(string $field, int $length, string $message = null): self
    {
        $value = $this->getValue($field);
        if ($value && strlen($value) > $length) {
            $this->addError($field, $message ?? "{$field} must not exceed {$length} characters");
        }
        return $this;
    }

    /**
     * Validate exact length
     */
    public function length(string $field, int $length, string $message = null): self
    {
        $value = $this->getValue($field);
        if ($value && strlen($value) !== $length) {
            $this->addError($field, $message ?? "{$field} must be exactly {$length} characters");
        }
        return $this;
    }

    /**
     * Validate numeric
     */
    public function numeric(string $field, string $message = null): self
    {
        $value = $this->getValue($field);
        if ($value && !is_numeric($value)) {
            $this->addError($field, $message ?? "{$field} must be numeric");
        }
        return $this;
    }

    /**
     * Validate integer
     */
    public function integer(string $field, string $message = null): self
    {
        $value = $this->getValue($field);
        if ($value && filter_var($value, FILTER_VALIDATE_INT) === false) {
            $this->addError($field, $message ?? "{$field} must be an integer");
        }
        return $this;
    }

    /**
     * Validate minimum value
     */
    public function min(string $field, $min, string $message = null): self
    {
        $value = $this->getValue($field);
        if ($value !== null && $value < $min) {
            $this->addError($field, $message ?? "{$field} must be at least {$min}");
        }
        return $this;
    }

    /**
     * Validate maximum value
     */
    public function max(string $field, $max, string $message = null): self
    {
        $value = $this->getValue($field);
        if ($value !== null && $value > $max) {
            $this->addError($field, $message ?? "{$field} must not exceed {$max}");
        }
        return $this;
    }

    /**
     * Validate in array
     */
    public function in(string $field, array $values, string $message = null): self
    {
        $value = $this->getValue($field);
        if ($value && !in_array($value, $values, true)) {
            $this->addError($field, $message ?? "{$field} must be one of: " . implode(', ', $values));
        }
        return $this;
    }

    /**
     * Validate regex pattern
     */
    public function pattern(string $field, string $pattern, string $message = null): self
    {
        $value = $this->getValue($field);
        if ($value && !preg_match($pattern, $value)) {
            $this->addError($field, $message ?? "{$field} format is invalid");
        }
        return $this;
    }

    /**
     * Validate mobile number (Indian)
     */
    public function mobile(string $field, string $message = null): self
    {
        $value = $this->getValue($field);
        if ($value) {
            $cleaned = preg_replace('/[^0-9]/', '', $value);
            if (!preg_match('/^[6-9]\d{9}$/', $cleaned)) {
                $this->addError($field, $message ?? "Invalid mobile number");
            }
        }
        return $this;
    }

    /**
     * Validate password strength
     */
    public function password(string $field, string $message = null): self
    {
        $value = $this->getValue($field);
        if ($value) {
            if (strlen($value) < 8) {
                $this->addError($field, $message ?? "Password must be at least 8 characters");
            }
        }
        return $this;
    }

    /**
     * Validate date format
     */
    public function date(string $field, string $format = 'Y-m-d', string $message = null): self
    {
        $value = $this->getValue($field);
        if ($value) {
            $date = \DateTime::createFromFormat($format, $value);
            if (!$date || $date->format($format) !== $value) {
                $this->addError($field, $message ?? "Invalid date format");
            }
        }
        return $this;
    }

    /**
     * Validate age (must be 18+)
     */
    public function age(string $field, int $minAge = 18, string $message = null): self
    {
        $value = $this->getValue($field);
        if ($value) {
            $birthDate = new \DateTime($value);
            $today = new \DateTime();
            $age = $today->diff($birthDate)->y;
            if ($age < $minAge) {
                $this->addError($field, $message ?? "Must be at least {$minAge} years old");
            }
        }
        return $this;
    }

    /**
     * Validate unique in database
     */
    public function unique(string $field, string $table, string $column, $exceptId = null, string $message = null): self
    {
        $value = $this->getValue($field);
        if ($value) {
            $db = Database::getInstance();
            $query = "SELECT COUNT(*) as count FROM {$table} WHERE {$column} = ?";
            $params = [$value];

            if ($exceptId !== null) {
                $query .= " AND matri_id != ?";
                $params[] = $exceptId;
            }

            $result = $db->selectOne($query, $params);
            if ($result && $result['count'] > 0) {
                $this->addError($field, $message ?? "{$field} already exists");
            }
        }
        return $this;
    }

    /**
     * Custom validation callback
     */
    public function custom(string $field, callable $callback, string $message = null): self
    {
        $value = $this->getValue($field);
        if (!$callback($value, $this->data)) {
            $this->addError($field, $message ?? "{$field} is invalid");
        }
        return $this;
    }

    /**
     * Get field value from data
     */
    private function getValue(string $field)
    {
        return $this->data[$field] ?? null;
    }

    /**
     * Add error message
     */
    private function addError(string $field, string $message): void
    {
        if (!isset($this->errors[$field])) {
            $this->errors[$field] = [];
        }
        $this->errors[$field][] = $message;
    }

    /**
     * Check if validation passed
     */
    public function passes(): bool
    {
        return empty($this->errors);
    }

    /**
     * Check if validation failed
     */
    public function fails(): bool
    {
        return !$this->passes();
    }

    /**
     * Get all errors
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Get first error for a field
     */
    public function getFirstError(string $field): ?string
    {
        return $this->errors[$field][0] ?? null;
    }

    /**
     * Get all errors as flat array
     */
    public function getAllErrors(): array
    {
        $allErrors = [];
        foreach ($this->errors as $fieldErrors) {
            $allErrors = array_merge($allErrors, $fieldErrors);
        }
        return $allErrors;
    }

    /**
     * Clear all errors
     */
    public function clearErrors(): self
    {
        $this->errors = [];
        return $this;
    }
}
