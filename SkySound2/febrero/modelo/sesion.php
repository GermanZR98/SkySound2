<?php 

class Sesion 
{
    public function iniciar()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function obtenerSesion()
    {
        return $_SESSION;
    }

    public function get($key)
    {
        return !empty($_SESSION[$key]) ? $_SESSION[$key] : null; 
    }

    public function estado()
    {
        return session_status();
    }

    public function cerrar()
    {
        session_unset();
        session_destroy();
    }
}


?>