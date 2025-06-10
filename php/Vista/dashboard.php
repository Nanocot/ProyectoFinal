<?php 
    if(!isset($_SESSION["usuario"]) || !isset($_SESSION ) && $_SESSION["usuario"] != "Administrador"){
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
    <link rel="stylesheet" href="../estilos/estilodashboard.css">

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


    <div class="dashboard">
        <a href="index.php?action=gestionarUsuarios"><span class="gesUsuarios">Gestionar Usuarios</span></a>
        <a href="index.php?action=gestionarProductos"><span class="gesProductos">Gestionar Productos</span></a>
        <a href="index.php?action=gestionarColecciones"><span class="gesColecciones">Gestionar Colecciones</span></a>
        <a href="index.php?action=gestionarDescuentos"><span class="gesDescuentos">Gestionar Descuentos</span></a>
        <a href="index.php?action=gestionarCategorias"><span class="gesCategorias">Gestionar Categorías</span></a>
        <a href="index.php?action=gestionarCompras"><span class="gesCompras">Gestionar Compras</span></a>
        <a href="index.php?action=gestionarIncidencias"><span class="gesIncidencias">Gestionar Incidencias</span></a>
    </div>


     <button type="submit" onclick="cerrarSesion()">Cerrar sesion</button>

    <script type="text/javascript" src="javascript/script-funciones-genericas.js"></script>

</body>
</html>