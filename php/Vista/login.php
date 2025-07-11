<?php 
    if(isset($_SESSION["usuario"]) && $_SESSION["usuario"] == "Administrador"){
        header("Location: index.php?action=dashboard");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/estiloprincipal.css">
    <link rel="stylesheet" href="../estilos/estilologin.css">
    <title>Farko</title>
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

    
    
    <div class="formInicioSesion">
        <h1>Inicio Sesión</h1>
        <form action="index.php?action=login" method="post">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>
            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" required>
            <button type="submit" id="envio">Iniciar Sesión</button>
        </form>
        <p>¿No tienes cuenta? <a href="index.php?action=register">Registrate aquí</a></p>
    </div>


    <script type="text/javascript" src="javascript/script-funciones-login.js"></script>
    <script type="text/javascript" src="javascript/script-funciones-genericas.js"></script>


</body>
</html>