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
                $sql = "select p.Id, p.Nombre, p.Precio, c.Nombre as Categoria
                from productos p 
                join categorias c on p.CATEGORIAID = c.Id
                order by p.id";
                
                $stmt = $this->conex->prepare($sql);
                
                if($stmt->execute() && $stmt->rowCount() > 0){
                    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    return $productos;
                }
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }


        //Funcion de prueba para distintos colores por tallas
        // public function generarJSON($id){
        //     $ruta = "javascript/productos-diferentes.json";
        //     if(file_exists($ruta)){
        //         $contenido = file_get_contents($ruta);
        //         if($contenido !== false){
        //             return $contenido;
        //         }

        //     }
        // }


        //Función para generar un JSON de los datos recogidos de la base de datos
        public function generarJSON($id, $categoria){
            //Declaración de variables para la construcción del JSON
            $tallas = [];
            $talla = "";
            $contadores = [];
            $cont = 0;

            try{

                //Comprobamos que la categoría no es de accesorios, ya que estos no tendrán tallas 
                if($categoria !== "Accesorios"){
                        //Generamos el sql para sacar los datos del producto en especifico
                        $sql = "select p.nombre as Nombre, p.precio as Precio, p.descripcion as Descripcion, t.nombre as Tallas, c.ColorPatron as ColorPatron, c.ColorBase as ColorBase
                        from productos p 
                        join variacionesproductos v on p.id = v.idproducto 
                        join tallasproductos tp on v.id = tp.IDVARIACION
                        join tallas t on tp.IDTALLA = t.id
                        join colores c on v.IDCOLOR = c.id
                        where p.id = ?";
                        
                        $stmt = $this->conex->prepare($sql);
                        
                        //Comprobamos que la consulta funcione
                        if($stmt->execute([$id]) && $stmt->rowCount() > 0){
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
                                    $tallas += [$talla =>[["ColorPatron" => $colorPatron, "ColorBase" => $colorBase]]];
                                    // $tallas += [$talla =>["ColorPatron{$contadores[$talla]}" => $colorPatron, "ColorBase{$contadores[$talla]}" => $colorBase]];
                                }else{
                                    //Si existe añadimos los colores
                                    array_push($tallas[$talla], ["ColorPatron" => $colorPatron, "ColorBase" => $colorBase]);
                                    // $tallas[$talla] += ["ColorPatron{$contadores[$talla]}" => $colorPatron, "ColorBase{$contadores[$talla]}" => $colorBase];
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
                            $prodJSON = json_encode($productoFinal, true);
                            return $prodJSON;
                        }else{
                            //En caso de que la consulta no funcione devolvemos false
                            return false;
                        }
                }else{
                    $colores = [];
                    //Generamos el sql para sacar los accesorios
                    $sql = "select p.nombre as Nombre, p.precio as Precio, p.descripcion as Descripcion, c.ColorPatron as ColorPatron, c.ColorBase as ColorBase
                        from productos p 
                        join variacionesproductos v on p.id = v.idproducto 
                        join colores c on v.IDCOLOR = c.id
                        where p.id = ?";

                    $stmt = $this->conex->prepare($sql);

                    if($stmt->execute([$id])){
                        $producto = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach($producto as $unidad){
                            [$colorPatron, $colorBase] = [$unidad["ColorPatron"], $unidad["ColorBase"]];

                            array_push($colores, ["ColorPatron" => $colorPatron, "ColorBase" => $colorBase]);
                        }

                        //Generamos un array asociativo con la información del producto
                        $productoFinal = ["Nombre" => $producto[0]["Nombre"],
                        "Descripcion" => $producto[0]["Descripcion"],
                        "Precio" => $producto[0]["Precio"],
                        "Colores" => $colores
                        ];
                        //Convertimos el array a JSON y lo devolvemos
                        $prodJSON = json_encode($productoFinal, true);
                        return $prodJSON;
                    }else{
                        return false;
                    }

                }
            }catch(PDOException $e){
                return  $e->getMessage();
            }
        }
    
    
    }

