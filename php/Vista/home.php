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
    <link rel="stylesheet" href="../estilos/estilohome.css">
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
            <a href="index.php?action=producto&id=<?php echo $producto["Id"]?>&categoria=<?php echo $producto["Categoria"]?>">        
                <div class="producto">
                    <img src="<?=$producto["Foto"]?>" alt="Foto del producto<?=$producto["Nombre"]?>"class="imagenProd">
                    <div class="nombreProd"><?php echo $producto['Nombre'] ?></div>
                    <div class="precioProd"><?php echo $producto['Precio'] ?></div>
                </div>
            </a>    
        <?php endforeach?>
    </div>
    

</body>
</html>