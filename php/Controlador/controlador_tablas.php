<?php

    require_once "php/Modelo/modelo_productos.php";
    require_once "php/Modelo/modelo_usuarios.php";
    require_once "php/Modelo/modelo_carrito.php";

    class ControladorTablas {

        public function home(){

            $modeloProd = new ModeloProductos();

            $productos = $modeloProd->mostrarProductosHome();

            require_once "php/Vista/home.php";
        }


        public function register(){
            $modeloUsuarios = new ModeloUsuarios();

            if($_SERVER["REQUEST_METHOD"] == "POST"){
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


        public function producto(){
                        // //Creamos el objeto modelo
                        // $modeloProducto = new ModeloProductos();
            
                        // //Recuperamos el id del producto
                        // $idProd = $_GET["id"];
            
                        // $detallesProd = $modeloProducto->generarJSON($idProd);


                        // print_r($detallesProd);


            //Declaramos las variables
            // $filtro = [];
            // $talla = "";
            // $tallaColor = [];

            // print_r($tallaColor);

            //Creamos el objeto modelo
            // $modeloProducto = new ModeloProductos();
            
            //Recuperamos el id del producto
            // $idProd = $_GET["id"];

            // $detallesProd = $modeloProducto->mostrarProducto($idProd);

            //Mostrar los detalles
            // foreach($detallesProd as $producto){
            //     print_r($producto);
            //     echo "<br>";
            // }

            //Guardar los colores disponibles por talla
            // foreach($detallesProd as $producto){
            //     //Comprobamos que la talla es distinta
            //     if($talla != $producto["Tallas"]){
            //         $talla = $producto["Tallas"];
            //     }
            //     //Sacamos los colores del producto
            //     $colores = [$producto["ColorPatron"], $producto["ColorBase"]];
            //     //Comprobamos si la talla existe dentro del array 
            //     if(!isset($tallaColor[$talla])){
            //         //Guardamos los colores dentro la talla
            //         $tallaColor += [$talla => $colores];
            //         // echo "a<br>";
            //     }else{
            //         //Cuando la talla ya está creada añadimos los colores a la talla
            //         //Los pares son colorPatron y los impares ColorBase
            //         array_push($tallaColor[$talla], $colores[0], $colores[1]);
            //         print_r($tallaColor[$talla]);
            //         echo "<br>";
            //     }
            // }

            // print_r($tallaColor);

            // $modeloProducto = new ModeloProductos();
            
            // //Recuperamos el id del producto
            // $idProd = $_GET["id"];
            // $categoriaProd = $_GET["categoria"];

            // $detallesProd = $modeloProducto->generarJSON($idProd, $categoriaProd);

            // $detallesProd = json_decode($detallesProd);
            
            require_once "php/Vista/producto.php";
            
        }

        public function volcarApi(){
            //Creamos el objeto modelo
            $modeloProducto = new ModeloProductos();
            
            //Recuperamos el id del producto
            $idProd = $_GET["id"];
            $categoriaProd = $_GET["categoria"];

            $detallesProd = $modeloProducto->generarJSON($idProd, $categoriaProd);

            header("Content-Type: application/json");
            
            echo $detallesProd;
        
        }

        public function  generarCarrito(){
            $modeloCarrito = new ModeloCarrito();
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);


            $html = $modeloCarrito->mostrarCarrito($data);



            echo $html;
        }

        

    }

?>