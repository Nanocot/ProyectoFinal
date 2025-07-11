<?php 
    if(!isset($_SESSION["usuario"]) || !isset($_SESSION) || $_SESSION["usuario"] != "Administrador"){
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
    <link rel="stylesheet" href="../estilos/estilomodproduct.css">

</head>
<body>
    
    <header>
        <a href="index.php?action=home">
            <img src="../imagenes/Farko-logo-pequenio.png" alt="logo de farko">
        </a>
        <nav>
            <ul class="menu">
                <li><a href="index.php?action=home">Home</a></li>
                <li><a href="index.php?action=dashboard">DashBoard</a>
                    <ul class="submenu">
                        <li><a href="index.php?action=gestionarUsuarios"><span class="gesUsuarios">Gestionar Usuarios</span></a></li>
                        <li><a href="index.php?action=gestionarProductos"><span class="gesProductos">Gestionar Productos</span></a></li>
                        <li><a href="index.php?action=gestionarColecciones"><span class="gesColecciones">Gestionar Colecciones</span></a></li>
                        <li><a href="index.php?action=gestionarDescuentos"><span class="gesDescuentos">Gestionar Descuentos</span></a></li>
                        <li><a href="index.php?action=gestionarCategorias"><span class="gesCategorias">Gestionar Categorías</span></a></li>
                        <li><a href="index.php?action=gestionarCompras"><span class="gesCompras">Gestionar Compras</span></a></li>
                        <li><a href="index.php?action=gestionarIncidencias"><span class="gesIncidencias">Gestionar Incidencias</span></a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>

    <div class="botones">
        <div class="enlaceVuelta"><a href="index.php?action=gestionarProductos">Volver atrás</a></div>
        <div class="btnAddFoto">Añadir foto</div>
    </div>

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
                <input type="text" value="<?= $producto["Datos"]["Nombre"]?>" name="nombre" id="nombre">
            </div>
            <div class="categoria ">
                <p>Categoria:</p>
                <select name="categoria" id="categoria">
                    <option disabled>Elija una</option>
                    <?php foreach($categorias as $fila):?>
                        <?php if($fila["nombre"] == $producto["Datos"]["Categoria"]):?>
                            <option value="<?=$fila["id"]?>" selected><?=$fila["nombre"]?></option>
                        <?php else: ?>
                            <option value="<?=$fila["id"]?>"><?=$fila["nombre"]?></option>
                        <?php endif; ?>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="coleccion">
                <p>Coleccion</p>
                <select name="coleccion" id="coleccion">
                    <option disabled>Elija una</option>
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
                <select name="Descuento" id="descuento" >
                    <option selected value="null">Sin Descuento</option>
                    <?php foreach($descuentos as $descuento):?>
                        <?php if($descuento["nombre"] === $producto["Datos"]["Descuento"]):?>
                            <option value="<?=$descuento["id"]?>" selected><?=$descuento["nombre"]?></option>
                        <?php else:?>
                            <option value="<?=$descuento["id"]?>"><?=$descuento["nombre"]?></option>
                        <?php endif;?>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="colores">
            <?php if($categoria != "Accesorios"):?>
                <h4>Colores por talla</h4>
                <div class="colDisponibles">
                    <?php foreach($producto["InfoTallas"] as $talla => $informacion):?>
                        <span class="talla" id="talla-<?=$informacion["ID"]?>">
                            <h4>Tallas <?=$talla?></h4>
                            <ul>
                                <?php foreach($informacion["Colores"] as $datos):?>
                                    <li><span class="color"><?=$datos["Color Patron"]?> y <?=$datos["Color Base"]?></span> <span class="quitarColorTalla">&times;</span></li>
                                <?php endforeach; ?>
                            </ul>
                        </span>    
                    <?php endforeach;?>
                </div>
            <?php endif;?>
                <div class="addcolor">
                    <h4>Añadir Colores</h4>
                    <form name="addColor">
                        <label for="colorPatron">Color Patron</label>
                        <input type="text" name="colorPatron" id="colorPatron">
                        <label for="colorBase">Color Base</label>
                        <input type="text" name="colorBase" id="colorBase">
                        <button type="submit" name="nuevoColor" id="nuevoColor">Añadir</button>
                    </form>
                </div>
            </div>
            <div class="stock">
                <span class="titulosStock"><h4>Colores</h4><h4>Stock</h4></span>
                <ul>
                    <?php foreach($stockColores as $fila):?>
                        <li><?=$fila["ColorPatron"] ?> y <?=$fila["ColorBase"]?> <span class="quitarColor">&times;</span> <input type="number" min="0" id="<?=$fila["ColorPatron"].$fila["ColorBase"]?>" value="<?=$fila["Stock"]?>"></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="descripcion">
                <h4>Descripción</h4>
                <textarea name="description" id="description"><?=$producto["Datos"]["Descripcion"]?></textarea>
            </div>
        </div>
    </div>
    
    <div class="aplicarCambios">Aplicar cambios</div>


    <script type="text/javascript" src="../../javascript/script-funciones-genericas.js"></script>
    <script type="text/javascript" src="../../javascript/script-modificar-producto.js"></script>
    

    <div class="addColores">
        <span class="cerrarCuadro">&times;</span>
        <input type="radio" name="opcion" id="todas" value="1">
        <label for="todas">Todas las tallas</label>
        <input type="radio" name="opcion" id="algunas" value="2">
        <label for="algunas">Seleccione</label>
        <div class="algunasTallas">
            <?php foreach($producto["InfoTallas"] as $indice => $fila): ?>
                <input type="checkbox" name="talla-<?= $indice?>" id="<?=$fila["ID"]?>" value="<?= $indice?>">
                <label for="talla-<?= $indice?>">Talla <?= $indice?></label>
            <?php endforeach; ?>
        </div>
        <button id="addColor">Añadir Color</button>
    </div>



    <div class="addFoto">
        <span class="cerrarCuadro">&times;</span>
        <h4>Añadir Foto</h4>
        <span class="nuevaFoto">
            <form enctype="multipart/form-data" class="formAddFoto">
                <label for="imageUpload">Selecciona una imagen:</label>
                <input type="file" id="fotoSubida" name="fotoSubida" accept="image/*" class="subidaFoto">
                <div class="previsualizacion"><img id="previsualizacion" src="#" alt="Previsualización de la imagen"></div>
                <button type="submit" id="subirFoto">Subir Imagen</button>
            </form>
        </span>
        <span class="colorFoto">
        </span>

    </div>



</body>
</html>