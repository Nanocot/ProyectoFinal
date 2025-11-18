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
            <span id="cuadReclamacion">
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
                <span><h2>Correo</h2><p id="email"><?= $_SESSION["usuario"]?></p></span>
                <span><h2>Nombre</h2><input type="text" name="nombre" id="nombre" value="<?= $datosUsuario["nombre"]?>"></span>
                <span><h2>Apellidos</h2><input type="text" name="apellidos" id="apellidos" value="<?= $datosUsuario["apellidos"]?>"></span>
                <button id="btnModDatos">Guardar</button>
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
            <h1>Historial de compras</h1>
            <div class="datos">

                <table>
                    <thead>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Método de Pago</th>
                        <th>Estado</th>
                    </thead>
                    <tbody>
                        <?php foreach($datosCompras as $compra):?>
                            <tr data-id="<?= $compra["Id"]?>">
                                <td><?= $compra["Fecha"]?></td>
                                <td><?= $compra["PrecioTotal"]?> €</td>
                                <td><?= $compra["MetodoPago"]?></td>
                                <td><?= $compra["EstadoPago"]?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="detalles">
                <div class="contenidoDetalles">
                    <span class="cerrarDetalles">&times;</span>
                    <div class="infoUser">
                        <h4>
                            Total Productos: <span class="totalProdus"></span>
                        </h4>
                    </div>
                    
                <h4>Detalles</h4>
                    <div class="tablaProdus">
                        
                        <table>
                            <thead>
                                <th>Nombre</th>
                                <th>Color</th>
                                <th>Talla</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                            </thead>
                            <tbody class="infoProdus">
                                </tbody>
                            </table>
                        </div>
                        <div class="precTotal"></div>        
                </div>
    </div>

        </div>
        <div id="reclamacion">
            <span class="cerrar">&times;</span>
            <h1>¿Cómo podemos ayudarle?</h1>
            <textarea name="textReclamacion" id="textReclamacion"></textarea>
            <button type="submit" id="enviarReclamacion">Enviar</button>
        </div>
    </div>
        
        



</body>
</html>