<?php

/**
 * Simple autoloader for SkySound2 application
 */
class Autoloader
{
    private static $directories = [
        'config',
        'controlador',
        'modelo',
        'utils',
        'vista'
    ];

    /**
     * Register the autoloader
     */
    public static function register()
    {
        spl_autoload_register([__CLASS__, 'loadClass']);
    }

    /**
     * Load class file
     */
    public static function loadClass($className)
    {
        $baseDir = dirname(__DIR__);
        
        foreach (self::$directories as $dir) {
            $file = $baseDir . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . $className . '.php';
            if (file_exists($file)) {
                require_once $file;
                return true;
            }
        }

        // Try with different naming conventions
        $variations = [
            $className . '.controller.php',
            strtolower($className) . '.php',
            ucfirst(strtolower($className)) . '.php'
        ];

        foreach (self::$directories as $dir) {
            foreach ($variations as $variation) {
                $file = $baseDir . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . $variation;
                if (file_exists($file)) {
                    require_once $file;
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Add directory to search path
     */
    public static function addDirectory($directory)
    {
        if (!in_array($directory, self::$directories)) {
            self::$directories[] = $directory;
        }
    }
}