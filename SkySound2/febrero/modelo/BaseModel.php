<?php

require_once "modelo/Database.php";
require_once "utils/ErrorHandler.php";

/**
 * Base model class with common database operations
 */
abstract class BaseModel
{
    protected $db;
    protected $table;
    protected $primaryKey = 'id';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Find record by ID
     */
    public function findById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id";
        $result = $this->db->query($sql, [':id' => $id]);
        
        if ($result) {
            return $this->db->getRow(get_class($this));
        }
        
        return false;
    }

    /**
     * Find all records
     */
    public function findAll($limit = null, $offset = 0)
    {
        $sql = "SELECT * FROM {$this->table}";
        $params = [];
        
        if ($limit) {
            $sql .= " LIMIT :limit OFFSET :offset";
            $params[':limit'] = $limit;
            $params[':offset'] = $offset;
        }
        
        $this->db->query($sql, $params);
        
        $results = [];
        while ($item = $this->db->getRow(get_class($this))) {
            $results[] = $item;
        }
        
        return $results;
    }

    /**
     * Count total records
     */
    public function count()
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        $result = $this->db->query($sql);
        
        if ($result) {
            $row = $this->db->getRow();
            return $row->total ?? 0;
        }
        
        return 0;
    }

    /**
     * Delete record by ID
     */
    public function deleteById($id)
    {
        try {
            $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id";
            return $this->db->query($sql, [':id' => $id]);
        } catch (Exception $e) {
            ErrorHandler::logError("Delete operation failed", [
                'table' => $this->table,
                'id' => $id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Check if record exists
     */
    public function exists($id)
    {
        $sql = "SELECT 1 FROM {$this->table} WHERE {$this->primaryKey} = :id LIMIT 1";
        return $this->db->query($sql, [':id' => $id]);
    }

    /**
     * Find records by field
     */
    public function findBy($field, $value, $limit = null)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$field} = :value";
        $params = [':value' => $value];
        
        if ($limit) {
            $sql .= " LIMIT :limit";
            $params[':limit'] = $limit;
        }
        
        $this->db->query($sql, $params);
        
        $results = [];
        while ($item = $this->db->getRow(get_class($this))) {
            $results[] = $item;
        }
        
        return $results;
    }

    /**
     * Get validation rules for model
     */
    abstract protected function getValidationRules();

    /**
     * Validate model data
     */
    public function validate($data)
    {
        $errors = [];
        $rules = $this->getValidationRules();
        
        foreach ($rules as $field => $rule) {
            $value = $data[$field] ?? null;
            
            if (isset($rule['required']) && $rule['required'] && empty($value)) {
                $errors[$field] = "Field {$field} is required";
                continue;
            }
            
            if (!empty($value) && isset($rule['min_length'])) {
                if (strlen($value) < $rule['min_length']) {
                    $errors[$field] = "Field {$field} must be at least {$rule['min_length']} characters";
                }
            }
            
            if (!empty($value) && isset($rule['max_length'])) {
                if (strlen($value) > $rule['max_length']) {
                    $errors[$field] = "Field {$field} must not exceed {$rule['max_length']} characters";
                }
            }
            
            if (!empty($value) && isset($rule['email']) && $rule['email']) {
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $errors[$field] = "Field {$field} must be a valid email";
                }
            }
        }
        
        return $errors;
    }
}