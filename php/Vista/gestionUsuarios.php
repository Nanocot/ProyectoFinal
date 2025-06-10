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
    <link rel="stylesheet" href="../estilos/estilosgestion.css">

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



    <table>
        <thead>
            <th>Email</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Teléfono</th>
            <th>Estado</th>
            <th>NewsLetter</th>
        </thead>
        <tbody>
            <?php foreach($respuesta as $usuario): ?>
                <?php 
                    switch($usuario["newsletter"]){
                            case "1":
                                $newsletter = "Suscrito";
                                break;
                            case "0":
                                $newsletter = "No Suscrito";
                                break;
                        }
                    switch ($usuario["estado"]){
                        case "1":
                                $estado = "Activo";
                            break;
                        case "0":
                                $estado = "Desactivado";
                            break;
                    }    
                ?>
                <tr>
                    <td>
                        <form action='index.php?action=gestionUsuario' method='post'>
                            <input type='hidden' name='usuario' id='usuario' value='<?=$usuario["email"]?>'>
                            <button type='submit'>
                                <?=$usuario["email"] ?>
                            </button>
                        </form>
                    </td>
                    <td><?=$usuario["nombre"]?></td>
                    <td><?=$usuario["apellido1"]?> <?=$usuario["apellido2"]?></td>
                    <td><?=$usuario["telefono"]?></td>
                    <td><?=$estado?></td>
                    <td><?=$newsletter?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    
</body>
</html>