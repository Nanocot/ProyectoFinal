<?php 
    if(!isset($_SESSION["usuario"]) || !isset($_SESSION)){
        header("location: index.php?action=home");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FARKO</title>
    <link rel="stylesheet" href="../estilos/estiloprincipal.css">
    <link rel="stylesheet" href="../estilos/estilodashboard.css">

</head>
<body>
    
     <header>
        <a href="index.php?action=home">
            <img src="../imagenes/Farko-logo-pequenio.png" alt="logo de farko">
        </a>
        <nav>
            <ul>
                <li><a href="index.php?action=home">Home</a></li>
                <li><a href="index.php?action=carrito">Carrito</a></li>
                <li><a href="index.php?action=aboutus">Sobre Nosotros</a></li>
            </ul>
        </nav>
    </header>


    <div class="dashboard">
        <span class="gesUsuarios"><a href="index.php?action=gestionarUsuarios">Gestionar Usuarios</a></span>
        <span class="gesProductos"><a href="index.php?action=gestionarProductos">Gestionar Productos</a></span>
        <span class="gesColecciones"><a href="index.php?action=gestionarColecciones">Gestionar Colecciones</a></span>
        <span class="gesDescuentos"><a href="index.php?action=gestionarDescuentos">Gestionar Descuentos</a></span>
        <span class="gesCategorias"><a href="index.php?action=gestionarCategorias">Gestionar Categorías</a></span>
        <span class="gesCompras"><a href="index.php?action=gestionarCompras">Gestionar Compras</a></span>
        <span class="gesIncidencias"><a href="index.php?action=gestionarIncidencias">Gestionar Incidencias</a></span>
    </div>


     <button type="submit" onclick="cerrarSesion()">Cerrar sesion</button>

    <script type="text/javascript" src="javascript/script-funciones-genericas.js"></script>

</body>
</html>