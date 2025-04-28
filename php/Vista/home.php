<?php 
    //Comprobamos que si la sesión está iniciada, para evitar que el usuario haga un uso indebido de la página
    if(!isset($_SESSION)){
        header("Location: ../../index.php?action=home");
        exit();
    }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/estiloprincipal.css">
    <title>Farko</title>
</head>
<body>
    

    <header>
        <a href="#">
            <img src="../imagenes/Farko-logo-pequenio.png" alt="logo de farko">
        </a>
        <nav>
            <ul>
                <li><a href="index.php?action=usuario">Usuario</a></li>
                <li><a href="index.php?action=carrito">Carrito</a></li>
                <li><a href="index.php?action=aboutus">Sobre Nosotros</a></li>
            </ul>
        </nav>
    </header>

    
    <div class="productos">
        <!-- Generamos los productos -->
        <?php foreach($productos as $producto):?>
            <div class="producto">    
                <img src="" alt="" width=250px height=250px class="imagenProd">
                <div class="nombreProd"><?php echo $producto['Nombre'] ?></div>
                <div class="precioProd"><?php echo $producto['Precio'] ?></div>
            </div>
        <?php endforeach?>
    </div>
    

</body>
</html>