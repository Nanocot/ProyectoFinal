<?php


    require_once "conexion.php";

    class ModeloTallas{

        private $conex;


        public function __construct(){
            $this->conex = ModeloConexion::conectar();
        }



        public function sacarTallas(){
            try{
                $sql = "select * from tallas order by id";

                $stmt = $this->conex->prepare($sql);

                $stmt->execute();

                $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

                return $resultado;

            }catch(PDOException $e){
                return $e->getMessage();
            }



        }



    }