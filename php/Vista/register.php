<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/estiloprincipal.css">
    <link rel="stylesheet" href="estilos/estiloregister.css">
    <title>Farko</title>
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
                <li><a href="index.php?action=carrito">Carrito</a></li>
                <li><a href="index.php?action=aboutus">Sobre Nosotros</a></li>
            </ul>
        </nav>
    </header>

    <form action="" method="post">
        <h1>Registro de nuevos usuarios</h1>
        <label for="nombre">Nombre *</label>
        <input type="text" name="nombre" id="nombre" required>
        <label for="apellido1">Primer Apellido *</label>
        <input type="text" name="apellido1" id="apellido1" required>
        <label for="apellido2">Segundo Apellido</label>
        <input type="text" name="apellido2" id="apellido2">
        <label for="email">Email *</label>
        <input type="email" name="email" id="email" required>
        <label for="password1">Contraseña *</label>
        <input type="password" name="password1" id="password1" required>
        <label for="password2">Repita la Contraseña *</label>
        <input type="password" name="password2" id="password2" required>
        <label for="phonenumber">Número de Teléfono</label>
        <input type="tel" name="phonenumber" id="phonenumber">
        <label for="newsletter">¿Desea recibir correos con las novedades?</label>
        <input type="checkbox" name="newsletter" id="newsletter">
        <button type="submit">Enviar</button>
    </form>


</body>
</html>