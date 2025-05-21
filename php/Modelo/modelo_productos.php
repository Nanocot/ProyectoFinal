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
                $sql = "select p.Id, p.Nombre, p.Precio, c.Nombre as Categoria, i.Ruta as Foto
                from productos p 
                join categorias c on p.CATEGORIAID = c.Id
                left join imagenes i on  p.ID = i.IDPRODUCTO
                group by p.id
                order by p.id;";
                
                $stmt = $this->conex->prepare($sql);
                
                if($stmt->execute() && $stmt->rowCount() > 0){
                    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    return $productos;
                }
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }


        // //Funcion de prueba para distintos colores por tallas
        // public function generarJSON($id, $categoria){
        //     //Declaración de variables para la construcción del JSON
        //     $tallasColores = [];
        //     $tallas = [];
        //     $talla = "";
        //     $contadores = [];
        //     $cont = 0;

        //     try{

        //         //Comprobamos que la categoría no es de accesorios, ya que estos no tendrán tallas 
        //         if($categoria !== "Accesorios"){
        //                 //Generamos el sql para sacar los datos del producto en especifico
                        
                        
                        
        //                 $stmt = $this->conex->prepare($sql);
                        
        //                 //Comprobamos que la consulta funcione
        //                 if($stmt->execute([$id]) && $stmt->rowCount() > 0){
        //                     //Guardamos el producto en una variable y la devolvemos
        //                     $producto = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //                     $tallas = explode("," ,$producto["Tallas"]);
        //                     //Empezamos a construir los colores por tallas
        //                     foreach($producto as $unidad){    
        //                         //Guardamos los colores
        //                         [$colorPatron, $colorBase] = [$unidad["ColorPatron"], $unidad["ColorBase"]];
        //                         foreach($tallas as $talla){
        //                             $tallas[$talla] += [$colorPatron, $colorBase];
        //                         }
        //                     }
                            
                            
        //                     //Generamos un array asociativo con la información del producto
        //                     $productoFinal = ["Nombre" => $producto[0]["Nombre"],
        //                     "Descripcion" => $producto[0]["Descripcion"],
        //                     "Precio" => $producto[0]["Precio"],
        //                     "IdTallas" => $tallas,
        //                     "Informacion" => $tallasColores,
        //                     "Foto" => $producto[0]["Foto"],
        //                     "Stock" => $producto[0]["stock"]
        //                     ];
        //                     //Convertimos el array a JSON y lo devolvemos
        //                     $prodJSON = json_encode($productoFinal, true);
        //                     return $prodJSON;
        //                 }else{
        //                     //En caso de que la consulta no funcione devolvemos false
        //                     return false;
        //                 }
        //         }else{
        //             $colores = [];
        //             //Generamos el sql para sacar los accesorios
        //             $sql = "select p.nombre as Nombre, p.precio as Precio, p.descripcion as Descripcion, c.ColorPatron as ColorPatron, c.ColorBase as ColorBase, s.stock
        //                 from productos p 
        //                 join variacionesproductos v on p.id = v.idproducto 
        //                 join colores c on v.IDCOLOR = c.id
        //                 join stock s on v.ID = s.IDVARIACION
        //                 where p.id = ?";

        //             $stmt = $this->conex->prepare($sql);

        //             if($stmt->execute([$id])){
        //                 $producto = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //                 foreach($producto as $unidad){
        //                     [$colorPatron, $colorBase] = [$unidad["ColorPatron"], $unidad["ColorBase"]];

        //                     array_push($colores, ["ColorPatron" => $colorPatron, "ColorBase" => $colorBase]);
        //                 }

        //                 //Generamos un array asociativo con la información del producto
        //                 $productoFinal = ["Nombre" => $producto[0]["Nombre"],
        //                 "Descripcion" => $producto[0]["Descripcion"],
        //                 "Precio" => $producto[0]["Precio"],
        //                 "Colores" => $colores,
        //                 "Stock" => $producto[0]["stock"]
        //                 ];
        //                 //Convertimos el array a JSON y lo devolvemos
        //                 $prodJSON = json_encode($productoFinal, true);
        //                 return $prodJSON;
        //             }else{
        //                 return false;
        //             }

        //         }
        //     }catch(PDOException $e){
        //         return  $e->getMessage();
        //     }
        // }

        //Función para generar un JSON de los datos recogidos de la base de datos
        public function generarJSON($id, $categoria){
            //Declaración de variables para la construcción del JSON
            $tallasColores = [];
            $tallas = [];
            $talla = "";
            $contadores = [];
            $cont = 0;
            $fotos =  [];
            $stock = [];

            try{

                //Comprobamos que la categoría no es de accesorios, ya que estos no tendrán tallas 
                if($categoria !== "Accesorios"){
                        //Generamos el sql para sacar los datos del producto en especifico
                        // $sql = "select p.nombre as Nombre, p.precio as Precio, p.descripcion as Descripcion, t.nombre as Tallas, t.id as IDTalla, c.ColorPatron as ColorPatron, c.ColorBase as ColorBase, s.stock
                        // from productos p 
                        // join variacionesproductos v on p.id = v.idproducto 
                        // join tallasproductos tp on v.id = tp.IDVARIACION
                        // join tallas t on tp.IDTALLA = t.id
                        // join colores c on v.IDCOLOR = c.id
                        // join stock s on v.ID = s.IDVARIACION
                        // where p.id = ?";

                        $sql = "select p.nombre as Nombre, p.precio as Precio, p.descripcion as Descripcion, t.nombre AS Tallas, t.id as IDTalla, c.ColorPatron as ColorPatron, c.ColorBase as ColorBase, s.stock, i.ruta as Foto
                        from productos p 
                        join variacionesproductos v on p.id = v.idproducto 
                        join tallasproductos tp on v.id = tp.IDVARIACION
                        join tallas t on tp.IDTALLA = t.id
                        join colores c on v.IDCOLOR = c.id
                        join stock s on v.ID = s.IDVARIACION
                        join imagenes i on p.id = i.IDPRODUCTO
                        where p.id = ?;
                        ";

                        
                        
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

                                if(!in_array($unidad["Foto"], $fotos)){
                                    array_push($fotos, $unidad["Foto"]);
                                }
                                
                                //Guardamos los colores
                                [$colorPatron, $colorBase] = [$unidad["ColorPatron"], $unidad["ColorBase"]];
                                
                                if(!isset($stock["{$colorPatron} y {$colorBase}"])){
                                    $stock["{$colorPatron} y {$colorBase}"] = $unidad["stock"];
                                }


                                //Comprobamos que la talla no existe dentro del array
                                if(!isset($tallasColores[$talla]) && !isset($tallas[$talla])){
                                    $tallas += [$talla => $unidad["IDTalla"]];
                                    //Si no existe la guardamos, junto a los primeros colores
                                    $tallasColores += [$talla =>[["ColorPatron" => $colorPatron, "ColorBase" => $colorBase]]];
                                    // $tallas[$talla] += ["ID" => $unidad["IDTalla"]];
                                    // $tallas += [$talla =>["ColorPatron{$contadores[$talla]}" => $colorPatron, "ColorBase{$contadores[$talla]}" => $colorBase]];
                                }else{
                                    //Si existe comprobamos que los colores no estén repetidos
                                    if(!in_array(["ColorPatron" => $colorPatron, "ColorBase" => $colorBase], $tallasColores[$talla])){
                                        array_push($tallasColores[$talla], ["ColorPatron" => $colorPatron, "ColorBase" => $colorBase]);
                                    }
                                    // $tallas[$talla] += ["ColorPatron{$contadores[$talla]}" => $colorPatron, "ColorBase{$contadores[$talla]}" => $colorBase];
                                }
                                
                                $contadores[$talla] ++;
                            }
                            
                            
                            //Generamos un array asociativo con la información del producto
                            $productoFinal = ["Nombre" => $producto[0]["Nombre"],
                            "Descripcion" => $producto[0]["Descripcion"],
                            "Precio" => $producto[0]["Precio"],
                            "IdTallas" => $tallas,
                            "Informacion" => $tallasColores,
                            "Foto" => $fotos,
                            "Stock" => $stock
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
                    $sql = "select p.nombre as Nombre, p.precio as Precio, p.descripcion as Descripcion, c.ColorPatron as ColorPatron, c.ColorBase as ColorBase, s.stock, i.ruta as Foto
                        from productos p 
                        join variacionesproductos v on p.id = v.idproducto 
                        join colores c on v.IDCOLOR = c.id
                        join stock s on v.ID = s.IDVARIACION
                        join imagenes i on p.ID = i.IDPRODUCTO
                        where p.id = ?";

                    $stmt = $this->conex->prepare($sql);

                    if($stmt->execute([$id])){
                        $producto = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach($producto as $unidad){
                            [$colorPatron, $colorBase] = [$unidad["ColorPatron"], $unidad["ColorBase"]];

                            if(!in_array($unidad["Foto"], $fotos)){
                                    array_push($fotos, $unidad["Foto"]);
                                }

                            if(!in_array(["ColorPatron" => $colorPatron, "ColorBase" => $colorBase], $colores)){
                                array_push($colores, ["ColorPatron" => $colorPatron, "ColorBase" => $colorBase]);
                            }

                            if(!isset($stock[$colorPatron])){
                                    $stock[$colorPatron] = $unidad["stock"];
                                }
                        }

                        //Generamos un array asociativo con la información del producto
                        $productoFinal = ["Nombre" => $producto[0]["Nombre"],
                        "Descripcion" => $producto[0]["Descripcion"],
                        "Precio" => $producto[0]["Precio"],
                        "Colores" => $colores,
                        "Foto" => $fotos,
                        "Stock" => $stock
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
    

        public function generarDatosTabla(){

            try{

                $sql = "select p.id as ID, p.nombre as Nombre, p.precio as Precio,  ca.nombre as Categoria, c.nombre as Coleccion,
                        GROUP_CONCAT(DISTINCT t.nombre ORDER BY t.id SEPARATOR ', ') AS Tallas, 
                        i.ruta as Foto
                        from productos p 
                        join variacionesproductos v on p.id = v.idproducto 
                        left join tallasproductos tp on v.id = tp.IDVARIACION
                        left join tallas t on tp.IDTALLA = t.id
                        join imagenes i on p.id = i.IDPRODUCTO
                        left join colecciones c on p.coleccionid = c.id
                        left join categorias ca on p.categoriaid = ca.id 
                        GROUP by p.id
                        order by p.id;";


                $stmt = $this->conex->prepare($sql);

                $stmt->execute();

                if($stmt->rowCount() > 0){
                    $respuesta = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    return $respuesta;
                }else{
                    return false;
                }


            }catch(PDOException $e){
                return $e->getMessage();
            }


            


        }
    
        public function sacarDatosMod($id, $categoria){

            try{
                //Comprobamos que no es un accesorio
                if($categoria != "Accesorios"){                    
                    //Construimos el sql para sacar los datos del producto
                    $sql = "select p.nombre as Nombre, p.precio as Precio, p.descripcion as Descripcion, t.nombre AS Tallas, t.id as IDTalla, c.ColorPatron as ColorPatron, c.ColorBase as ColorBase, i.ruta as Foto, d.nombre as Descuento, co.Nombre as Coleccion
                        from productos p 
                        left join variacionesproductos v on p.id = v.idproducto
                        left join tallasproductos tp on v.id = tp.IDVARIACION
                        left join tallas t on tp.IDTALLA = t.id
                        left join colores c on v.IDCOLOR = c.id
                        left join imagenes i on p.id = i.IDPRODUCTO
                        left join descuentos d on p.descuentoid = d.id
                        left join colecciones co on p.coleccionid = co.id
                        where p.id = ?
                        order by t.id, i.id
                        ;";

                    $stmt = $this->conex->prepare($sql);

                    if($stmt->execute([$id])){
                        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        $fotos = [];
                        // echo "<pre>";
                        // print_r ($resultado);
                        // echo "</pre>";


                        $datosProd = ["Nombre" => $resultado[0]["Nombre"], "Categoria" => $categoria, "Descripcion" => $resultado[0]["Descripcion"], "Descuento" => $resultado[0]["Descuento"], "Precio" => $resultado[0]["Precio"], "Coleccion" => $resultado[0]["Coleccion"]];

                        for ($i=0; $i < count($resultado); $i++) { 

                            $rutaFoto = $resultado[$i]["Foto"];
                            $indiceTalla = $resultado[$i]["Tallas"];

                            if(!isset($infoTallas[$indiceTalla])){
                                $infoTallas[$indiceTalla] = ["Colores" => [["Color Patron" => $resultado[$i]["ColorPatron"], "Color Base" => $resultado[$i]["ColorBase"]]], "ID" => $resultado[$i]["IDTalla"]];
                            }else{
                                $auxColores = ["Color Patron" => $resultado[$i]["ColorPatron"], "Color Base" => $resultado[$i]["ColorBase"]];

                                if(!in_array($auxColores, $infoTallas[$indiceTalla]["Colores"])){    
                                    array_push($infoTallas[$indiceTalla]["Colores"], $auxColores);
                                }
                            }

                            if(!in_array($rutaFoto, $fotos)){
                                array_push($fotos, $rutaFoto);
                            }
                        }

                        $producto = ["Datos" => $datosProd, "InfoTallas" => $infoTallas,"Fotos" => $fotos];


                        return  $producto;

                    }else{
                        return false;
                    }



            
                }else{

                    $sql = "select p.nombre as Nombre, p.precio as Precio, p.descripcion as Descripcion, c.ColorPatron as ColorPatron, c.ColorBase as ColorBase, i.ruta as Foto, d.nombre as Descuento, co.Nombre as Coleccion
                        from productos p 
                        left join variacionesproductos v on p.id = v.idproducto
                        left join colores c on v.IDCOLOR = c.id
                        left join imagenes i on p.id = i.IDPRODUCTO
                        left join descuentos d on p.descuentoid = d.id
                        left join colecciones co on p.coleccionid = co.id
                        where p.id = ?;";

                    $stmt = $this->conex->prepare($sql);

                    if($stmt->execute([$id])){
                        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        $datosProd = ["Nombre" => $resultado[0]["Nombre"], "Categoria" => $categoria, "Descripcion" => $resultado[0]["Descripcion"], "Descuento" => $resultado[0]["Descuento"], "Precio" => $resultado[0]["Precio"], "Coleccion" => $resultado[0]["Coleccion"]];
                        
                        $fotos = [];
                        $colores = [];

                        foreach($resultado as  $fila){
                            if(!in_array($fila["Foto"], $fotos)){
                                array_push($fotos, $fila["Foto"]);
                            }

                            $auxColores =  ["Color Patron" => $fila["ColorPatron"], "Color Base" => $fila["ColorBase"]];

                            if(!in_array($auxColores, $colores)){
                                array_push($colores, $auxColores);
                            }
                        }

                        $producto  = ["Datos" => $datosProd, "Fotos" => $fotos, "Colores" => $colores];

                        return $producto;
                    }
                }

            }catch(PDOException $e){
                return $e->getMessage();
            }
        }


        public function sacarStock($id){

            try{
                $sql = "select c.colorPatron as ColorPatron, c.colorBase as ColorBase, s.Stock
                    from productos p
                    left join variacionesproductos v on p.id = v.idproducto
                    left join colores c on v.idcolor = c.id
                    left join stock s on v.id = s.idvariacion
                    where p.id = ?;
                ";

                $stmt = $this->conex->prepare($sql);

                if($stmt->execute([$id])){
                    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    return $resultado;
                }

            }catch(PDOException $e){
                return $e->getMessage();
            }



        }


        public function modificarProducto($datos){
            try{

                //Datos del producto
                $id = $datos["ID"];
                $nombre = $datos["Nombre"];
                $idCategoria = $datos["Categoria"];
                $idColeccion = $datos["Coleccion"];
                $precio = $datos["Precio"];
                $description = $datos["Descripcion"];

                //Datos relacionados con el produccto
                $infoTallas = $datos["Tallas"];
                $infoColores = $datos["Colores"];
                $rutasFotos = $datos["Fotos"];


                //Declaración de variables
                $tallas = [];

                foreach($infoTallas as $indice => $fila){
                    // if(!in_array($indice, $tallas)){
                    //     array_push($tallas,$indice);
                    // }

                    if(!isset($tallas[$indice])){
                        $tallas[$indice] = count($fila);
                    }
                    
                }

                // print_r($tallas);
                // return $tallas;





                
                
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }


    }

