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


        public function generarTabla(){
            try{
                //Creamos el sql para sacar los descuentos que pueden estar activos
                $sql = "select * from descuentos";

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



        public function crearDescuento($datos){
            try{
                

                ["Nombre" => $nombre, "Descripcion" => $descripcion, "FechaInicio" => $fechaIni, "FechaFin" => $fechaFin, "Cantidad" => $cantidad, "Tipo" => $tipo] = $datos;
                


                //Creamos el sql para sacar los descuentos que pueden estar activos
                $sql = "insert into descuentos (nombre, descripcion, fechaini, fechafin, cantidad, tipo) values (?, ?, ?, ?, ?, ?);";

                $stmt = $this->conex->prepare($sql);

                if($stmt->execute([$nombre, $descripcion, $fechaIni, $fechaFin, $cantidad, $tipo])){
                    $resultado = ["Mensaje" => "Descuento creado correctamente", "ID" => $this->conex->lastInsertId()];

                    return $resultado;
                }else{
                    return false;
                }

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }



        public function borrarDescuento($id){
            try{

                $sql = "delete from descuentos where id = ?;";

                $stmt = $this->conex->prepare($sql);

                if($stmt->execute([$id])){
                    return "Descuento borrado con exito";
                }else{
                    return false;
                }



            }catch(PDOException $e){
                return $e->getMessage();
            }
        }



        public function actualizarDescuento($datos){

            $id = $datos["Id"];

            try{

                if(isset($datos["Nombre"])){
                    $sql = "update descuentos set nombre = ? where id = ?;";

                    $stmt = $this->conex->prepare($sql);

                    if($stmt->execute([$datos["Nombre"], $id])){
                        return  "Descuento actualizado correctamente";
                    }else{
                        return "No se pudo cambiar el nombre";
                    }
                }

                if(isset($datos["Descripcion"])){
                    $sql = "update descuentos set descripcion = ? where id = ?;";

                    $stmt = $this->conex->prepare($sql);

                    if($stmt->execute([$datos["Descripcion"], $id])){
                        return  "Descuento actualizado correctamente";
                    }else{
                        return "No se pudo cambiar el nombre";
                    }
                }

                if(isset($datos["FechaInicio"])){
                    $sql = "update descuentos set fechaIni = ? where id = ?;";

                    $stmt = $this->conex->prepare($sql);

                    if($stmt->execute([$datos["FechaInicio"], $id])){
                        return  "Descuento actualizado correctamente";
                    }else{
                        return "No se pudo cambiar la fecha de inicio";
                    }
                }
                if(isset($datos["FechaFin"])){
                    $sql = "update descuentos set fechaFin = ? where id = ?;";

                    $stmt = $this->conex->prepare($sql);

                    if($stmt->execute([$datos["FechaFin"], $id])){
                        return  "Descuento actualizado correctamente";
                    }else{
                        return "No se pudo cambiar la fecha final";
                    }
                }
                if(isset($datos["Cantidad"])){
                    $sql = "update descuentos set cantidad = ? where id = ?;";

                    $stmt = $this->conex->prepare($sql);

                    if($stmt->execute([$datos["Cantidad"], $id])){
                        return  "Descuento actualizado correctamente";
                    }else{
                        return "No se pudo cambiar la cantidad de descuento";
                    }
                }
                if(isset($datos["Tipo"])){
                    $sql = "update descuentos set tipo = ? where id = ?;";

                    $stmt = $this->conex->prepare($sql);

                    if($stmt->execute([$datos["Tipo"], $id])){
                        return  "Descuento actualizado correctamente";
                    }else{
                        return "No se pudo cambiar el tipo de descuento";
                    }
                }

                return "Revise los datos";

            }catch(PDOException $e){
                return $e->getMessage();
            }

        }


    }