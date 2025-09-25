<?php
require_once "Database.php";

class Cancion 
{

    private $idcancion ;
    private $artista ;
    private $ncancion ;
    private $reproduccion ;
    private $genero ;
    private $album ;

    // SETTERS
    public function setIdcancion($dta) { $this->idcancion = $dta; }
    public function setArtista($dta) { $this->artista = $dta; }
    public function setNcancion($dta) { $this->ncancion = $dta; }
    public function setReproduccion($dta) { $this->reproduccion = $dta; }
    public function setGenero($dta) { $this->genero = $dta; }
    public function setAlbum($dta) { $this->album = $dta; }

    // GETTERS
    public function getIdcancion() { return $this->idcancion; }
    public function getArtista() { return $this->artista; }
    public function getNcancion() { return $this->ncancion; }
    public function getReproduccion() { return $this->reproduccion; }
    public function getGenero() { return $this->genero; }
    public function getAlbum() { return $this->album; }

    public function __construct() {}

    //OBTENER TODAS LAS CANCIONES

    public static function getAllCanciones(){
        $bd = Database::getInstance();
        $bd->query("SELECT * FROM canciones;");
        
        $datos = [];

        while ($item = $bd->getRow("Cancion")) {
            array_push($datos,$item);
        }

        return $datos;
    }

    //INSERTAR CANCIONES EN LA BBDD 

    public function insert(){
        $bd = Database::getInstance();
        $bd->query("INSERT INTO canciones(artista, ncancion, genero, album) VALUES (:art, :nca, :gen, :alb);",
        [":art"=>$this->artista,
         ":gen"=>$this->genero,
         ":alb"=>$this->album,
         ":nca"=>$this->ncancion]);
    }

    //BORRAR CANCIONES EN LA BBDD 

    public function delete(){
        $db = Database::getInstance() ;
        $db->query("DELETE FROM canciones WHERE idcancion=:idcan ;",
        [":idcan"=>$this->idcancion]) ;				   
        }
        

    public static function deleteCancion($id){
        $db = Database::getInstance() ;
        $db->query("DELETE FROM canciones WHERE idcancion=:idcan ;",
        [":idcan"=>$id]) ;
        }

    //ACTUALIZAR CANCIONES EN LA BBDD 
        

    public function update(){
        $db = Database::getInstance() ;
        $db->query("UPDATE canciones SET ncancion=:nca, genero=:gen, album=:alb WHERE idcancion=:idc ;",
                        [":nca"=>$this->ncancion,
                        ":gen"=>$this->genero,
                        ":alb"=>$this->album,
                        ":idc"=>$this->idcancion]) ;
        
    }

    public static function getCancion($id){
        $db = Database::getInstance() ;
        $db->query("SELECT * FROM canciones WHERE idcancion=:idc ;",
                     [":idc"=>$id]) ;

        return $db->getRow("Cancion");
    }


}



?>