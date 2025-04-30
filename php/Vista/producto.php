<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/estiloprincipal.css">
    <title>Farko</title>
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
        <div id="coloresProd">
            <label for="colores">COLOR</label>
            <select name="colores" id="colores">
            </select>
        </div>
        <div id="tallasProd">
            <label for="tallas">TALLAS</label>
            <select name="tallas" id="tallas">
            </select>
        </div>
        <div id="cantidadProd">
            <label for="cantidad">Unidades</label>
            <input type="number" id="cantidad" name="cantidad">
        </div>

        <button onclick="addToCart()">Añadir al carrito</button>
    </div>

    <script src="../../javascript/script-filtro-producto.js"></script>
</body>
</html>