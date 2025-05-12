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

    <div id="resultado" style="white-space: pre-wrap; font-family: monospace">
    </div>


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
    <?php if($_GET["categoria"] != "Accesorios"):?>
        <div id="tallasProd">
            <label for="tallas">TALLAS</label>
            <select name="tallas" id="tallas">
            </select>
        </div>
    <?php endif?>
        <div id="cantidadProd">
            <label for="cantidad">Unidades</label>
            <input type="number" id="cantidad" name="cantidad" value=1 min="1">
        </div>
        <div id="stock">Quedan: </div>
        <button onclick="addToCart()">Añadir al carrito</button>
    </div>
    

    <?php if($_GET["categoria"] != "Accesorios"):?>
        <script src="../../javascript/script-filtro-producto.js" type="text/javascript"></script>
    <?php else: ?>
            <script src="../../javascript/script-filtro-accesorios.js" type="text/javascript"></script>        
    <?php endif ?>
        <script src="../../javascript/script-funciones-genericas.js" type="text/javascript"></script>

</body>
</html>