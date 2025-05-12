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

        public function volcarApi(){
            //Creamos el objeto modelo
            $modeloProducto = new ModeloProductos();
            
            //Recuperamos el id y la categoria del producto
            $idProd = $_GET["id"];
            $categoriaProd = $_GET["categoria"];

            //Generamos el JSON con el producto indicado
            $detallesProd = $modeloProducto->generarJSON($idProd, $categoriaProd);

            //Cambiamos la cabecera para indicar que vamos a mandar un JSON
            header("Content-Type: application/json");
            
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

?>