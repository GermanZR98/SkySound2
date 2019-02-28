<?php
require_once "modelo/cancion.php";

class controllercancion{

    public function __construct(){}

    public function index(){

        $datos = cancion::getAllCanciones();
        require_once "vista/index.cancion.php";
    }

    public function indexadmin(){

        $datos = cancion::getAllCanciones();
        require_once "vista/index.cancionadmin.php";
    }

    public function create()
    {
         if(isset($_GET["art"])): 

        $cancion = new cancion();
        $cancion->setArtista($_GET["art"]);
        $cancion->setNcancion($_GET["nca"]);
        $cancion->setGenero($_GET["gen"]);
        $cancion->setAlbum($_GET["alb"]);


        $cancion->insert();
        header('Location:index.php?mod=cancion&ope=index');

         else:
             require_once "vista/create.cancion.php";
         endif;


    }

    public function delete(){

		if (isset($_GET["idc"])) cancion::deleteCancion($_GET["idc"]) ;
		
		header('Location:index.php?mod=cancion&ope=index');
    }

    public function deleteadmin(){

		if (isset($_GET["idc"])) cancion::deleteCancion($_GET["idc"]) ;
		
		header('Location:index.php?mod=cancion&ope=indexadmin');
    }
    
    public function update(){
		$id = $_GET["idc"]??"";
		
		if (!empty($id)):

            $tab = cancion::getCancion($_GET["idc"]) ;

			if (isset($_GET["nca"])):
                $tab->setNcancion($_GET["nca"]) ;
                $tab->setGenero($_GET["gen"]) ;
                $tab->setAlbum($_GET["alb"]) ;

                $tab->update();
                $this->index();
				// 
			else:
                $nombre = $tab->getNcancion();
                $idcancion = $tab->getIdcancion();
                $genero = $tab->getGenero();
                $album = $tab->getAlbum();
                require_once "vista/update.cancion.php";
            endif;
            else:
           // $this->index();
		endif;
    }
    
    public function updateadmin(){
		$id = $_GET["idc"]??"";
		
		if (!empty($id)):

            $tab = cancion::getCancion($_GET["idc"]) ;

			if (isset($_GET["nca"])):
                $tab->setNcancion($_GET["nca"]) ;
                $tab->setGenero($_GET["gen"]) ;
                $tab->setAlbum($_GET["alb"]) ;

                $tab->update();
                $this->indexadmin();
				// 
			else:
                $nombre = $tab->getNcancion();
                $idcancion = $tab->getIdcancion();
                $genero = $tab->getGenero();
                $album = $tab->getAlbum();
                require_once "vista/update.cancionadmin.php";
            endif;
            else:
           // $this->index();
		endif;
	}

}