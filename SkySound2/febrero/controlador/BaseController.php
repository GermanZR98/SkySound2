<?php

require_once "config/Config.php";

/**
 * Base controller class
 * Provides common functionality for all controllers
 */
abstract class BaseController
{
    /**
     * Validate and sanitize GET parameters
     */
    protected function getParameter($key, $default = null)
    {
        if (!isset($_GET[$key])) {
            return $default;
        }
        
        return filter_var($_GET[$key], FILTER_SANITIZE_STRING);
    }

    /**
     * Get required parameter or throw error
     */
    protected function getRequiredParameter($key)
    {
        $value = $this->getParameter($key);
        if ($value === null || $value === '') {
            $this->redirectWithError("Missing required parameter: $key");
        }
        return $value;
    }

    /**
     * Redirect to a specific location
     */
    protected function redirect($location)
    {
        header("Location: $location");
        exit;
    }

    /**
     * Redirect with error message
     */
    protected function redirectWithError($error)
    {
        // For now, just die with error - could be enhanced to show error pages
        die("Error: " . htmlspecialchars($error));
    }

    /**
     * Check if user is logged in
     */
    protected function requireLogin()
    {
        if (!$this->isLoggedIn()) {
            $this->redirect("index.php");
        }
    }

    /**
     * Check if user is logged in
     */
    protected function isLoggedIn()
    {
        return isset($_SESSION[Config::SESSION_NAME]);
    }

    /**
     * Check if current user is admin
     */
    protected function isCurrentUserAdmin()
    {
        if (!$this->isLoggedIn()) {
            return false;
        }
        return Config::isAdmin($_SESSION[Config::SESSION_NAME]);
    }

    /**
     * Get current username
     */
    protected function getCurrentUsername()
    {
        return $_SESSION[Config::SESSION_NAME] ?? null;
    }

    /**
     * Require view file
     */
    protected function loadView($viewFile, $data = [])
    {
        // Extract data variables for use in view
        extract($data);
        require_once "vista/$viewFile";
    }

    /**
     * Start session if not already started
     */
    protected function initSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
}