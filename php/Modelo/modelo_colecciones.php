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



        public function datosTabla(){

            
            try{
                $sql = "select * from colecciones";

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



        public function eliminarColeccion($id){


            try{
                $sql = "delete from colecciones where id = ?;";

                $stmt = $this->conex->prepare($sql);

                if($stmt->execute([$id])){

                    return "Colección borrada";
                }else{
                    return false;
                }


            }catch(PDOException $e){
                return $e->getMessage();
            }



        }



        public function actualizarColeccion($datos){

            try{
                $id = $datos["Id"];
                $nombre = $datos["Nombre"];
                $descp = $datos["Descripcion"];



                $sql = "update colecciones set nombre = ?, descripcion = ? where id = ?";

                $stmt = $this->conex->prepare($sql);

                if($stmt->execute([$nombre, $descp, $id])){
                    return "Colección actualizada";
                }else{
                    return false;
                }


            }catch(PDOException $e){
                return $e->getMessage();
            }




        }
        
        public function crearColeccion($datos){

            try{
                $nombre = $datos["Nombre"];
                $descp = $datos["Descripcion"];



                $sql = "insert into colecciones (nombre, descripcion) values (?, ?);";

                $stmt = $this->conex->prepare($sql);

                if($stmt->execute([$nombre, $descp])){
                    $id = $this->conex->lastInsertId();
                    return ["Mensaje" => "Colección creada", "ID" => $id];
                }else{
                    return false;
                }


            }catch(PDOException $e){
                return $e->getMessage();
            }




        }





    }