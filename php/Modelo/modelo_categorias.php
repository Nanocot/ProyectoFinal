<?php


    require_once "conexion.php";

    class ModeloCategorias{

        private $conex; 


        public function __construct(){
            $this->conex = ModeloConexion::conectar();
        }


        public function sacarCategorias(){
            try{

                //Creamos el sql con los datos que nos interesan
                $sql = "select  id, nombre from categorias";

                $stmt = $this->conex->prepare($sql);

                if($stmt->execute()){
                    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    return $resultado;
                }
                return false;

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }



    }