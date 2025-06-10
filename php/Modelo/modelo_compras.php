<?php

    require_once "conexion.php";



    class ModeloCompras{


        private $conex;

        public function __construct(){
            $this->conex = ModeloConexion::conectar();
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