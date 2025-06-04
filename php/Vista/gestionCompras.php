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
    <link rel="stylesheet" href="../estilos/estilosgestion4.css">

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

    <div class="botones">
        <div class="enlaceVuelta"><a href="index.php?action=dashboard">Volver</a></div>
    </div>
        

    <div class="datos">

        <table>
            <thead>
                <th>Fecha</th>
                <th>Usuario</th>
                <th>Total</th>
                <th>Método de Pago</th>
                <th>Estado</th>
            </thead>
            <tbody>
                <?php foreach($datos as $compra):?>
                    <tr data-id="<?= $compra["Id"]?>">
                        <td><?= $compra["Fecha"]?></td>
                        <td><?= $compra["email"]?></td>
                        <td><?= $compra["PrecioTotal"]?> €</td>
                        <td><?= $compra["MetodoPago"]?></td>
                        <td><?= $compra["EstadoPago"]?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
            
    

<script type="text/javascript" src="javascript/script-funciones-gestion-compras.js"></script>
<script type="text/javascript" src="javascript/script-funciones-genericas.js"></script>


    <div class="detalles">
        <div class="contenidoDetalles">

            <div class="infoUser">
                <span>
                    Compra Nº: 
                    <span class="numero"></span>
                </span>
                <span>
                    Estado del Pago: <select name="estado" id="estado">
                        <option value="" disabled selected>Elija Una</option>
                        <option value="pagada">Pagada</option>
                        <option value="pendiente">Pendiente</option>
                        <option value="rechazada">Rechazada</option>
                    </select>
                </span>
                <span>
                    Usuario: 
                    <span class="emailUsuario"></span>
                </span>
                <span>
                    Total Productos: <span class="totalProdus"></span>
                </span>
            </div>
            
            <h4>Detalles</h4>
            <table class="tablaProdus">
                <thead>
                    <th>Nombre</th>
                    <th>Color</th>
                    <th>Cantidad</th>
                    <th>Talla</th>
                    <th>Precio</th>
                </thead>
                <tbody class="infoProdus">
                </tbody>
            </table>
            <div class="precTotal"></div>        
        </div>
    </div>



</body>
</html>