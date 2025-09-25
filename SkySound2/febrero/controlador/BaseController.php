<?php

require_once "config/Config.php";
require_once "config/AppConstants.php";
require_once "utils/InputValidator.php";
require_once "utils/ErrorHandler.php";
require_once "utils/SessionManager.php";

/**
 * Base controller class
 * Provides common functionality for all controllers
 */
abstract class BaseController
{
    protected $sessionManager;

    public function __construct()
    {
        $this->sessionManager = SessionManager::getInstance();
    }
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
        return $this->sessionManager->isLoggedIn();
    }

    /**
     * Check if current user is admin
     */
    protected function isCurrentUserAdmin()
    {
        return $this->sessionManager->isAdmin();
    }

    /**
     * Get current username
     */
    protected function getCurrentUsername()
    {
        return $this->sessionManager->getUsername();
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
        // Session is already managed by SessionManager in constructor
    }

    /**
     * Validate CSRF token for forms
     */
    protected function validateCSRF()
    {
        $token = $this->getParameter('csrf_token');
        if (!$this->sessionManager->validateCSRFToken($token)) {
            $this->redirectWithError(AppConstants::getMessage('CSRF_TOKEN_INVALID'));
        }
    }

    /**
     * Get CSRF token for forms
     */
    protected function getCSRFToken()
    {
        return $this->sessionManager->getCSRFToken();
    }

    /**
     * Validate string with minimum length
     */
    protected function validateMinLength($value, $min, $fieldName)
    {
        if (!InputValidator::validateLength($value, $min)) {
            $message = AppConstants::getMessage('FIELD_TOO_SHORT', ['field' => $fieldName, 'min' => $min]);
            $this->redirectWithError($message);
        }
    }

    /**
     * Validate email
     */
    protected function validateEmail($email, $fieldName = null)
    {
        if (!InputValidator::validateEmail($email)) {
            $this->redirectWithError(AppConstants::getMessage('EMAIL_INVALID'));
        }
    }

    /**
     * Validate numeric ID
     */
    protected function validateId($id, $fieldName = "ID")
    {
        if (!InputValidator::validateId($id)) {
            $message = AppConstants::getMessage('ID_INVALID', ['field' => $fieldName]);
            $this->redirectWithError($message);
        }
        return intval($id);
    }
}