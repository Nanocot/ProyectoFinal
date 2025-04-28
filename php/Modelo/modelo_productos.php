<?php 

    require_once "conexion.php";


    class ModeloProductos{
        //Atributo conexión general para todo el fichero
        private $conex;

        public function __construct(){
            $this->conex = ModeloConexion::conectar();
        }
    
        //Método para mostrar todos los productos
        public function mostrarProductosHome(){
            try{
                //Preparamos la sentencia, para mostrar los datos en la página de inicio
                $sql = "select Id, Nombre, Precio from productos";
                
                $stmt = $this->conex->prepare($sql);
                
                if($stmt->execute() && $stmt->rowCount() > 0){
                    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    return $productos;
                }
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }


        public function mostrarProducto($id){
            try{
                //Generamos el sql para sacar los datos del producto en especifico
                $sql = "select p.nombre as Nombre, p.precio as Precio, p.descripcion as Descripcion, t.talla as Tallas, cp.nombre as ColorPatron, cb.Nombre as ColorBase
from productos p 
join variacionesproductos v on p.id = v.idproducto 
join tallasproductos tp on v.id = tp.IDVARIACION
join tallas t on tp.IDTALLA = t.id
join colores cb on v.idcolorbase = cb.id
join colores cp on v.IDCOLORPATRON = cp.id
where p.id = 1";

                $stmt = $this->conex->prepare($sql);

                if($stmt->execute($id)){
                    //Guardamos el producto en una variable y la devolvemos, sabiendo que es solo un producto, pasamos el array asociativo directamente
                    $producto = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    return $producto[0];
                }else{
                    return false;
                }
            
            
            
            
            }catch(PDOException $e){

            }
        }
    
    
    }

