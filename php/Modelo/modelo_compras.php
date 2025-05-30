<?php

    require_once "conexion.php";


    class ModeloCompras{


        private $conex;

        public function __construct(){
            $this->conex = ModeloConexion::conectar();
        }


        public function generarTabla(){

            try{
                $sql = "select * from compras";

                $stmt = $this->conex->prepare($sql);

                if($stmt->execute()){
                    $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    return $datos;
                }else{
                    return false;
                }


            }catch(PDOException $e){
                return $e->getMessage();
            }



        }


    }