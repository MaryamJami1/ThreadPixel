<?php
/**
 * ThreadPixel - Input Validator
 */

class Validator {
    private $errors = [];

    public function required($field, $value, $label = null) {
        $label = $label ?? ucfirst($field);
        if (empty(trim($value))) {
            $this->errors[$field] = "{$label} is required.";
        }
        return $this;
    }

    public function email($field, $value) {
        if (!empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = "Please enter a valid email address.";
        }
        return $this;
    }

    public function minLength($field, $value, $min, $label = null) {
        $label = $label ?? ucfirst($field);
        if (!empty($value) && strlen($value) < $min) {
            $this->errors[$field] = "{$label} must be at least {$min} characters.";
        }
        return $this;
    }

    public function maxLength($field, $value, $max, $label = null) {
        $label = $label ?? ucfirst($field);
        if (!empty($value) && strlen($value) > $max) {
            $this->errors[$field] = "{$label} must be no more than {$max} characters.";
        }
        return $this;
    }

    public function match($field, $value1, $value2, $label = 'Passwords') {
        if ($value1 !== $value2) {
            $this->errors[$field] = "{$label} do not match.";
        }
        return $this;
    }

    public function hasErrors() {
        return !empty($this->errors);
    }

    public function errors() {
        return $this->errors;
    }

    public function firstError() {
        return reset($this->errors);
    }

    public static function sanitize($value) {
        return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
    }
}
