<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../estilos/estiloprincipal.css">
    <link rel="stylesheet" href="../../estilos/estilocarrito.css">
    <title>FARKO</title>
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
                <li><a href="index.php?action=aboutus">Sobre Nosotros</a></li>
            </ul>
        </nav>
    </header>


    <div class="carrito">


    </div>

    <div class="controles">
        <div class="total">Precio total: <span id="precioTotal"></span> € </div>
        <button id="borrar" type="submit">Borrar Carrito</button>
    </div>
    
    <script src="../../javascript/script-funciones-genericas.js" type="text/javascript"></script>
    <script src="../../javascript/script-carrito.js" type="text/javascript"></script>

</body>
</html>