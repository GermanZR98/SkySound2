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

            // Basic validation
            if (strlen(trim($artista)) < 2) {
                $this->redirectWithError("El artista debe tener al menos 2 caracteres");
            }
            if (strlen(trim($ncancion)) < 2) {
                $this->redirectWithError("El nombre de la canción debe tener al menos 2 caracteres");
            }

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
                
                // Basic validation
                if (strlen(trim($ncancion)) < 2) {
                    $this->redirectWithError("El nombre de la canción debe tener al menos 2 caracteres");
                }
                
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