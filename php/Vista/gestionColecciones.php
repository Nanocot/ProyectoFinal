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
    <link rel="stylesheet" href="../estilos/estilosgestion2.css">

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
        <div class="enlaceVuelta"><a href="index.php?action=dashboard">Volver</a></div>
        <div class="add">Añadir nueva Colección</div>
    </div>
        

    <table>
        <thead>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Eliminar</th>
        </thead>
        <tbody>
            <?php foreach($datos as $coleccion):?>
                <tr data-id="<?= $coleccion["Id"]?>">
                    <td><input type="text" name="nombre" id="nombre-<?= $coleccion["Id"]?>" value="<?= $coleccion["Nombre"]?>"></td>
                    <td><textarea name="descripcion" id="desc-<?= $coleccion["Nombre"]?>"><?= $coleccion["Descripcion"]?></textarea></td>
                    <td class="eliminar">&times;</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    

<script type="text/javascript" src="javascript/script-funciones-gestion-colecciones.js"></script>
<script type="text/javascript" src="javascript/script-funciones-genericas.js"></script>


    <div id="modificarDescp" class="modificarDescp">
        <div class="contenidoDescp">
            <h2>Editar Descripción</h2>
            <textarea id="modificarDescpTextarea"></textarea>
            <div class="modificarDescBotones">
                <button id="cancelar1" class="cancelar">Cancelar</button>
                <button id="guardar1" class="guardar">Guardar</button>
            </div>
        </div>
    </div>


    <div class="addColeccion">
        <div class="nuevaColeccion">
            <span class="titulo">Nombre</span>
            <input type="text" name="nuevoNombre" id="nuevoNombre" placeholder="Escriba el nombre aquí">
            <span class="titulo">Descripción</span>
            <textarea name="nuevaDesc" id="nuevaDesc"></textarea>
            <div class="nuevaColBotones">
                <button id="cancelar2" class="cancelar">Cancelar</button>
                <button id="guardar2" class="guardar">Guardar</button>
            </div>
        </div>
    </div>



</body>
</html>