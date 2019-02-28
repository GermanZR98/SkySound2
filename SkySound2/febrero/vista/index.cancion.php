<?php  
//iniciamos session
$sesion=session_start();
if (!isset($_SESSION["nombreusuario"])){
	header("location: index.php");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Canciones</title>
    <link rel="stylesheet" href="estilos/estilos.css" type="text/css">
</head>
<body>

    <h1>Añade la canción que quieras</h1>

    <h3>Bienvenido: <?php echo $_SESSION["nombreusuario"]?></h3>

    <?php
        foreach($datos as $item){
    ?>

    <div id="texto">
    <?=$item->getArtista();?> - 
    <?=$item->getNcancion();?> [
    <?=$item->getGenero();?> |
    <?=$item->getAlbum();?> ]
    </div>

    <div id="texto3">
    <a href="index.php?mod=comentario&ope=create&idc=<?=$item->getIdcancion();?>">Crear comentario -</a>
    <a href="index.php?mod=comentario&ope=index&idc=<?=$item->getIdcancion();?>">Comentarios</a>
    </div>


    <?php
        }
    ?>

    <div id="texto2">
    <a href="index.php?mod=cancion&ope=create">Añadir canción</a> |
    <a href="index.php?mod=usuario&ope=cerrarSesion">Cerrar Sesion</a>
    </div>
    
</body>
</html>