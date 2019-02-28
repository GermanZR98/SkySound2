<?php
require_once "modelo/comentario.php";

class controllercomentario{
 
    public function __construct(){}

    public function index(){

        if(isset($_GET["idc"])): 

        $datos = comentario::getAllcomentario($_GET["idc"]);
        require_once "vista/index.comentario.php";

        else:
            header('Location:index.php?mod=cancion&ope=index');
        endif;
    }

    public function indexadmin(){

        if(isset($_GET["idc"])): 

        $datos = comentario::getAllcomentario($_GET["idc"]);
        require_once "vista/index.comentarioadmin.php";

        else:
            header('Location:index.php?mod=cancion&ope=indexadmin');
        endif;
    }


    public function create()
    {
        $idcancion = ($_GET["idc"]);
        
        if(isset($_GET["com"])): 

        $comentario = new comentario();
        $comentario->setComentario($_GET["com"]);
        $comentario->setIdcancion($_GET["idc"]);
        $comentario->setNombre($_GET["nom"]);


        $comentario->insert();
        header("Location:index.php?mod=comentario&ope=index&idc=$idcancion");

        else:
            require_once "vista/create.comentario.php";
        endif;


    }

    public function delete(){

        $idcancion = ($_GET["idc"]);

		if (isset($_GET["idc"])) comentario::deleteComentario($_GET["idc"]) ;
		
		header('Location:index.php?mod=comentario&ope=index');
    }

    public function deleteadmin(){

        $idcancion = ($_GET["idc"]);

		if (isset($_GET["idc"])) comentario::deleteComentario($_GET["idc"]) ;
		
		header('Location:index.php?mod=comentario&ope=indexadmin');
    }
    
    public function update(){
		$id = $_GET["idc"]??"";
		
		if (!empty($id)):

            $tab = comentario::getComentarios($_GET["idc"]) ;

            $idcancion = $tab->getIdcancion();

			if (isset($_GET["com"])):
                $tab->setComentario($_GET["com"]) ;
                $tab->update();
               // $this->index();
            
               header("Location:index.php?mod=comentario&ope=index&idc=$idcancion");
				// 
            else:
                $comentario = $tab->getComentario();
                $idcomentario = $tab->getIdcomentario();
                require_once "vista/update.comentario.php";
            endif;
            else:
           // $this->index();
		endif;
    }
    
    public function updateadmin(){
		$id = $_GET["idc"]??"";
		
		if (!empty($id)):

            $tab = comentario::getComentarios($_GET["idc"]) ;

            $idcancion = $tab->getIdcancion();

			if (isset($_GET["com"])):
                $tab->setComentario($_GET["com"]) ;
                $tab->update();
               // $this->index();
            
               header("Location:index.php?mod=comentario&ope=indexadmin&idc=$idcancion");
				// 
            else:
                $comentario = $tab->getComentario();
                $idcomentario = $tab->getIdcomentario();
                require_once "vista/update.comentarioadmin.php";
            endif;
            else:
           // $this->index();
		endif;
	}

}