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
    <link rel="stylesheet" href="../estilos/estilosgestion.css">

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

    <div class="add"><a href="index.php?action=addProduct">Añadir nuevo producto</a></div>

    <table>
        <thead>
            <th>Foto</th>
            <th>Nombre</th>
            <th>Tallas</th>
            <th>Categoria</th>
            <th>Colección</th>
            <th>Eliminar</th>
        </thead>
        <tbody>
            <?php foreach($datosTabla as $producto):?>
                <tr>
                    <td>
                        <a href="index.php?action=modificarProducto&id=<?=$producto["ID"]?>&categoria=<?=$producto["Categoria"]?>">
                            <img src="<?= $producto["Foto"]?>" alt="Foto del producto <?= $producto["ID"]?>">
                        </a>
                    </td>
                    <td><?= $producto["Nombre"]?></td>
                    <td><?= $producto["Tallas"]?></td>
                    <td><?= $producto["Categoria"]?></td>
                    <td><?= $producto["Coleccion"]?></td>
                    <td class="eliminar">&times;</td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    

<script type="text/javascript" src="javascript/script-funciones-gestion.js"></script>

    
</body>
</html>