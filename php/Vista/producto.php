<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/estiloprincipal.css">
    <title>Farko</title>
    <!-- <style>
        body{
            color:white;
        }
    </style> -->
</head>
<body>
    
<header>
        <a href="index.php?action=home">
            <img src="../imagenes/Farko-logo-pequenio.png" alt="logo de farko">
        </a>
        <nav>
            <ul>
                <li><a href="index.php?action=home">Home</a></li>
                <li><a href="index.php?action=usuario">Usuario</a></li>
                <li><a href="index.php?action=carrito">Carrito</a></li>
                <li><a href="index.php?action=aboutus">Sobre Nosotros</a></li>
            </ul>
        </nav>
    </header>

    <div id="resultado" style="white-space: pre-wrap; font-family: monospace"></div>


    <div class="producto">
        <img src="" alt="Imagen del producto" id="imagenProd">
        <div id="nombreProd"></div>
        <div id="precioProd"></div>
        <div id="descpProd"></div>
        <div id="coloresProd"></div>
        <div id="tallasProd"></div>
    </div>

    <script src="../../javascript/script-filtro-producto.js"></script>
</body>
</html>