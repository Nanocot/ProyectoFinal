<?php

    require_once "conexion.php";



    class ModeloCompras{


        private $conex;

        public function __construct(){
            $this->conex = ModeloConexion::conectar();
        }


        public function addCompra($usuario, $precio){
            try{
                $hoy = date("Y-m-d H:i:s");
                $estado = "pendiente";
                $metodo = 1;

                $sql = "insert into compras (fecha, estadoPago, idmetodopago, emailusuario, precioTotal) values (?, ?, ?, ?, ?);";


                $stmt = $this->conex->prepare($sql);

                if($stmt->execute([$hoy, $estado, $metodo, $usuario, $precio])){

                    return [true, $this->conex->lastInsertId()];
                }else{  
                    return false;
                }


            }catch(PDOException $e){
                return $e->getMessage();
            }
        }


        public function guardarDetalles($idCompra, $idVariacion, $idTalla, $cantidad, $precio){
            try{

                $sql = "insert into detallescompra (idcompra, idvariacion, idtalla, cantidad, preciototal) values (?, ?, ?, ?, ?);";

                $stmt = $this->conex->prepare($sql);

                if($stmt->execute([$idCompra, $idVariacion, $idTalla, $cantidad, $precio])){
                    return true;
                }else{
                    return false;
                }


            }catch(PDOException $e){
                return $e->getMessage();
            }
        }


        public function generarTabla(){

            try{
                $sql = "select c.id as Id, c.fecha as Fecha, c.estadoPago as EstadoPago, c.EMAILUSUARIO as email, c.precioTotal as PrecioTotal, m.tipo as MetodoPago from compras c left join metodopago m on c.IDMETODOPAGO = m.ID;";

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

        public function generarTablaUser($usuario){

            try{
                $sql = "select c.id as Id, c.fecha as Fecha, c.estadoPago as EstadoPago, c.precioTotal as PrecioTotal, m.tipo as MetodoPago from compras c left join metodopago m on c.IDMETODOPAGO = m.ID where c.emailusuario = '{$usuario}';";

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

        


        public function sacarDetalles($id){
            

            try{
                
                $sql = "select p.nombre as nombre, concat(co.ColorPatron, ' y ', co.ColorBase) as color, t.nombre as talla, d.cantidad, d.preciototal as precio
                        from detallescompra d left join compras c on d.IDCOMPRA = c.id
                        left join  variacionesproductos v on d.IDVARIACION = v.id
                        left join colores co on v.IDCOLOR = co.id
                        left join tallas t on d.IDTALLA = t.Id
                        left join productos p on v.idproducto = p.id
                        where c.id = ?;";


                $stmt = $this->conex->prepare($sql);

                
                if($stmt->execute([$id])){
                    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $totalProdus = $stmt->rowCount();
                    return [$resultado, $totalProdus];
                }else{
                    return "No se han encontrado resultados";
                }




            }catch(PDOException $e){
                return $e->getMessage();
            }
        }
        

        public function actualizarCompra($id, $estado){

            try{

                $sql = "update  compras set estadopago = ? where id = ?;";


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