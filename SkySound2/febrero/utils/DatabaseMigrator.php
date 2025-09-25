<?php

require_once "config/Config.php";
require_once "modelo/Database.php";
require_once "utils/ErrorHandler.php";

/**
 * Simple database migration system
 */
class DatabaseMigrator
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Run all pending migrations
     */
    public function runMigrations()
    {
        $this->createMigrationsTable();
        
        $migrations = [
            '001_add_csrf_tokens_table',
            '002_improve_password_security'
        ];

        foreach ($migrations as $migration) {
            if (!$this->isMigrationRun($migration)) {
                $this->runMigration($migration);
                $this->markMigrationAsRun($migration);
            }
        }
    }

    /**
     * Create migrations tracking table
     */
    private function createMigrationsTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration_name VARCHAR(255) NOT NULL UNIQUE,
            executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        
        $this->db->query($sql);
    }

    /**
     * Check if migration has been run
     */
    private function isMigrationRun($migration)
    {
        $result = $this->db->query("SELECT id FROM migrations WHERE migration_name = :name", 
                                  [':name' => $migration]);
        return $result;
    }

    /**
     * Mark migration as executed
     */
    private function markMigrationAsRun($migration)
    {
        $this->db->query("INSERT INTO migrations (migration_name) VALUES (:name)",
                        [':name' => $migration]);
    }

    /**
     * Run specific migration
     */
    private function runMigration($migration)
    {
        try {
            switch ($migration) {
                case '001_add_csrf_tokens_table':
                    $this->migration_001_add_csrf_tokens_table();
                    break;
                case '002_improve_password_security':
                    $this->migration_002_improve_password_security();
                    break;
                default:
                    ErrorHandler::logError("Unknown migration: $migration");
                    break;
            }
        } catch (Exception $e) {
            ErrorHandler::logError("Migration failed: $migration - " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Migration: Add CSRF tokens table
     */
    private function migration_001_add_csrf_tokens_table()
    {
        $sql = "CREATE TABLE IF NOT EXISTS csrf_tokens (
            id INT AUTO_INCREMENT PRIMARY KEY,
            token VARCHAR(255) NOT NULL UNIQUE,
            user_session VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            expires_at TIMESTAMP,
            INDEX idx_token (token),
            INDEX idx_expires (expires_at)
        )";
        
        $this->db->query($sql);
    }

    /**
     * Migration: Improve password security
     */
    private function migration_002_improve_password_security()
    {
        // Add password_hash column if it doesn't exist
        $sql = "ALTER TABLE usuario 
                ADD COLUMN password_hash VARCHAR(255) NULL AFTER contrasena,
                ADD COLUMN password_updated_at TIMESTAMP NULL";
        
        try {
            $this->db->query($sql);
        } catch (Exception $e) {
            // Column might already exist, that's OK
            if (strpos($e->getMessage(), 'Duplicate column name') === false) {
                throw $e;
            }
        }
    }

    /**
     * Clean up expired CSRF tokens
     */
    public function cleanupExpiredTokens()
    {
        $this->db->query("DELETE FROM csrf_tokens WHERE expires_at < NOW()");
    }
}