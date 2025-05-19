<?php 


    require_once "conexion.php";


    class ModeloDescuento{

        private $conex;

        public function __construct(){
            $this->conex = ModeloConexion::conectar();
        }


        //Función para sacar todos los descuentos que están "activos"
        public function sacarDescuentos(){
            try{
                //Creamos el sql para sacar los descuentos que pueden estar activos
                $sql = "select id, nombre from descuentos WHERE FechaFin > CURRENT_DATE;";

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