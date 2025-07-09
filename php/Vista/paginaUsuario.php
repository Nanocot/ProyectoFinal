<?php 
    if(!isset($_SESSION["usuario"]) || !isset($_SESSION)){
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
    <link rel="stylesheet" href="../estilos/estilousuario.css">

</head>
<body>
    
     <header>
        <a href="index.php?action=home">
            <img src="../imagenes/Farko-logo-pequenio.png" alt="logo de farko">
        </a>
        <nav>
            <ul class="menu">
                <li><a href="index.php?action=home">Home</a></li>
                <li><a href="index.php?action=carrito">Carrito</a></li>
                <li><a href="index.php?action=aboutus">Sobre Nosotros</a></li>
            </ul>
        </nav>
    </header>

    <span class="email">
        <!-- <label for="email">Email</label>
        <input type="email" name="email" id="email" readonly value="<?= $_SESSION["usuario"] ?>"> -->
        <h1>Bienvenido <?= $datosUsuario["nombre"]?></h1>
    </span>


    <div class="datosUsuario">
        <span class="botonesUsuario">
            <span id="modificarPerfil">
                Modificar Perfil
            </span>
            <span id="historialCompras">
                Mirar Historial de compras
            </span>
            <span id="realizarReclamacion">
                Realizar Reclamación
            </span>

        </span>
    </div>

     <button type="submit" onclick="cerrarSesion()">Cerrar sesion</button>

    <script type="text/javascript" src="javascript/script-funciones-usuario.js"></script>
    <script type="text/javascript" src="javascript/script-funciones-genericas.js"></script>




    <div class="cuadrosDialogo">
        <div id="perfil">
            <span class="cerrar">&times;</span>
            <h1>Modificación del perfil</h1>

            <span class="informacionPersonal">
                <span><h2>Nombre</h2><input type="text" name="nombre" id="nombre" value="<?= $datosUsuario["nombre"]?>"></span>
                <span><h2>Apellidos</h2><input type="text" name="nombre" id="nombre" value="<?= $datosUsuario["apellidos"]?>"></span>
            </span>
            <span class="direccion">
                <button class="btnDireccion" id="btnDireccion">
                    Modificar Dirección <span class="flecha-desp">▼</span>
                </button>
                <span class="datosDireccion">
                    <form data-id="<?= $datosUsuario["id"] ?>" id="datosCliente">
                        <div class="formulario">
                            <label for="calle">Calle:</label>
                            <input type="text" id="calle" name="calle" value="<?= $datosUsuario["calle"] ?>">
                        </div>
                        <div class="formulario">
                            <label for="numero">Número:</label>
                            <input type="text" id="numero" name="numero" value="<?= $datosUsuario["numero"] ?>">
                        </div>
                        <div class="formulario">
                            <label for="planta">Planta:</label>
                            <input type="text" id="planta" name="planta" value="<?= $datosUsuario["planta"] ?>">
                        </div>
                        <div class="formulario">
                            <label for="puerta">Puerta:</label>
                            <input type="text" id="puerta" name="puerta" value="<?= $datosUsuario["puerta"] ?>">
                        </div>
                        <div class="formulario">
                            <label for="poblacion">Poblacion:</label>
                            <input type="text" id="poblacion" name="poblacion" value="<?= $datosUsuario["poblacion"] ?>">
                        </div>
                        <div class="formulario">
                            <label for="codPostal">Código Postal:</label>
                            <input type="text" id="codPostal" name="codPostal" value="<?= $datosUsuario["codPostal"] ?>">
                        </div>
                        <div class="formulario">
                            <button type="submit" id="guardar">Guardar Dirección</button>
                        </div>
                    </form>
                </span>
            </span>
                



        </div>
        <div id="historial">
            <span class="cerrar">&times;</span>
            <h1>Cuadro de texto de historial</h1>
        </div>
        <div id="reclamacion">
            <span class="cerrar">&times;</span>
            <h1>Cuadro de texto de reclamaciones</h1>
        </div>
    </div>
        
        



</body>
</html>