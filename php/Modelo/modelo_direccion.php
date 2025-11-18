<?php


    require_once "conexion.php";


    class ModeloDireccion{

        private $conex;

        public function __construct(){
            $this->conex = ModeloConexion::conectar();
        }


        public function modDireccion($numero, $codPostal, $calle, $poblacion, $puerta, $planta, $usuario){

            try{
                

                    $sqlDelete = "delete from direcciones where emailusuario = ?";

                    $stmtDelete = $this->conex->prepare($sqlDelete);

                    $stmtDelete->execute([$usuario]);

                
                    $sqlInsert = "insert into direcciones (numero, codpostal, calle, poblacion, puerta, planta, emailusuario) values (?, ?, ?, ?, ?, ?, ?) ";

                $stmt = $this->conex->prepare($sqlInsert);

                if($stmt->execute([$numero, $codPostal, $calle, $poblacion, $puerta, $planta, $usuario])){
                    return true;
                }else{
                    return false;
                }




            }catch(PDOException $e){
                return $e->getMessage();
            }



        }

    }