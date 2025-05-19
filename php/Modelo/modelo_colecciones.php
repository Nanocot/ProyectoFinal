<?php


    require_once "conexion.php";


    class ModeloColecciones{

        private  $conex;


        public function __construct(){
            $this->conex = ModeloConexion::conectar();
        }

        //Función para sacar todas las colecciones
        public function sacarColecciones(){

            try{
                $sql = "select id, nombre from colecciones";

                $stmt = $this->conex->prepare($sql);

                if($stmt->execute()){
                    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    return $resultado;
                }else{
                    return false;
                }


            }catch(PDOException $e){
                return $e->getMessage();
            }



        }


    }