<?php


    //Clase para controlar el uso del navegador de la página
    class ControladorNavegador{

        public function aboutUs(){
            require_once "php/Vista/aboutus.php";
        }

        public function usuario(){
            if(isset($_SESSION["usuario"]) && $_SESSION["usuario"] != "Administrador"){
                header("Location: index.php?action=paginausuario");
            }else{
                require_once "php/Vista/login.php";
            }
        }

        public function err404(){
            require_once "php/Vista/err404.php";
        }

        public function carrito(){
            require_once "php/Vista/carrito.php";
        }


        public function producto(){
            require_once "php/Vista/producto.php";
        }


        public function dashboard(){
            require_once "php/Vista/dashboard.php";
        }

        


    }