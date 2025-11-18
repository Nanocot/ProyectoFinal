<?php 

    require_once "conexion.php";

    class ModeloReclamaciones{
        
        private $conex;
    
    
        public function __construct(){
            $this->conex = ModeloConexion::conectar();
        }
    

        public function guardarReclamacion($motivo, $descripcion, $foto, $fecha, $user){
            try{
                $sql = "insert into reclamaciones (motivo, descripcion, foto, fecha, emailusuario, estado) values (?, ?, ?, ?, ?, 'pendiente');";

                $stmt = $this->conex->prepare($sql);

                if($stmt->execute([$motivo, $descripcion, $foto, $fecha, $user])){
                    return true;
                }else{
                    return false;
                }

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }


        public function sacarReclamaciones(){
            try{
                $sql = "select id, motivo, descripcion, emailusuario, estado from reclamaciones;";

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



        public function cambiarEstado($id, $estado){
            try{

                $sql = "update reclamaciones set estado = ? where id = ? ";

                $stmt = $this->conex->prepare($sql);

                if($stmt->execute([$estado, $id])){
                    return true;
                }else{
                    return false;
                }


            }catch(PDOException $e){
                return $e->getMessage();
            }
        }
    
    }