<?php

/**
 * Configuration class for SkySound2 application
 * Contains all application settings and constants
 */
class Config
{
    // Database configuration
    const DB_HOST = 'localhost';
    const DB_USER = 'root';
    const DB_PASS = '';
    const DB_NAME = 'skysound2';

    // Admin credentials
    const ADMIN_USERNAME = 'admin';
    const ADMIN_PASSWORD = 'admin';

    // Application settings
    const APP_NAME = 'SkySound2';
    const DEFAULT_MODULE = 'usuario';
    const DEFAULT_OPERATION = 'index';

    // Session configuration
    const SESSION_NAME = 'nombreusuario';

    // Error reporting settings
    const DISPLAY_ERRORS = true;
    const ERROR_REPORTING_LEVEL = E_ALL;

    /**
     * Initialize application configuration
     */
    public static function init()
    {
        if (self::DISPLAY_ERRORS) {
            ini_set("display_errors", 1);
            ini_set("display_startup_errors", 1);
            error_reporting(self::ERROR_REPORTING_LEVEL);
        }
    }

    /**
     * Get database configuration as array
     */
    public static function getDatabaseConfig()
    {
        return [
            'host' => self::DB_HOST,
            'user' => self::DB_USER,
            'pass' => self::DB_PASS,
            'name' => self::DB_NAME
        ];
    }

    /**
     * Check if user is admin
     */
    public static function isAdmin($username)
    {
        return $username === self::ADMIN_USERNAME;
    }
}