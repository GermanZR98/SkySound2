<?php
require_once "modelo/comentario.php";
require_once "controlador/BaseController.php";

class ControllerComentario extends BaseController
{
    public function __construct()
    {
        $this->initSession();
    }

    public function index()
    {
        $this->requireLogin();
        $this->handleIndex("index.comentario.php", "index.php?mod=cancion&ope=index");
    }

    public function indexadmin()
    {
        $this->requireLogin();
        if (!$this->isCurrentUserAdmin()) {
            $this->redirect("index.php?mod=cancion&ope=index");
        }
        $this->handleIndex("index.comentarioadmin.php", "index.php?mod=cancion&ope=indexadmin");
    }

    public function create()
    {
        $this->requireLogin();
        $idcancion = $this->getParameter("idc");
        
        if (!$idcancion) {
            $this->redirectWithError("ID de canción requerido");
        }
        
        $comentarioText = $this->getParameter("com");
        
        if ($comentarioText) {
            $nombre = $this->getRequiredParameter("nom");
            
            // Basic validation
            if (strlen(trim($comentarioText)) < 2) {
                $this->redirectWithError("El comentario debe tener al menos 2 caracteres");
            }

            $comentario = new Comentario();
            $comentario->setComentario($comentarioText);
            $comentario->setIdcancion($idcancion);
            $comentario->setNombre($nombre);

            $comentario->insert();
            $this->redirect("index.php?mod=comentario&ope=index&idc=" . $idcancion);
        } else {
            $this->loadView("create.comentario.php", ['idcancion' => $idcancion]);
        }
    }

    public function delete()
    {
        $this->requireLogin();
        $id = $this->getParameter("idc");
        
        if ($id) {
            Comentario::deleteComentario($id);
        }
        
        $this->redirect("index.php?mod=comentario&ope=index");
    }

    public function deleteadmin()
    {
        $this->requireLogin();
        if (!$this->isCurrentUserAdmin()) {
            $this->redirect("index.php?mod=cancion&ope=index");
        }
        
        $id = $this->getParameter("idc");
        
        if ($id) {
            Comentario::deleteComentario($id);
        }
        
        $this->redirect("index.php?mod=comentario&ope=indexadmin");
    }
    
    public function update()
    {
        $this->requireLogin();
        $this->handleUpdate("update.comentario.php", "index");
    }
    
    public function updateadmin()
    {
        $this->requireLogin();
        if (!$this->isCurrentUserAdmin()) {
            $this->redirect("index.php?mod=cancion&ope=index");
        }
        $this->handleUpdate("update.comentarioadmin.php", "indexadmin");
    }

    private function handleIndex($viewFile, $fallbackUrl)
    {
        $idcancion = $this->getParameter("idc");
        
        if ($idcancion) {
            $datos = Comentario::getAllcomentario($idcancion);
            $this->loadView($viewFile, ['datos' => $datos]);
        } else {
            $this->redirect($fallbackUrl);
        }
    }

    private function handleUpdate($viewFile, $operation)
    {
        $id = $this->getParameter("idc");
        
        if (!empty($id)) {
            $comentario = Comentario::getComentarios($id);
            
            if (!$comentario) {
                $this->redirectWithError("Comentario no encontrado");
            }

            $idcancion = $comentario->getIdcancion();
            $comentarioText = $this->getParameter("com");
            
            if ($comentarioText) {
                // Basic validation
                if (strlen(trim($comentarioText)) < 2) {
                    $this->redirectWithError("El comentario debe tener al menos 2 caracteres");
                }
                
                $comentario->setComentario($comentarioText);
                $comentario->update();
               
                $this->redirect("index.php?mod=comentario&ope=$operation&idc=" . $idcancion);
            } else {
                $data = [
                    'comentario' => $comentario->getComentario(),
                    'idcomentario' => $comentario->getIdcomentario()
                ];
                $this->loadView($viewFile, $data);
            }
        }
    }
}