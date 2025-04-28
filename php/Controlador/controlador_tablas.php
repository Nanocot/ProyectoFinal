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
        }

    }

?>