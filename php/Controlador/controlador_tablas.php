<?php

    require_once "php/Modelo/modelo_productos.php";
    require_once "php/Modelo/modelo_usuarios.php";

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

    }

?>