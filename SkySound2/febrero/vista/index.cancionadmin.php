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

    <h1>ADMIN</h1>

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
    <a href="index.php?mod=comentario&ope=indexadmin&idc=<?=$item->getIdcancion();?>">Comentarios -</a>
    <a href="index.php?mod=cancion&ope=deleteadmin&idc=<?=$item->getIdcancion();?>">Borrar -</a>
    <a href="index.php?mod=cancion&ope=updateadmin&idc=<?=$item->getIdcancion();?>">Editar</a><br>
    </div>


    <?php
        }
    ?>

    <div id="texto2">
    <a href="index.php?mod=usuario&ope=cerrarSesion">Cerrar Sesion</a>
    </div>
    
</body>
</html>