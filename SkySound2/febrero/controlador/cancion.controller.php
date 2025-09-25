<?php
require_once "modelo/cancion.php";
require_once "controlador/BaseController.php";

class ControllerCancion extends BaseController
{
    public function __construct()
    {
        $this->initSession();
    }

    public function index()
    {
        $this->requireLogin();
        $datos = Cancion::getAllCanciones();
        $this->loadView("index.cancion.php", ['datos' => $datos]);
    }

    public function indexadmin()
    {
        $this->requireLogin();
        if (!$this->isCurrentUserAdmin()) {
            $this->redirect("index.php?mod=cancion&ope=index");
        }
        $datos = Cancion::getAllCanciones();
        $this->loadView("index.cancionadmin.php", ['datos' => $datos]);
    }

    public function create()
    {
        $this->requireLogin();
        
        $artista = $this->getParameter("art");
        
        if ($artista) {
            $ncancion = $this->getRequiredParameter("nca");
            $genero = $this->getRequiredParameter("gen");
            $album = $this->getRequiredParameter("alb");

            // Validate inputs
            $this->validateMinLength($artista, 2, "Artista");
            $this->validateMinLength($ncancion, 2, "Nombre de canción");

            $cancion = new Cancion();
            $cancion->setArtista($artista);
            $cancion->setNcancion($ncancion);
            $cancion->setGenero($genero);
            $cancion->setAlbum($album);

            $cancion->insert();
            $this->redirectToIndex();
        } else {
            $this->loadView("create.cancion.php");
        }
    }

    public function delete()
    {
        $this->requireLogin();
        $id = $this->getParameter("idc");
        
        if ($id) {
            $this->validateId($id, "ID de canción");
            Cancion::deleteCancion($id);
        }
        
        $this->redirectToIndex();
    }

    public function deleteadmin()
    {
        $this->requireLogin();
        if (!$this->isCurrentUserAdmin()) {
            $this->redirect("index.php?mod=cancion&ope=index");
        }
        
        $id = $this->getParameter("idc");
        
        if ($id) {
            $this->validateId($id, "ID de canción");
            Cancion::deleteCancion($id);
        }
        
        $this->redirect("index.php?mod=cancion&ope=indexadmin");
    }
    
    public function update()
    {
        $this->requireLogin();
        $this->handleUpdate("update.cancion.php", "index.php?mod=cancion&ope=index");
    }
    
    public function updateadmin()
    {
        $this->requireLogin();
        if (!$this->isCurrentUserAdmin()) {
            $this->redirect("index.php?mod=cancion&ope=index");
        }
        $this->handleUpdate("update.cancionadmin.php", "index.php?mod=cancion&ope=indexadmin");
    }

    private function handleUpdate($viewFile, $redirectUrl)
    {
        $id = $this->getParameter("idc");
        
        if (!empty($id)) {
            $cancion = Cancion::getCancion($id);
            
            if (!$cancion) {
                $this->redirectWithError("Canción no encontrada");
            }

            $ncancion = $this->getParameter("nca");
            
            if ($ncancion) {
                $genero = $this->getRequiredParameter("gen");
                $album = $this->getRequiredParameter("alb");
                
                // Validate inputs
                $this->validateMinLength($ncancion, 2, "Nombre de canción");
                
                $cancion->setNcancion($ncancion);
                $cancion->setGenero($genero);
                $cancion->setAlbum($album);

                $cancion->update();
                $this->redirect($redirectUrl);
            } else {
                $data = [
                    'nombre' => $cancion->getNcancion(),
                    'idcancion' => $cancion->getIdcancion(),
                    'genero' => $cancion->getGenero(),
                    'album' => $cancion->getAlbum()
                ];
                $this->loadView($viewFile, $data);
            }
        } else {
            $this->redirect($redirectUrl);
        }
    }

    private function redirectToIndex()
    {
        if ($this->isCurrentUserAdmin()) {
            $this->redirect("index.php?mod=cancion&ope=indexadmin");
        } else {
            $this->redirect("index.php?mod=cancion&ope=index");
        }
    }
}