<?php

    require_once "php/Modelo/modelo_productos.php";
    require_once "php/Modelo/modelo_usuarios.php";
    require_once "php/Modelo/modelo_carrito.php";
    require_once "php/Modelo/modelo_colecciones.php";
    require_once "php/Modelo/modelo_descuento.php";
    require_once "php/Modelo/modelo_categorias.php";
    require_once "php/Modelo/modelo_tallas.php";

    class ControladorTablas {

        //Función para mostrar la página de home 
        public function home(){

            $modeloProd = new ModeloProductos();

            $productos = $modeloProd->mostrarProductosHome();

            require_once "php/Vista/home.php";
        }



        //Función para el registro de Usuarios
        public function register(){
            $modeloUsuarios = new ModeloUsuarios();
            //Comprobamos que el método de envio sea post
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                //Cogemos los datos necesarios para el registro de usuario
                $email = $_POST["email"];
                $nombre = $_POST["nombre"];
                $apellido1 = $_POST["apellido1"];
                $apellido2 = $_POST["apellido2"];
                $password = $_POST["password1"];
                $telefono = $_POST["phonenumber"];
                $estado = true;
                //Comprobamos que exista la celda de newsletter, en caso de que exista, significa que el usuario ha marcado la casilla, en caso contrario no la ha marcado
                $newsletter = isset($_POST["newsletter"]) ? true : false;

                $condicion = $modeloUsuarios->register($nombre, $apellido1, $apellido2, $email, $password, $telefono, $estado, $newsletter);

                if($condicion === true){
                    echo "usuario registrado con éxito";
                }else{
                    echo "No ha sido posible registrar el usuario: $condicion";
                }



            }

            require_once "php/Vista/register.php";
        }

        public function volcarApi(){
            //Creamos el objeto modelo
            $modeloProducto = new ModeloProductos();
            
            //Recuperamos el id y la categoria del producto
            $idProd = $_GET["id"];
            $categoriaProd = $_GET["categoria"];

            //Generamos el JSON con el producto indicado
            $detallesProd = $modeloProducto->generarJSON($idProd, $categoriaProd);

            //Cambiamos la cabecera para indicar que vamos a mandar un JSON
            // header("Content-Type: application/json");
            
            //Mandamos el JSON generado
            echo $detallesProd;
        
        }

        public function  generarCarrito(){
            //Creamos el modelo del carrito
            $modeloCarrito = new ModeloCarrito();

            //Guardamos el fichero JSON que recibimos
            $json = file_get_contents('php://input');
            //Convertimos el JSON a un array asociativo
            $data = json_decode($json, true);

            
            if($data["carrito"] != ""){

                //Limpiamos la cadena de caracteres especiales
                $cadenaLimpia =  preg_replace(["/{/", "/}/", "/\[/", "/\]/", "/\"/"],  "", $data["carrito"]);
                
                //Separamos los distintos atributos de los productos
                $datos = explode(",", $cadenaLimpia);
                
                //Llamamos a la función de mostrar Carrito
                $html = $modeloCarrito->mostrarCarrito($datos);
                
                
                
                // Mandamos el html al cliente para mostrarlo en la vista    
                echo $html;
            }
            
        }

        public function  gestionarUsuarios(){
            require_once "php/Vista/gestionUsuarios.php";

            $modeloUsuarios = new ModeloUsuarios();

            $respuesta = $modeloUsuarios->mostrarUsuarios();

            if(is_array($respuesta)){
                echo "<table>
                    <th>Email</th><th>Nombre</th><th>Apellidos</th><th>Teléfono</th><th>Estado</th><th>NewsLetter</th>
                ";
                    foreach($respuesta as $usuario){
                        switch($usuario["newsletter"]){
                            case "1":
                                $newsletter = "Suscrito";
                                break;
                            case "0":
                                $newsletter = "No Suscrito";
                                break;
                        }
                        switch ($usuario["estado"]){
                            case "1":
                                    $estado = "Activo";
                                break;
                            case "0":
                                    $estado = "Desactivado";
                                break;
                        }

                        echo "
                            <tr>
                                <td>
                                    <form action='index.php?action=gestionUsuario' method='post'>
                                        <input type='hidden' name='usuario' id='usuario' value='{$usuario["email"]}'>
                                        <button type='submit'>
                                            {$usuario["email"]}
                                        </button>
                                    </form>
                                </td>
                                <td>{$usuario["nombre"]}</td>
                                <td>{$usuario["apellido1"]} {$usuario["apellido2"]}</td>
                                <td>{$usuario["telefono"]}</td>
                                <td>{$estado}</td>
                                <td>{$newsletter}</td>
                            </tr>
                        ";
                    } 

                echo "</table>";
            }else{
                echo "<div class='error'>{$respuesta}</div>";
            }

            


        }


        public function  gestionUsuario(){

            $modeloUsuario = new ModeloUsuarios();

            $email = $_POST["usuario"];

            $datosUsuario = $modeloUsuario->sacarUsuario($email);

            if(is_array($datosUsuario)){
                switch($datosUsuario["newsletter"]){
                    case "1":
                        $newsletter = "Suscrito";
                        break;
                    case "0":
                        $newsletter = "No Suscrito";
                        break;
                }
                switch ($datosUsuario["estado"]){
                    case "1":
                        $estado = "Activo";
                        break;
                    case "0":
                        $estado = "Desactivado";
                        break;
                }
                require_once "php/Vista/modificarUsuario.php";

            }else{
                require_once "php/Vista/modificarUsuario.php";
                echo "<div class='error'>{$datosUsuario}</div>";
            }



        }

        public function cambiarEstado(){
            $modeloUsuarios = new ModeloUsuarios();

            //Guardamos el fichero JSON que recibimos
            $json = file_get_contents('php://input');
            //Convertimos el JSON a un array asociativo
            $data = json_decode($json, true);

            if($modeloUsuarios->modificarEstado($data["email"],$data["estado"])){
                $mensaje = "Usuario modificado con exito";
            }else{
                $mensaje = "No se ha podido modificar";
            }


            echo $mensaje;

        }

        //Función para mostrar la vista de gestión de productos
        public function gestionarProductos(){
            $modeloProductos = new ModeloProductos();

            $datosTabla = $modeloProductos->generarDatosTabla();

            if($datosTabla){
                require_once "php/Vista/gestionProductos.php";
            }else{
                require_once "php/Vista/error404.php";
            }



        }

        //Función para sacar la vista de modificar un producto en especifico
        public function modificarProducto(){
            //Declaración de variables
            $modeloProductos = new ModeloProductos();
            $modeloDescuentos = new ModeloDescuento();
            $modeloCategorias = new ModeloCategorias();
            $modeloColecciones = new ModeloColecciones();

            //Guardamos el id y la categoria
            $id = $_GET["id"];
            $categoria = $_GET["categoria"];


            //Sacamos los datos necesarios para rellenar la tarjeta del producto
            $producto = $modeloProductos->sacarDatosMod($id, $categoria);
            $descuentos = $modeloDescuentos->sacarDescuentos();
            $categorias = $modeloCategorias->sacarCategorias();
            $colecciones = $modeloColecciones->sacarColecciones();
            $stockColores = $modeloProductos->sacarStock($id);

            require_once "php/Vista/modificarProducto.php";
        }
    
    

        public function actualizarProducto(){
            $modeloProducto = new ModeloProductos();
            $datos = file_get_contents("php://input");
            
            $arrayDatos = json_decode($datos, true);
            
            
            $respuesta = $modeloProducto->modificarProducto($arrayDatos);
            
            echo $respuesta;
        }



        public function addProduct(){
            $modeloProductos = new ModeloProductos();
            $modeloDescuentos = new ModeloDescuento();
            $modeloCategorias = new ModeloCategorias();
            $modeloColecciones = new ModeloColecciones();
            $modeloTallas = new ModeloTallas();

            $descuentos = $modeloDescuentos->sacarDescuentos();
            $categorias = $modeloCategorias->sacarCategorias();
            $colecciones = $modeloColecciones->sacarColecciones();
            $tallas = $modeloTallas->sacarTallas();


            require "php/Vista/addProduct.php";


        }



        public function addProducto(){
            $modeloProducto = new ModeloProductos();
            $datos = file_get_contents("php://input");
            
            $arrayDatos = json_decode($datos, true);
            
            
            $respuesta = $modeloProducto->addProduct($arrayDatos);
            // print_r($arrayDatos);
            print_r($respuesta);
        }


        public function eliminarProd(){
            $modeloProducto = new ModeloProductos();
            $datos = file_get_contents("php://input");

            $datosDecode = json_decode($datos, true);

            
            echo $modeloProducto->eliminarProd($datosDecode);

        }



        public function gestionarColecciones(){

            $modeloColecciones = new ModeloColecciones();

            $datos = $modeloColecciones->datosTabla();


            require_once "php/Vista/gestionColecciones.php";
        }


        public function eliminarColeccion(){
            $modeloColecciones = new ModeloColecciones();

            $id = file_get_contents("php://input");

            $mensaje = $modeloColecciones->eliminarColeccion($id);

            echo $mensaje;

        }



        public function actualizarColeccion(){
            $modeloColecciones = new ModeloColecciones();

            $datosRecibidos = file_get_contents("php://input");

            $datosDecode = json_decode($datosRecibidos, true);

            $mensaje = $modeloColecciones->actualizarColeccion($datosDecode);

            echo $mensaje;

        }


        public function crearColeccion(){
            $modeloColecciones = new ModeloColecciones();

            $datosRecibidos = file_get_contents("php://input");

            $datosDecode = json_decode($datosRecibidos, true);




            $mensaje = $modeloColecciones->crearColeccion($datosDecode);

            header("Content-Type: application/json");
            echo json_encode($mensaje);

        }


        public function gestionarDescuentos(){
            $modeloDescuentos = new ModeloDescuento();  

            $datos  = $modeloDescuentos->generarTabla();


            require_once "php/Vista/gestionDescuento.php";
        }


        public function crearDescuento(){

            $modeloDescuentos = new ModeloDescuento();

            $datos = file_get_contents("php://input");

            $datosDecode = json_decode($datos, true);

            $resultado = $modeloDescuentos->crearDescuento($datosDecode);

            header("Content-Type: application/json");
            echo json_encode($resultado);
        }


        public function eliminarDescuento(){
            $modeloDescuentos = new ModeloDescuento();

            $datos = file_get_contents("php://input");

            $datosDecode = json_decode($datos, true);

            $resultado = $modeloDescuentos->borrarDescuento($datosDecode);

            echo $resultado;
        }


        public function actualizarDescuento(){
            $modeloDescuentos = new ModeloDescuento();

            $datos = file_get_contents("php://input");

            $datosDecode = json_decode($datos, true);

            $resultado = $modeloDescuentos->actualizarDescuento($datosDecode);

            echo $resultado;
        }






    
    }




?>