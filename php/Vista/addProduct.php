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

    <div class="botones">
        <div class="enlaceVuelta"><a href="index.php?action=gestionarProductos">Volver atrás</a></div>
        <div class="btnAddFoto">Añadir foto</div>
    </div>

    <div class="producto">
        <div class="titulos"><h2>Imagenes</h2><h2>Información</h2></div>
        <div class="fotos">
            
        </div>
        <div class="informacion">
            <div class="nombre">
                <p>Nombre:</p>
                <input type="text" name="nombre" id="nombre" placeholder="Escriba aqui el nombre">
            </div>
            <div class="categoria ">
                <p>Categoria:</p>
                <select name="categoria" id="categoria">
                    <option disabled selected>Elija una</option>
                    <?php foreach($categorias as $fila):?>
                            <option value="<?=$fila["id"]?>"><?=$fila["nombre"]?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="coleccion">
                <p>Coleccion</p>
                <select name="coleccion" id="coleccion">
                    <option disabled selected>Elija una</option>
                    <?php foreach($colecciones as $coleccion):?>
                            <option value="<?=$coleccion["id"]?>"><?=$coleccion["nombre"]?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="precio">
                <p>Precio:</p>
                <input type="number" name="precio" id="precio" min="0" step="0.01" placeholder="Introduzca el precio">
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
                <h4>Colores por talla</h4>
                <div class="colDisponibles">
                    <?php foreach($tallas as $talla):?>
                        <span class="talla" id="talla-<?=$talla["Id"]?>">
                            <h4>Tallas <?=$talla["Nombre"]?></h4>
                            <ul>

                            </ul>
                        </span>    
                    <?php endforeach;?>
                </div>
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

                </ul>
            </div>
            <div class="descripcion">
                <h4>Descripción</h4>
                <textarea name="description" id="description" placeholder="Escriba aqui la descripción"></textarea>
            </div>
        </div>
    </div>
    
    <div class="addProducto">Añadir producto</div>


    <script type="text/javascript" src="../../javascript/script-funciones-genericas.js"></script>
    <script type="text/javascript" src="../../javascript/script-add-producto.js"></script>
    

    <div class="addColores">
        <span class="cerrarCuadro">&times;</span>
        <input type="radio" name="opcion" id="todas" value="1">
        <label for="todas">Todas las tallas</label>
        <input type="radio" name="opcion" id="algunas" value="2">
        <label for="algunas">Seleccione</label>
        <div class="algunasTallas">
            <?php foreach($tallas as  $talla): ?>
                <input type="checkbox" name="talla-<?= $talla["Nombre"]?>" id="<?=$talla["Id"]?>" value="<?= $talla["Nombre"]?>">
                <label for="talla-<?= $talla["Nombre"]?>">Talla <?= $talla["Nombre"]?></label>
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