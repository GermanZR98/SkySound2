
<?php  
//iniciamos session
$sesion=session_start();
if (!isset($_SESSION["nombreusuario"])){
	header("location:index.php");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Comentarios</title>
    <link rel="stylesheet" href="estilos/estilos.css" type="text/css">
</head>
<body>

    <h1>Comentario ADMIN</h1> 

    <?php
        foreach($datos as $item){
    ?>

    <div id="formInner">
    [
    <?=$item->getComentario();?> |
    <?=$item->getNombre();?> ]
    </div>
    
    <div id="texto2">
    <a href="index.php?mod=comentario&ope=deleteadmin&idc=<?=$item->getIdcomentario();?>">Borrar</a> |
    <a href="index.php?mod=comentario&ope=updateadmin&idc=<?=$item->getIdcomentario();?>">Editar</a><br>
    </div>

    <br>

    <?php
        }
    ?>

    <div id="texto2">
    <a href="index.php?mod=cancion&ope=indexadmin">Volver atrás</a>
    </div>

</body>
</html>