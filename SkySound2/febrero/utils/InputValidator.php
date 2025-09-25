<?php

/**
 * Input validation and sanitization utilities
 */
class InputValidator
{
    /**
     * Sanitize string input
     */
    public static function sanitizeString($input)
    {
        return filter_var($input, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
    }

    /**
     * Validate email
     */
    public static function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Validate string length
     */
    public static function validateLength($input, $min, $max = null)
    {
        $length = strlen(trim($input));
        if ($length < $min) {
            return false;
        }
        if ($max !== null && $length > $max) {
            return false;
        }
        return true;
    }

    /**
     * Validate required field
     */
    public static function validateRequired($input)
    {
        return !empty(trim($input));
    }

    /**
     * Validate numeric ID
     */
    public static function validateId($id)
    {
        return filter_var($id, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) !== false;
    }

    /**
     * Clean and validate GET parameter
     */
    public static function getCleanParam($key, $default = null)
    {
        if (!isset($_GET[$key])) {
            return $default;
        }
        return self::sanitizeString($_GET[$key]);
    }

    /**
     * Get and validate required parameter
     */
    public static function getRequiredParam($key)
    {
        $value = self::getCleanParam($key);
        if (!self::validateRequired($value)) {
            throw new InvalidArgumentException("Required parameter '$key' is missing or empty");
        }
        return $value;
    }
}