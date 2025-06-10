<?php 
    if(!isset($_SESSION["usuario"]) || !isset($_SESSION)){
        header("location: index.php?action=home");
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FARKO</title>
    <link rel="stylesheet" href="../estilos/estiloprincipal.css">
    <link rel="stylesheet" href="../estilos/estilousuario.css">

</head>
<body>
    
     <header>
        <a href="index.php?action=home">
            <img src="../imagenes/Farko-logo-pequenio.png" alt="logo de farko">
        </a>
        <nav>
            <ul class="menu">
                <li><a href="index.php?action=home">Home</a></li>
                <li><a href="index.php?action=carrito">Carrito</a></li>
                <li><a href="index.php?action=aboutus">Sobre Nosotros</a></li>
            </ul>
        </nav>
    </header>

    <div class="datosUsuario">
        <span class="email">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" readonly value="<?= $_SESSION["usuario"] ?>">
        </span>
        <span class="modPerfil">
            Modificar Perfil
        </span>
        <span>
            
        </span>
    </div>

     <button type="submit" onclick="cerrarSesion()">Cerrar sesion</button>

    <script type="text/javascript" src="javascript/script-funciones-genericas.js"></script>

</body>
</html>