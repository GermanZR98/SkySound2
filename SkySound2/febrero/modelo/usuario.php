<?php
require_once "Database.php";
require_once "sesion.php" ;


class usuario { 

    private $sesion;

    private $idusuario ;
    private $correo ;
    private $contrasena ;
    private $nombreusuario ;

    //SETTERS

    public function setIdusuario($dta)        {$this->idusuario = $dta;}
    public function setCorreo($dta)        {$this->correo = $dta;}
    public function setContrasena($dta)        {$this->contrasena = $dta;}
    public function setNombreusario($dta)        {$this->nombreusuario = $dta;}

    //GETTERS

    public function getIdusuario()            {return $this->idusuario;}
    public function getCorreo()            {return $this->correo;}
    public function getContrasena()            {return $this->contrasena;}
    public function getNombreusuario()            {return $this->nombreusuario;}

    public function __contruct() {}

        //OBTENER TODAS LAS CANCIONES

        public static function comprobar(){                                      

                if(isset($_GET["nom"]) && isset($_GET["con"])){
                    $nombre   = $_GET["nom"];
                    $password = $_GET["con"];
               
                    $db = Database::getInstance();

                    $db->query("SELECT * FROM usuario WHERE nombreusuario=:nom AND contrasena=:con;",
                                    [":nom" => $nombre,
                                     ":con" => $password]);

                                     
                    $resultado = $db->getRow();
                    session_start();
                   
                 
                    if ($resultado !== false) {
                        if($nombre !== "admin"){
                        $_SESSION["nombreusuario"]=$nombre;
                        header("Location: index.php?mod=cancion&ope=index");
                        }else{
                            $_SESSION["nombreusuario"]=$nombre;
                            header("Location: index.php?mod=cancion&ope=indexadmin");
                        }
                        
                    }else{
                        require_once "vista/login.index.php";
                        echo "El nombre o la contraseña no es correcta";
                    
                    }
                } else{
                    require_once "vista/login.index.php";
                }
            }


        public function insert(){
            $bd = Database::getInstance();
            $bd->query("INSERT INTO usuario(correo, contrasena, nombreusuario) VALUES (:cor, :con, :nom);",
            [":cor"=>$this->correo,
             ":con"=>$this->contrasena,
             ":nom"=>$this->nombreusuario]);
        }
    

    



}