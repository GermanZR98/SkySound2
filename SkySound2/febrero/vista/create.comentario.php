<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="estilos/estilos.css" type="text/css">
    <title>Skysound</title>
</head> 
<body>

    <h1>Añadir comentario</h1>

    <form action="index.php" method="GET">
        <input id="mod" name="mod" type="hidden" value="comentario">
        <input id="ope" name="ope" type="hidden" value="create">
        <input id="idc" name="idc" type="hidden" value="<?=$_GET["idc"]?>">

        <div id="formInner">
        <label for="com">Comentario:</label>
        <input id="com" name="com" type="text" value="">
        <br>
        <label for="nom">¿Quien eres?:</label>
        <input id="nom" name="nom" type="text" value="">
        <br>
        </div>

        <br>
        <br>

        <div id="texto2">
        <button type="submit">Añadir comentario</button> |
        

        </form>
        <a href="index.php?mod=cancion&ope=index">Volver atrás</a>
        </div>

</body>
</html>