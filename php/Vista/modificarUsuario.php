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
    <link rel="stylesheet" href="../estilos/estilomoduser.css">

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

    <div class="enlaceVuelta"><a href="index.php?action=gestionarUsuarios">Volver atrás</a></div>


    <div class="usuario">
        <span class="datosUsuario">
            <h2>Datos Usuario</h2>
            <p>Nombre: <?= $datosUsuario["nombre"] ?></p>
            <p>Apellidos: <?= $datosUsuario["apellido1"]; $datosUsuario["apellido2"]?></p>
            <p>Correo: <?= $email?></p>
            <p>Teléfono: <?= $datosUsuario["telefono"] ?></p>
            <p>    
                <label for="estado">Estado</label>
                <select name="estado" id="estado">
                    <?php if($estado == "Activo"):?>
                        <option value="0">Desactivado</option>
                        <option value="1" selected>Activo</option>
                    <?php else:?>
                        <option value="0" selected>Desactivado</option>
                        <option value="1">Activo</option>
                    <?php endif;?>
                </select>
            </p>
            <p>NewLetter: <?= $newsletter ?></p>
        </span>
        <span class="direccionUsuario">
            <h2>Dirección Usuario</h2>
            <p>Poblacion: <?= $datosUsuario["poblacion"]?></p>
            <p>Código Postal: <?= $datosUsuario["codpostal"]?></p>
            <p>Número: <?= $datosUsuario["numero"]?></p>
            <p>Calle: <?= $datosUsuario["calle"]?></p>
            <p>Puerta: <?= $datosUsuario["puerta"]?></p>
            <p>Planta: <?= $datosUsuario["planta"]?></p>
        </span>
    </div>


    <button type="submit" name="enviar" onclick="aplicarCambios()">Aplicar cambios</button>

    <script type="text/javascript" src="../../javascript/script-funciones-genericas.js"></script>
    <script type="text/javascript" src="../../javascript/script-modificarUsuario.js"></script>
    
</body>
</html>