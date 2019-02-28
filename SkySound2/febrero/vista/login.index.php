<?php  
//iniciamos session
$sesion=session_start();
$nombre = $_SESSION["nombreusuario"];

if ($nombre !== "admin"){
	if (isset($nombre)) {
		header("Location: index.php?mod=cancion&ope=index");
	}
}else{
	if (isset($nombre)) {
		header("Location: index.php?mod=cancion&ope=indexadmin");
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>login</title>
    <link rel="stylesheet" href="estilos/estilos.css" type="text/css">
</head>
<body>

<h1>LOGIN</h1>
    
<form action="index.php" method="GET">
        <input id="mod" name="mod" type="hidden" value="usuario">
        <input id="ope" name="ope" type="hidden" value="index" >


        <div id="formInner">
        <label for="nom">Usuario:</label>
        <input id="nom" name="nom" type="text" value="" required>
        <br>
        <label for="con">Password:</label>
        <input id="con" name="con" type="password" value="" required>
        <br>
        </div>

        <div id="texto2">
        <button type="submit">Entrar</button>
        </div>
        
    </form>
    <div id="texto2">
    <a href="index.php?mod=usuario&ope=create">Registro</a>
    </div>
</body>
</html>