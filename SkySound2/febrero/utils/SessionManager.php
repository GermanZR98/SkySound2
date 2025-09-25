<?php

require_once "config/Config.php";

/**
 * Enhanced session management with security features
 */
class SessionManager
{
    private static $instance = null;

    private function __construct()
    {
        $this->initSession();
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new SessionManager();
        }
        return self::$instance;
    }

    /**
     * Initialize secure session
     */
    private function initSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            // Set secure session parameters
            session_set_cookie_params([
                'lifetime' => 3600, // 1 hour
                'path' => '/',
                'domain' => '',
                'secure' => false, // Set to true for HTTPS
                'httponly' => true,
                'samesite' => 'Strict'
            ]);
            
            session_start();
            
            // Regenerate session ID on new session
            if (!isset($_SESSION['initiated'])) {
                session_regenerate_id(true);
                $_SESSION['initiated'] = true;
                $_SESSION['created'] = time();
            }
            
            // Check session timeout
            $this->checkSessionTimeout();
        }
    }

    /**
     * Check if session has expired
     */
    private function checkSessionTimeout()
    {
        $sessionTimeout = 3600; // 1 hour
        
        if (isset($_SESSION['created']) && (time() - $_SESSION['created'] > $sessionTimeout)) {
            $this->destroySession();
            return false;
        }
        
        // Update last activity time
        $_SESSION['last_activity'] = time();
        return true;
    }

    /**
     * Set session variable
     */
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Get session variable
     */
    public function get($key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Check if user is logged in
     */
    public function isLoggedIn()
    {
        return isset($_SESSION[Config::SESSION_NAME]);
    }

    /**
     * Get current username
     */
    public function getUsername()
    {
        return $this->get(Config::SESSION_NAME);
    }

    /**
     * Check if current user is admin
     */
    public function isAdmin()
    {
        if (!$this->isLoggedIn()) {
            return false;
        }
        return Config::isAdmin($this->getUsername());
    }

    /**
     * Login user
     */
    public function login($username)
    {
        session_regenerate_id(true);
        $this->set(Config::SESSION_NAME, $username);
        $this->set('login_time', time());
    }

    /**
     * Logout user
     */
    public function logout()
    {
        $this->destroySession();
    }

    /**
     * Destroy session completely
     */
    public function destroySession()
    {
        session_unset();
        session_destroy();
        
        // Clear session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
    }

    /**
     * Generate CSRF token
     */
    public function generateCSRFToken()
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    /**
     * Validate CSRF token
     */
    public function validateCSRFToken($token)
    {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }

    /**
     * Get CSRF token for forms
     */
    public function getCSRFToken()
    {
        return $this->generateCSRFToken();
    }
}