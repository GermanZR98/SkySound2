<?php

require_once "modelo/usuario.php" ;
require_once "modelo/sesion.php" ;

    class controllerUsuario{

        private $sesion;

        public function __construct(){
            $this->sesion = new Sesion() ;
        }
        
            public function index(){            
                
                if(isset($_SESSION["nombreusuario"])){
                    header("Location: index.php?mod=cancion&ope=index");
                }
                
                if($_SERVER["REQUEST_METHOD"] == "GET") {
    
                   usuario::comprobar();
   
                }
            }

            

            public function cerrarSesion(){
                session_start();
                session_unset();
                session_destroy();
                header("Location: index.php") ;
            }



        public function create()
        {
            if(isset($_GET["cor"])):
                $usuario = new Usuario();
                $usuario->setCorreo($_GET["cor"]) ;
                $usuario->setContrasena($_GET["con"]) ;
                $usuario->setNombreusario($_GET["nom"]) ;

                $usuario->insert() ;
                header("location: index.php?mod=usuario&ope=index") ;
            else:
                require_once "vista/create.usuario.php" ;
            endif;
        }
    }