<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Skysound</title>
    <link rel="stylesheet" href="estilos/estilos.css" type="text/css">
</head>
<body>

    <h1>Registro</h1>

    <form action="index.php" method="GET">
        <input id="mod" name="mod" type="hidden" value="usuario">
        <input id="ope" name="ope" type="hidden" value="create">

        <div id="formInner">
        <label for="cor">Correo:</label>
        <input id="cor" name="cor" type="text" value="" required>
        <br>
        <label for="con">Password:</label>
        <input id="con" name="con" type="password" value="" required>
        <br>
        <label for="nom">Nombre: </label>
		<input id="nom" name="nom" type="text" value="" required /> 
        <br>
        </div>

        <div id="texto2">
        <button type="submit">Registrarse</button>
        </div>

    </form>
    <div id="texto2">
    <a href="index.php?mod=usuario&ope=index">Login</a>
    </div>
    
</body>
</html>