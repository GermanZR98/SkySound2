<?php 

require_once "config/Config.php";
require_once "utils/ErrorHandler.php";

class Database {

    private $dbConfig;

    private static $prp;
    private static $pdo;
    private static $instancia = null;
    
    private function __construct() 
    {
        $this->dbConfig = Config::getDatabaseConfig();
        $this->connect();
    } 
    
    private function __clone() {}
    
    public function __destruct() 
    {
        $this->close();
    }

    public static function getInstance()
    {
        if (is_null(self::$instancia)) {
            self::$instancia = new Database() ;
        }
        return self::$instancia ;
    }

    private function connect() 
    { 
        try {
            $dsn = "mysql:host={$this->dbConfig['host']};dbname={$this->dbConfig['name']};";
            self::$pdo = new PDO($dsn, 
                                $this->dbConfig['user'], 
                                $this->dbConfig['pass']);

            self::$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, 0);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch (Exception $e) {
            ErrorHandler::logError("Database connection failed: " . $e->getMessage());
            die("**ERROR: es imposible conectar con la base de datos. Póngase en contacto con el administrador");
        }
    }

    public function query($sql, $params = []) 
    {
        try {
            self::$prp = self::$pdo->prepare($sql);
            
            $flg = self::$prp->execute($params);

            return ($flg) && (self::$prp->rowCount() > 0);
        } catch (PDOException $e) {
            ErrorHandler::logError("Database query error: " . $e->getMessage(), ['sql' => $sql, 'params' => $params]);
            return false;
        }
    }

    public function getRow($class = "StdClass")
    {
        if (self::$prp) {
            return self::$prp->fetchObject($class);
        }
        return false;
    }

    public function getLastId()
    {
        return self::$pdo->lastInsertId();
    }

    public function close() 
    {
        self::$pdo = null;
    }
}

?>