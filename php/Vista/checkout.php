<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../estilos/estiloprincipal.css">
    <link rel="stylesheet" href="../../estilos/estilocheckout.css">
    <title>FARKO</title>
</head>

<body>
    <header>
        <a href="index.php?action=home">
            <img src="../imagenes/Farko-logo-pequenio.png" alt="logo de farko">
        </a>
        <nav>
            <ul class="menu">
                <li><a href="index.php?action=home">Home</a></li>
                <li><a href="index.php?action=usuario">Usuario</a></li>
                <li><a href="index.php?action=aboutus">Sobre Nosotros</a></li>
            </ul>
        </nav>
    </header>


    <h1>Checkout</h1>


    <!-- Formulario de pago -->
    <form id="formularioPago">
        <div class="contenido">
            <div class="arriba">
                <div class="datosUsuario">
                    <h2>Datos Usuario</h2>
                    <label for="nombre">Nombre: *</label>
                    <input type="text" id="nombre" name="nombre" required>

                    <label for="apellidos">Apellidos: *</label>
                    <input type="text" id="apellidos" name="apellidos" required>

                    <label for="email">Correo Eléctronico: *</label>
                    <?php if(isset($_SESSION["usuario"])): ?>
                        <input type="text" id="email" name="email" value="<?= $_SESSION["usuario"] ?>" required>
                    <?php else: ?>
                        <input type="text" id="email" name="email" required>
                    <?php endif;?>
                
                </div>
            </div>
            <div class="abajo">

                <div class="direccion">
                    <h2>Datos Dirección</h2>
                    <label for="calle">Calle: *</label>
                    <input type="text" id="calle" name="calle" required>

                    <label for="numero">Número: *</label>
                    <input type="text" id="numero" name="numero" required>

                    <label for="planta">Planta: *</label>
                    <input type="text" id="planta" name="planta" required>

                    <label for="puerta">Puerta: *</label>
                    <input type="text" id="puerta" name="puerta" required>

                    <label for="poblacion">Poblacion: *</label>
                    <input type="text" id="poblacion" name="poblacion" required>

                    <label for="codPostal">Código Postal: *</label>
                    <input type="text" id="codPostal" name="codPostal" required>
                </div>


                <!-- Campo de número de tarjeta -->
                <div class="metodoPago">
                    <h2>Método de Pago</h2>

                    <div>
                        <label for="numeroTar">Número de Tarjeta *</label>
                        <input type="text" id="numeroTar" placeholder="0000 0000 0000 0000" maxlength="19" required>
                    </div>

                    <!-- Campo de nombre del titular -->
                    <div>
                        <label for="nombreTitu">Nombre del Titular *</label>
                        <input type="text" id="nombreTitu" placeholder="Nombre completo" required>
                    </div>

                    <div>
                        <!-- Campo de fecha de vencimiento -->
                        <div>
                            <label for="expiryDate">Fecha de Caducidad *</label>
                            <input type="text" id="expiryDate" placeholder="MM/AA" maxlength="5" required>
                        </div>

                        <!-- Campo de CVV -->
                        <div>
                            <label for="cvv">CVV *</label>
                            <input type="text" id="cvv" placeholder="123" maxlength="4" required>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- Botón de pago -->
        <button type="submit" id="btnPagar">
            <span>Pagar</span>
        </button>
    </form>


    <script src="../../javascript/script-funciones-genericas.js" type="text/javascript"></script>
    <script src="../../javascript/script-checkout.js" type="text/javascript"></script>

</body>

</html>