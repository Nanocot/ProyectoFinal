<?php 

    require_once "conexion.php";


    class ModeloProductos{
        //Atributo conexión general para todo el fichero
        private $conex;

        public function __construct(){
            $this->conex = ModeloConexion::conectar();
        }
    
        //Método para mostrar todos los productos
        public function mostrarProductosHome(){
            //Preparamos la sentencia, para mostrar los datos en la página de inicio
            $sql = "select Nombre, Precio from productos";

            $stmt = $this->conex->prepare($sql);

            if($stmt->execute() && $stmt->rowCount() > 0){
                $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $productos;
            }
        }
    
    
    }

