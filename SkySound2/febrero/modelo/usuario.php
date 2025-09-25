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

    public static function comprobar()
    {                                      
        if (isset($_GET["nom"]) && isset($_GET["con"])) {
            $nombre   = filter_var($_GET["nom"], FILTER_SANITIZE_STRING);
            $password = filter_var($_GET["con"], FILTER_SANITIZE_STRING);
       
            $db = Database::getInstance();

            $db->query("SELECT * FROM usuario WHERE nombreusuario=:nom AND contrasena=:con;",
                            [":nom" => $nombre,
                             ":con" => $password]);
                             
            $resultado = $db->getRow();
            session_start();
           
            if ($resultado !== false) {
                if (Config::isAdmin($nombre)) {
                    $_SESSION[Config::SESSION_NAME] = $nombre;
                    header("Location: index.php?mod=cancion&ope=indexadmin");
                } else {
                    $_SESSION[Config::SESSION_NAME] = $nombre;
                    header("Location: index.php?mod=cancion&ope=index");
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
        $bd->query("INSERT INTO usuario(correo, contrasena, nombreusuario) VALUES (:cor, :con, :nom);",
            [":cor" => $this->correo,
             ":con" => $this->contrasena,
             ":nom" => $this->nombreusuario]);
    }
    

    



}