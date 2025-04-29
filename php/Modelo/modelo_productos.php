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


        public function generarJSON($id){
            //Declaración de variables para la construcción del JSON
            $tallas = [];
            $talla = "";
            $contadores = [];
            $cont = 0;

            try{
                //Generamos el sql para sacar los datos del producto en especifico
                $sql = "select p.nombre as Nombre, p.precio as Precio, p.descripcion as Descripcion, t.talla as Tallas, cp.nombre as ColorPatron, cb.Nombre as ColorBase
                        from productos p 
                        join variacionesproductos v on p.id = v.idproducto 
                        join tallasproductos tp on v.id = tp.IDVARIACION
                        join tallas t on tp.IDTALLA = t.id
                        join colores cb on v.idcolorbase = cb.id
                        join colores cp on v.IDCOLORPATRON = cp.id
                        where p.id = ?";

                $stmt = $this->conex->prepare($sql);

                //Comprobamos que la consulta funcione
                if($stmt->execute([$id])){
                    //Guardamos el producto en una variable y la devolvemos
                    $producto = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    //Empezamos a construir los colores por tallas
                    foreach($producto as $unidad){
                        //Comprobamos que la talla de la variación es distinta a la que teniamos guardada
                        if($talla != $unidad["Tallas"]){
                            $talla  = $unidad["Tallas"];
                        }

                        //Guardamos la talla en un array de contadores para que el patrón sea simetrico
                        if(!array_key_exists($talla, $contadores)){
                            $contadores += [$talla => $cont];
                        }

                        //Guardamos los colores
                        [$colorPatron, $colorBase] = [$unidad["ColorPatron"], $unidad["ColorBase"]];

                        //Comprobamos que la talla no existe dentro del array
                        if(!isset($tallas[$talla])){
                            //Si no existe la guardamos, junto a los primeros colores
                            $tallas += [$talla =>["ColorPatron{$contadores[$talla]}" => $colorPatron, "ColorBase{$contadores[$talla]}" => $colorBase]];
                        }else{
                            //Si existe añadimos los colores
                            $tallas[$talla] += ["ColorPatron{$contadores[$talla]}" => $colorPatron, "ColorBase{$contadores[$talla]}" => $colorBase];
                        }

                        $contadores[$talla] ++;
                    }

                    //Generamos un array asociativo con la información del producto
                    $productoFinal = ["Nombre" => $producto[0]["Nombre"],
                        "Descripcion" => $producto[0]["Descripcion"],
                        "Precio" => $producto[0]["Precio"],
                        "Informacion" => $tallas
                    ];

                    //Convertimos el array a JSON y lo devolvemos
                    $prodJSON = json_encode($productoFinal);
                    return $prodJSON;
                }else{
                    //En caso de que la consulta no funcione devolvemos false
                    return false;
                }
            }catch(PDOException $e){
                return  $e->getMessage();
            }
        }
    
    
    }

