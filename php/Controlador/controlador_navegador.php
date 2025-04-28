<?php


    //Clase para controlar el uso del navegador de la página
    class ControladorNavegador{

        public function aboutUs(){
            require_once "php/Vista/aboutus.php";
        }

        public function usuario(){
            require_once "php/Vista/login.php";
        }

        public function err404(){
            require_once "php/Vista/err404.php";
        }
    }