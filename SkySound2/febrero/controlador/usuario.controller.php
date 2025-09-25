<?php

require_once "modelo/usuario.php";
require_once "modelo/sesion.php";
require_once "controlador/BaseController.php";

class ControllerUsuario extends BaseController
{
    private $sesion;

    public function __construct()
    {
        $this->sesion = new Sesion();
    }
    
    public function index()
    {            
        $this->initSession();
        
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
        $this->initSession();
        session_unset();
        session_destroy();
        $this->redirect("index.php");
    }

    public function create()
    {
        $correo = $this->getParameter("cor");
        
        if ($correo) {
            $contrasena = $this->getRequiredParameter("con");
            $nombre = $this->getRequiredParameter("nom");
            
            // Basic validation
            if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                $this->redirectWithError("Email inválido");
            }
            
            if (strlen($contrasena) < 3) {
                $this->redirectWithError("La contraseña debe tener al menos 3 caracteres");
            }
            
            if (strlen($nombre) < 2) {
                $this->redirectWithError("El nombre debe tener al menos 2 caracteres");
            }

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
