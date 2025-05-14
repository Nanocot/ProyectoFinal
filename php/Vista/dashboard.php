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
        <span class="gesUsuarios">Gestionar Usuarios</span>
        <span class="gesProductos">Gestionar Productos</span>
        <span class="gesColecciones">Gestionar Colecciones</span>
        <span class="gesDescuentos">Gestionar Descuentos</span>
        <span class="gesCategorias">Gestionar Categorías</span>
        <span class="gesCompras">Gestionar Compras</span>
        <span class="gesIncidencias">Gestionar Incidencias</span>
    </div>


     <button type="submit" onclick="cerrarSesion()">Cerrar sesion</button>

    <script type="text/javascript" src="javascript/script-funciones-genericas.js"></script>

</body>
</html>