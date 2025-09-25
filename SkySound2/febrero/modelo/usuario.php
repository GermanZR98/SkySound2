<?php
require_once "Database.php";
require_once "sesion.php";
require_once "config/Config.php";


class Usuario 
{

    private $sesion;

    private $idusuario ;
    private $correo ;
    private $contrasena ;
    private $nombreusuario ;

    // SETTERS
    public function setIdusuario($dta) { $this->idusuario = $dta; }
    public function setCorreo($dta) { $this->correo = $dta; }
    public function setContrasena($dta) { $this->contrasena = $dta; }
    public function setNombreusario($dta) { $this->nombreusuario = $dta; }

    // GETTERS
    public function getIdusuario() { return $this->idusuario; }
    public function getCorreo() { return $this->correo; }
    public function getContrasena() { return $this->contrasena; }
    public function getNombreusuario() { return $this->nombreusuario; }

    public function __construct() {}

    /**
     * Hash password for storage
     */
    private function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Verify password against hash
     */
    private static function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }

    public static function comprobar()
    {                                      
        if (isset($_GET["nom"]) && isset($_GET["con"])) {
            $nombre   = filter_var($_GET["nom"], FILTER_SANITIZE_STRING);
            $password = filter_var($_GET["con"], FILTER_SANITIZE_STRING);
       
            $db = Database::getInstance();

            // First try to get user data
            $db->query("SELECT * FROM usuario WHERE nombreusuario=:nom;", [":nom" => $nombre]);
            $resultado = $db->getRow();
            
            session_start();
           
            if ($resultado !== false) {
                // Check if password is hashed or plain text (for backward compatibility)
                $isValidPassword = false;
                
                // Check for admin with plain text password (temporary for compatibility)
                if (Config::isAdmin($nombre) && $password === Config::ADMIN_PASSWORD) {
                    $isValidPassword = true;
                }
                // Check if stored password looks like a hash
                elseif (strlen($resultado->contrasena) > 50 && password_verify($password, $resultado->contrasena)) {
                    $isValidPassword = true;
                }
                // Fallback to plain text comparison (for existing users)
                elseif ($password === $resultado->contrasena) {
                    $isValidPassword = true;
                    // TODO: Update to hashed password on next login
                }
                
                if ($isValidPassword) {
                    $_SESSION[Config::SESSION_NAME] = $nombre;
                    if (Config::isAdmin($nombre)) {
                        header("Location: index.php?mod=cancion&ope=indexadmin");
                    } else {
                        header("Location: index.php?mod=cancion&ope=index");
                    }
                } else {
                    require_once "vista/login.index.php";
                    echo "El nombre o la contraseña no es correcta";
                }
            } else {
                require_once "vista/login.index.php";
                echo "El nombre o la contraseña no es correcta";
            }
        } else {
            require_once "vista/login.index.php";
        }
    }


    public function insert()
    {
        $bd = Database::getInstance();
        $hashedPassword = $this->hashPassword($this->contrasena);
        $bd->query("INSERT INTO usuario(correo, contrasena, nombreusuario) VALUES (:cor, :con, :nom);",
            [":cor" => $this->correo,
             ":con" => $hashedPassword,
             ":nom" => $this->nombreusuario]);
    }
    

    



}