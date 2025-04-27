<?php 


    class ModeloConexion{
        public static function conectar(){
            try{
                //Datos de conexión
                $dsn = "mysql:host=localhost;dbname=proyectofinal";
                $usuario = "Fernando";
                $password = "Fernando";
                //Iniciamos la conexión con la base de datos
                $conex = new PDO($dsn, $usuario, $password);
                $conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $conex;
            }catch(PDOException $pdoEx){
                die ("Conexión fallida: " . $pdoEx->getMessage());
            }
        }

    }


    // $conex = ModeloConexion::conectar();
    // if($conex){
    //     echo "Conexión exitosa";
    // }
?>