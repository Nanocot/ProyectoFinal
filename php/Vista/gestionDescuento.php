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
    <link rel="stylesheet" href="../estilos/estilosgestion3.css">

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
        <div class="enlaceVuelta"><a href="index.php?action=dashboard">Volver atrás</a></div>
        <div class="add">Crear Descuento</div>
    </div>

    <table>
        <thead>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Fecha Inicio</th>
            <th>Fecha Final</th>
            <th>Cantidad</th>
            <th>Tipo</th>
            <th>Eliminar</th>
        </thead>
        <tbody>
            <?php foreach($datos as $descuento):?>
                <tr data-id="<?= $descuento["Id"]?>">
                    <td><input type="text" name="nombre" id="nombre-<?= $descuento["Id"]?>" value="<?= $descuento["Nombre"]?>"></td>
                    <td><textarea name="descripcion" id="desc-<?= $descuento["Nombre"]?>"><?= $descuento["Descripcion"]?></textarea></td>
                    <td><input type="date" name="fechaIni" id="fechaIni-<?=$descuento["Nombre"]?>" value="<?= $descuento["FechaIni"]?>"></td>
                    <td><input type="date" name="fechaFin" id="fechaFin-<?=$descuento["Nombre"]?>" value="<?= $descuento["FechaFin"]?>"></td>
                    <td><input type="number" name="cantidad" id="cantidad-<?=$descuento["Nombre"]?>" value="<?= $descuento["Cantidad"]?>" step="1" min="0"></td>
                    <td>
                        <select name="tipo" id="tipo-<?=$descuento["Nombre"]?>">
                            <option value="" disabled>Elija una</option>
                            <?php if($descuento["Tipo"] == "cantidad"):?>
                                <option value="cantidad" selected>Cantidad</option>
                                <option value="porcentaje">Porcentaje</option>
                            <?php else:?>
                                <option value="cantidad">Cantidad</option>
                                <option value="porcentaje" selected>Porcentaje</option>
                            <?php endif;?>
                        </select>
                    </td>
                    <td class="eliminar">&times;</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    

<script type="text/javascript" src="javascript/script-funciones-gestion-descuentos.js"></script>
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


    <div class="addDescuento">
        <div class="nuevoDescuento">
            <div class="nombreDescp">
                <span class="titulo">Nombre *</span>
                <input type="text" name="nuevoNombre" id="nuevoNombre" placeholder="Escriba el nombre aquí" required>
                <span class="titulo">Descripción *</span>
                <textarea name="nuevaDesc" id="nuevaDesc" placeholder="Escriba aqui la descripción"></textarea>
            </div>
            <div class="fechasCantidadTipo">
                <span class="titulo">Fecha Inicio *</span>
                <input type="date" name="nuevoInicio" id="nuevoInicio" required>
                <span class="titulo">Fecha Fin *</span>
                <input type="date" name="nuevoFin" id="nuevoFin" required>
                <span class="titulo">Cantidad *</span>
                <input type="number" name="nuevaCantidad" id="nuevaCantidad" min="0" value="0" required>
                <span class="titulo">Tipo *</span>
                <select name="nuevoTipo" id="nuevoTipo">
                    <option value="" disabled selected required>Elija uno</option>
                    <option value="cantidad">Cantidad</option>
                    <option value="porcentaje">Porcentaje</option>
                </select>
            </div>
            <div class="nuevoDesBotones">
                <button id="cancelar2" class="cancelar">Cancelar</button>
                <button id="guardar2" class="guardar">Guardar</button>
            </div>
        </div>
    </div>



</body>
</html>