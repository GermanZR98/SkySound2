<?php

require_once "config/Config.php";
require_once "utils/InputValidator.php";
require_once "utils/ErrorHandler.php";

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
        return InputValidator::getCleanParam($key, $default);
    }

    /**
     * Get required parameter or throw error
     */
    protected function getRequiredParameter($key)
    {
        try {
            return InputValidator::getRequiredParam($key);
        } catch (InvalidArgumentException $e) {
            $this->redirectWithError($e->getMessage());
        }
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
        ErrorHandler::logError($error, ['user' => $this->getCurrentUsername(), 'url' => $_SERVER['REQUEST_URI'] ?? '']);
        ErrorHandler::showErrorPage($error, 400);
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

    /**
     * Validate string with minimum length
     */
    protected function validateMinLength($value, $min, $fieldName)
    {
        if (!InputValidator::validateLength($value, $min)) {
            $this->redirectWithError("$fieldName debe tener al menos $min caracteres");
        }
    }

    /**
     * Validate email
     */
    protected function validateEmail($email, $fieldName = "Email")
    {
        if (!InputValidator::validateEmail($email)) {
            $this->redirectWithError("$fieldName inválido");
        }
    }

    /**
     * Validate numeric ID
     */
    protected function validateId($id, $fieldName = "ID")
    {
        if (!InputValidator::validateId($id)) {
            $this->redirectWithError("$fieldName inválido");
        }
        return intval($id);
    }
}