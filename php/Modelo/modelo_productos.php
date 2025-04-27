<?php 

    require_once "conexion.php";


    class ModeloProductos{
        //Atributo
        private $conex = ModeloConexion::conectar();
    
        //Método para mostrar todos los productos
        public function mostrarProductos(){
            $sql = "select * from productos";

        }
    
    
    }

