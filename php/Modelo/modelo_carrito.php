<?php

    require_once "conexion.php";

    class ModeloCarrito{

        public function __construct(){
            $conex = ModeloConexion::conectar();
        }


        public function addCarrito(){

        }


        public function mostrarCarrito($jsonDecode){
            $html = "<h3>Contenido del Carrito:</h3><ul>";
        foreach ($jsonDecode as $item) {
            $html .= "<li>Producto: " . htmlspecialchars($item['nombre']) . ", Cantidad: " . htmlspecialchars($item['cantidad']) . "</li>";
        }
        $html .= "</ul>";
        return $html;
        }



    }
