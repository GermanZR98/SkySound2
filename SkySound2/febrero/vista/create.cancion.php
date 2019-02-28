

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

    <h1>Añadir nueva canción</h1>

    <form action="index.php" method="GET">
        <input id="mod" name="mod" type="hidden" value="cancion">
        <input id="ope" name="ope" type="hidden" value="create">

        <div id="formInner">
        <label for="art">Artista:</label>
        <input id="art" name="art" type="text" value="">
        <br>
        <label for="nca">Nombre canción:</label>
        <input id="nca" name="nca" type="text" value="">
        <br>
        <label for="gen">Género:</label>
        <input id="gen" name="gen" type="text" value="">
        <br>
        <label for="alb">Álbum: </label>
		<input id="alb" name="alb" type="text" value="" /> 
        <br>
        </div>

        <div id="texto2">
        <button type="submit">Añadir canción</button> |

        </form>
        <a href="index.php?mod=cancion&ope=index">Volver atrás</a>
        </div>    
</body>
</html>