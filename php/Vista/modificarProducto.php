<?php 
    if(!isset($_SESSION["usuario"]) || !isset($_SESSION) || $_SESSION["usuario"] != "Administrador"){
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
    <link rel="stylesheet" href="../estilos/estilomodproduct.css">

</head>
<body>
    
     <header>
        <a href="index.php?action=home">
            <img src="../imagenes/Farko-logo-pequenio.png" alt="logo de farko">
        </a>
        <nav>
            <ul>
                <li><a href="index.php?action=home">Home</a></li>
                <li><a href="index.php?action=dashboard">DashBoard</a></li>
            </ul>
        </nav>
    </header>

    <div class="enlaceVuelta"><a href="index.php?action=gestionarProductos">Volver atrás</a></div>


    <div class="producto">
        <div class="titulos"><h2>Imagenes</h2><h2>Información</h2></div>
        <div class="fotos">
            <?php foreach($producto["Fotos"] as $imagen):?>
                <div class="imagenProducto">
                    <span class="eliminar">&times;</span>
                    <img src="<?= $imagen?>" alt="foto producto <?= $producto["Datos"]["Nombre"]?>">
                </div>
            <?php endforeach; ?>
        </div>
        <div class="informacion">
            <div class="nombre">
                <p>Nombre:</p>
                <input type="text" value="<?= $producto["Datos"]["Nombre"]?>">
            </div>
            <div class="categoria ">
                <p>Categoria:</p>
                <select name="categoria" id="categoria">
                    <?php foreach($categorias as $categoria):?>
                        <?php if($categoria["nombre"] == $producto["Datos"]["Categoria"]):?>
                            <option value="<?=$categoria["id"]?>" selected><?=$categoria["nombre"]?></option>
                        <?php else: ?>
                            <option value="<?=$categoria["id"]?>"><?=$categoria["nombre"]?></option>
                        <?php endif; ?>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="coleccion">
                <p>Coleccion</p>
                <select name="coleccion" id="coleccion">
                    <?php foreach($colecciones as $coleccion):?>
                        <?php if($coleccion["nombre"] == $producto["Datos"]["Coleccion"]):?>
                            <option value="<?=$coleccion["id"]?>" selected><?=$coleccion["nombre"]?></option>
                        <?php else: ?>
                            <option value="<?=$coleccion["id"]?>"><?=$coleccion["nombre"]?></option>
                        <?php endif; ?>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="precio">
                <p>Precio:</p>
                <input type="number" name="precio" id="precio" min="0" value="<?= $producto["Datos"]["Precio"]?>" step="0.01">
            </div>
            <div class="descuento">
                <p>Descuento:</p>
                <select name="Descuento" id="descuento">
                    <?php foreach($descuentos as $descuento):?>
                        <?php if($descuento["id"] == $producto["Datos"]["Descuento"]):?>
                            <option value="<?=$descuento["id"]?>" selected><?=$descuento["Nombre"]?></option>
                        <?php else:?>
                            <option value="<?=$descuento["id"]?>"><?=$descuento["nombre"]?></option>
                        <?php endif;?>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="colores">
                <div class="colDisponibles">
                    <ul>
                    
                    </ul>
                </div>
                <div class="addcolor"></div>
            </div>
            <div class="stock"></div>
            <div class="descripcion"></div>
        </div>
    </div>

    <div class="aplicarCambios">Aplicar cambios</div>


    <pre>
        <?php print_r($producto)?>
    </pre>

    

    <script type="text/javascript" src="../../javascript/script-funciones-genericas.js"></script>
    <script type="text/javascript" src="../../javascript/script-modificar-producto.js"></script>
    
</body>
</html>