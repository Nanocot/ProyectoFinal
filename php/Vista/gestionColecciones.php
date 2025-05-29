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
    <link rel="stylesheet" href="../estilos/estilosgestion2.css">

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

    <div class="add">Añadir nueva Categoría</div>


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


    <div class="addCategoria">
        <div class="nuevaCategoria">
            <span class="titulo">Nombre</span>
            <input type="text" name="nuevoNombre" id="nuevoNombre" placeholder="Escriba el nombre aquí">
            <span class="titulo">Descripción</span>
            <textarea name="nuevaDesc" id="nuevaDesc"></textarea>
            <div class="nuevaCatBotones">
                <button id="cancelar2" class="cancelar">Cancelar</button>
                <button id="guardar2" class="guardar">Guardar</button>
            </div>
        </div>
    </div>



</body>
</html>