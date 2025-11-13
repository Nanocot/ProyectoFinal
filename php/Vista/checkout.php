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
            <!-- Campo de número de tarjeta -->
            <div>
                <label for="numeroTar">Número de Tarjeta</label>
                <input type="text" id="numeroTar" placeholder="0000 0000 0000 0000" maxlength="19" required>
            </div>

            <!-- Campo de nombre del titular -->
            <div>
                <label for="nombreTitu">Nombre del Titular</label>
                <input type="text" id="nombreTitu" placeholder="Nombre completo" required>
            </div>

            <div>
                <!-- Campo de fecha de vencimiento -->
                <div>
                    <label for="expiryDate">Fecha de Caducidad</label>
                    <input type="text" id="expiryDate" placeholder="MM/AA" maxlength="5" required>
                </div>

                <!-- Campo de CVV -->
                <div>
                    <label for="cvv">CVV</label>
                    <input type="text" id="cvv" placeholder="123" maxlength="4" required>
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