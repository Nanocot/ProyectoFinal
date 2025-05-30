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


        public function  generarTabla(){
            try{

                //Creamos el sql con los datos que nos interesan
                $sql = "select  * from categorias";

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


        public function eliminarCategoria($id){


            try{
                $sql = "delete from categorias where id = ?;";

                $stmt = $this->conex->prepare($sql);

                if($stmt->execute([$id])){

                    return "Categoría borrada";
                }else{
                    return false;
                }


            }catch(PDOException $e){
                return $e->getMessage();
            }



        }



        public function actualizarCategoria($datos){

            try{
                ["Id" => $id, "Nombre" => $nombre, "Descripcion" => $descp] = $datos;


                $sql = "update categorias set nombre = ?, descripcion = ? where id = ?";

                $stmt = $this->conex->prepare($sql);

                if($stmt->execute([$nombre, $descp, $id])){
                    return "Categoria actualizada";
                }else{
                    return false;
                }


            }catch(PDOException $e){
                return $e->getMessage();
            }




        }
        
        public function crearCategoria($datos){

            try{
                ["Nombre" => $nombre, "Descripcion" => $descp] = $datos;


                $sql = "insert into categorias (nombre, descripcion) values (?, ?);";

                $stmt = $this->conex->prepare($sql);

                if($stmt->execute([$nombre, $descp])){
                    $id = $this->conex->lastInsertId();
                    return ["Mensaje" => "Categoría creada", "ID" => $id];
                }else{
                    return false;
                }


            }catch(PDOException $e){
                return $e->getMessage();
            }




        }


    }