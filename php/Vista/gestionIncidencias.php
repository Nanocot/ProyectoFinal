<?php
if (!isset($_SESSION["usuario"]) || !isset($_SESSION) || $_SESSION["usuario"] != "Administrador") {
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
    <link rel="stylesheet" href="../estilos/estilosgestion5.css">

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
    </div>


    <table>
        <thead>
            <th>Motivo</th>
            <th>Descripcion</th>
            <th>Usuario</th>
            <th>Estado</th>
        </thead>
        <tbody>
            <?php foreach ($datos as $reclamacion): ?>
                <tr data-id="<?= $reclamacion["id"] ?>">
                    <td>
                        <p><?= $reclamacion["motivo"] ?></p>
                    </td>
                    <td>
                        <p><?= $reclamacion["descripcion"] ?></p>
                    </td>
                    <td>
                        <p><?= $reclamacion["emailusuario"] ?></p>
                    </td>
                    <td>
                        <select name="estado" id="estado<?= $reclamacion["id"] ?>">
                            <option value="pendiente" <?= ($reclamacion["estado"] == "pendiente") ? "selected" : "" ?>>Pendiente</option>
                            <option value="rechazada" <?= ($reclamacion["estado"] == "rechazada") ? "selected" : "" ?>>Rechazada</option>
                            <option value="cerrada" <?= ($reclamacion["estado"] == "cerrada") ? "selected" : "" ?>>Cerrada</option>
                        </select>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>



    <script type="text/javascript" src="javascript/script-funciones-genericas.js"></script>
    <script type="text/javascript" src="javascript/script-funciones-gestion-reclamaciones.js"></script>




</body>

</html>