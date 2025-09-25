<?php

/**
 * Error handling and logging utilities
 */
class ErrorHandler
{
    /**
     * Log error to file
     */
    public static function logError($message, $context = [])
    {
        $timestamp = date('Y-m-d H:i:s');
        $contextStr = !empty($context) ? ' - Context: ' . json_encode($context) : '';
        $logMessage = "[$timestamp] ERROR: $message$contextStr" . PHP_EOL;
        
        // Create logs directory if it doesn't exist
        $logDir = dirname(__DIR__) . '/logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }
        
        error_log($logMessage, 3, $logDir . '/app.log');
    }

    /**
     * Handle database errors
     */
    public static function handleDatabaseError($operation, $error = null)
    {
        $message = "Database operation failed: $operation";
        if ($error) {
            $message .= " - Error: $error";
        }
        
        self::logError($message);
        return false;
    }

    /**
     * Handle validation errors
     */
    public static function handleValidationError($field, $rule, $value = null)
    {
        $message = "Validation failed for field '$field' with rule '$rule'";
        if ($value !== null) {
            $message .= " - Value: $value";
        }
        
        self::logError($message);
        return "Error de validación: $field no cumple con los requisitos";
    }

    /**
     * Display user-friendly error page
     */
    public static function showErrorPage($message, $code = 500)
    {
        http_response_code($code);
        
        echo "<!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Error - SkySound2</title>
            <style>
                body { font-family: Arial, sans-serif; text-align: center; margin-top: 50px; }
                .error-container { max-width: 500px; margin: 0 auto; }
                .error-code { font-size: 4em; color: #ff6b6b; }
                .error-message { font-size: 1.2em; color: #666; margin: 20px 0; }
                .back-link { display: inline-block; margin-top: 20px; padding: 10px 20px; 
                           background: #007bff; color: white; text-decoration: none; border-radius: 5px; }
                .back-link:hover { background: #0056b3; }
            </style>
        </head>
        <body>
            <div class='error-container'>
                <div class='error-code'>$code</div>
                <div class='error-message'>" . htmlspecialchars($message) . "</div>
                <a href='index.php' class='back-link'>Volver al inicio</a>
            </div>
        </body>
        </html>";
        exit;
    }
}