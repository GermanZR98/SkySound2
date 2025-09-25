<?php

require_once "modelo/usuario.php";
require_once "modelo/sesion.php";
require_once "controlador/BaseController.php";

class ControllerUsuario extends BaseController
{
    private $sesion;

    public function __construct()
    {
        parent::__construct();
        $this->sesion = new Sesion();
    }
    
    public function index()
    {            
        if ($this->isLoggedIn()) {
            if ($this->isCurrentUserAdmin()) {
                $this->redirect("index.php?mod=cancion&ope=indexadmin");
            } else {
                $this->redirect("index.php?mod=cancion&ope=index");
            }
        }
        
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            Usuario::comprobar();
        }
    }

    public function cerrarSesion()
    {
        $this->sessionManager->logout();
        $this->redirect("index.php");
    }

    public function create()
    {
        $correo = $this->getParameter("cor");
        
        if ($correo) {
            $contrasena = $this->getRequiredParameter("con");
            $nombre = $this->getRequiredParameter("nom");
            
            // Validate inputs
            $this->validateEmail($correo, "Correo");
            $this->validateMinLength($contrasena, 3, "Contraseña");
            $this->validateMinLength($nombre, 2, "Nombre");

            $usuario = new Usuario();
            $usuario->setCorreo($correo);
            $usuario->setContrasena($contrasena);
            $usuario->setNombreusario($nombre);

            $usuario->insert();
            $this->redirect("index.php?mod=usuario&ope=index");
        } else {
            $this->loadView("create.usuario.php");
        }
    }
}
