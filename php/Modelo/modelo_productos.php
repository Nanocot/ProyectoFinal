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
                        left join variacionesproductos v on p.id = v.idproducto 
                        left join tallasproductos tp on v.id = tp.IDVARIACION
                        left join tallas t on tp.IDTALLA = t.id
                        left join imagenes i on p.id = i.IDPRODUCTO
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
            
            $uploadDir = 'uploads/'; // Ruta absoluta a la carpeta 'uploads'
            $tiposPermitidos = ['image/jpeg', 'image/png', 'image/webp'];
            
            // Array para recolectar los resultados del procesamiento de fotos
            $fotosResultados = []; 
            
            
            try{

                //Datos del producto
                $id = $datos["ID"];
                $nombre = $datos["Nombre"];
                $idCategoria = $datos["Categoria"];
                $idColeccion = $datos["Coleccion"];
                $precio = $datos["Precio"];
                $description = $datos["Descripcion"];
                $idDescuento =  $datos["Descuento"];

                //Datos relacionados con el produccto
                $infoTallas = $datos["Tallas"];
                $infoColores = $datos["Colores"];
                $rutasFotos = $datos["Fotos"];

                
                // print_r($datos);
                
                $this->conex->beginTransaction();

                    if (is_array($rutasFotos) && !empty($rutasFotos)) {
                        $nueva = false;
                        $existe = false;

                        $sqlFotosServidor = "select id, ruta from imagenes where IDPRODUCTO = ?;";
                        $stmtFotosServidor = $this->conex->prepare($sqlFotosServidor);

                        if($stmtFotosServidor->execute([$id])){
                            $fotosServidor = $stmtFotosServidor->fetchAll(PDO::FETCH_ASSOC);

                            $sqlDeleteFoto = "delete from imagenes where id = ?";
                            $stmtDeleteFoto = $this->conex->prepare($sqlDeleteFoto);

                            $sqlInsertFoto = "insert into imagenes (Ruta, IDPRODUCTO) values (?, ?);";
                            $stmtInsertFoto = $this->conex->prepare($sqlInsertFoto);
                            
                            foreach($fotosServidor as $fotoServer){
                                foreach($rutasFotos as $fotoCliente){
                                    if($fotoServer["ruta"] == $fotoCliente["Ruta"] || $fotoServer["ruta"]  == "uploads/{$fotoCliente["Alt"]}"){
                                        $existe = true;
                                    }
                                }

                                if(!$existe){
                                    $stmtDeleteFoto->execute([$fotoServer["id"]]);
                                    // echo "IMAGEN BORRADA ---> {$fotoServer["id"]}\n";
                                    if (file_exists($fotoServer["ruta"])) {
                                        unlink($fotoServer["ruta"]);
                                    }
                                }

                                $existe = false;
                            }
                        



                            foreach ($rutasFotos as $foto) {
                                $rutaBase64 = $foto['Ruta'];
                                $alt = $foto['Alt'];

                                // Comprobamos si es una foto añadida por el usuario
                                if (preg_match('/^data:(image\/(jpeg|png|gif|webp));base64,/', $rutaBase64, $matches)) {
                                    $nueva = true;
                                }
                                if($nueva){
                                    $mimeType = $matches[1];
                                    $extension = explode('/', $mimeType)[1]; 
                                    $base64Data = substr($rutaBase64, strpos($rutaBase64, ',') + 1);
                                    $imageData = base64_decode($base64Data);
                                    
                                    $cleanedAlt = preg_replace('/[^a-zA-Z0-9-]/', '', str_replace(' ', '-', strtolower($alt)));
                                    
                                    // Si el 'alt' está vacío después de limpiar, usamos un nombre único
                                    $finalFileName = '';
                                    $pattern = '/^[a-z0-9-]+(?:-[a-z0-9]+){1,}$/';
                                    
                                    if (!empty($cleanedAlt) && preg_match($pattern, $cleanedAlt)) {
                                        $finalFileName = $cleanedAlt . '.' . $extension;
                                    } else {
                                        $finalFileName = "{$nombre}-sin-color-reverso.{$extension}";
                                    }
                                    
                                    $destPath = $uploadDir . $finalFileName;
                                    
                                    
                                    if(file_exists($destPath)){
                                        unlink($destPath);
                                    }
                                    
                                    
                                    // Guardar el archivo binario
                                    if (file_put_contents($destPath, $imageData) !== false) {
                                        
                                        $stmtInsertFoto->execute([$destPath, $id]);
                                        
                                    }else {
                                        echo "No se ha podido subir la imagen";
                                    }
                                }
                            }
                        }
                    }


                    //Comprobación de los colores
                    $sql = "select id, concat(colorPatron, ' y ', colorBase) as Colores from colores order by id    ";

                    $stmt = $this->conex->prepare($sql);
                    
                    $stmt->execute();

                    if($stmt->rowCount() > 0){
                        //Sacamos todos los colores, para comprobar si el usario ha añadido alguno nuevo o no
                        $coloresDB = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        $existe = false;
                        $idColores = [];

                        for($i = 0; $i < count($infoColores); $i++){   
                            foreach($coloresDB as $fila){
                                if($fila["Colores"] == $infoColores[$i]["Color"]){
                                    $existe = true;
                                    array_push($idColores, ["ID" => $fila["id"], "Colores" => $fila["Colores"]]);
                                }
                            }

                            if(!$existe){
                                [$colorPatron, $colorBase] = explode(" y ", $infoColores[$i]["Color"]);
                                $sqlAddColor = "insert into colores (colorPatron, colorBase) values (?, ?);";

                                $stmtAddColor = $this->conex->prepare($sqlAddColor);

                                $stmtAddColor->bindParam(1, $colorPatron, PDO::PARAM_STR);
                                $stmtAddColor->bindParam(2, $colorBase, PDO::PARAM_STR);

                                $stmtAddColor->execute();
 
                                $idNuevoColor = $stmt->rowCount() + 1;
                                array_push($idColores, ["ID" => $idNuevoColor, "Colores" => `$colorPatron y $colorBase`]);

                            }

                            $existe = false;

                        }
                    }



                    //Comprobacion de variaciones
                    $sqlVariaciones = "select * from variacionesproductos where idproducto = ?";

                    $stmtVariaciones = $this->conex->prepare($sqlVariaciones);

                    if($stmtVariaciones->execute([$id]) && $stmtVariaciones->rowCount() > 0){
                        $variaciones = $stmtVariaciones->fetchAll(PDO::FETCH_ASSOC);
                        $existe = false;
                        
                        //Recorremos las variaciones para comprobar cual hemos borrado
                        foreach($variaciones as $fila){
                            //Dentro la comparamos con los colores que hemos recibido
                            for($i = 0; $i < count($idColores); $i++){
                                $idCompVariacion = $idColores[$i]["ID"];
                                if($fila["IDCOLOR"] == $idCompVariacion){
                                    $existe  = true;
                                }
                            }

                            if(!$existe){
                                $sqlDeleteVariacion = "delete from variacionesproductos where id = ?;";
                                $stmtDeleteVariacion = $this->conex->prepare($sqlDeleteVariacion);
                                $stmtDeleteVariacion->execute([$fila["Id"]]);
                            }
                            $existe = false;
                        }
                        
                        //Recorremos los colores para saber cual hemos añadido
                        for($i = 0; $i < count($idColores); $i++){
                            //Dentro comprobamos las variaciones para saber que color tenemos que añadir
                            foreach($variaciones as $fila){
                                $idCompVariacion = $idColores[$i]["ID"];
                                if($fila["IDCOLOR"] == $idCompVariacion){
                                    $existe  = true;
                                }
                            }

                            if(!$existe){
                                $sqlAddVariacion = "insert into variacionesproductos (idproducto, idcolor) values (?, ?);";
                                $stmtAddVariacion = $this->conex->prepare($sqlAddVariacion);
                                $stmtAddVariacion->execute([$id, $idCompVariacion]);
                            }
                            $existe = false;
                        }





                        //Volvemos a ejecutar el select para obtener el id de todas las variaciones actualizados, ya lo necesitamos para el sotck
                        $stmtVariaciones->execute([$id]);

                        $variacionesActualizadas = $stmtVariaciones->fetchAll(PDO::FETCH_ASSOC);

                    }



                    //Comprobaciones del stock
                    $sqlStock = "select * from stock where idproducto = ?";

                    $stmtStock = $this->conex->prepare($sqlStock);

                    $stmtStock->execute([$id]);


                    if($stmtStock->rowCount() > 0){
                        $stockVariaciones = $stmtStock->fetchAll(PDO::FETCH_ASSOC);

                        $existe = false;

                        foreach($stockVariaciones as $fila){
                            foreach($variacionesActualizadas as $nuevasVariaciones){

                                if($fila["IDVARIACION"] == $nuevasVariaciones["Id"]){
                                    $existe = true;
                                    foreach($idColores as $colinchis){
                                        if($colinchis["ID"] == $nuevasVariaciones["IDCOLOR"]){
                                            foreach($infoColores as $colorinchis2){
                                                if ($colorinchis2["Color"] == $colinchis["Colores"]){
                                                    $nuevoStock = $colorinchis2["Stock"];
                                                }
                                            }

                                        }
                                    }

                                    if($fila["stock"] != $nuevoStock){
                                        $sqlUpdateStock = "update stock set stock = ? where idproducto = ? and idvariacion = ?;";

                                        $stmtUpdateStock = $this->conex->prepare($sqlUpdateStock);

                                        $stmtUpdateStock->execute([$nuevoStock, $fila["IDPRODUCTO"], $fila["IDVARIACION"]]);
                                    }
                                }
                            }

                            if(!$existe){
                                $sqlDeleteStock = "delete from stock where idproducto = ? and idvariacion = ?;";

                                $stmtDeleteStock = $this->conex->prepare($sqlDeleteStock);

                                $stmtDeleteStock->execute([$id, $fila["Id"]]);                            
                            }

                            $existe = false;
                        }


                        foreach($variacionesActualizadas as $nuevasVariaciones){
                            foreach($stockVariaciones as $fila){
                                if($nuevasVariaciones["Id"] == $fila["IDVARIACION"]){
                                    $existe = true;
                                }
                            }

                            if(!$existe){
                                foreach($idColores as $colinchis){
                                        if($colinchis["ID"] == $nuevasVariaciones["IDCOLOR"]){
                                            foreach($infoColores as $colorinchis2){
                                                if ($colorinchis2["Color"] == $colinchis["Colores"]){
                                                    $nuevoStock = $colorinchis2["Stock"];
                                                }
                                            }

                                        }
                                    }
                                $sqlAddStock = "insert into stock (idproducto, idvariacion, stock) values (?, ?, ?);";
                                $stmtAddStock = $this->conex->prepare($sqlAddStock);
                                $stmtAddStock->execute([$id, $nuevasVariaciones["Id"], $nuevoStock]);
                                
                            }
                            $existe = false;
                        }


                    }


                    //Comprobaciones de las tallas
                    $sqlTallas = "select * from tallasproductos where idvariacion in (select id from variacionesproductos where idproducto = ?);";

                    $stmtTallas = $this->conex->prepare($sqlTallas);

                    $stmtTallas->execute([$id]);

                    if($stmtTallas->rowCount() > 0){
                        $tallasVariaciones = $stmtTallas->fetchAll(PDO::FETCH_ASSOC);
                        $existe = false;
                        $colorReferencia = "";

                        //Recorremos tallas para ver si tenemos que borrar alguna
                        foreach($tallasVariaciones as $filaTallas){
                            foreach($variacionesActualizadas as $variacionesTallas){
                                if($variacionesTallas["Id"] == $filaTallas["IDVARIACION"]){
                                    
                                    $idColorTalla = $variacionesTallas["IDCOLOR"];

                                    foreach($idColores as $coloresServidor){
                                        if($coloresServidor["ID"] == $idColorTalla){
                                            $colorReferencia = $coloresServidor["Colores"];
                                        }
                                    }
                                    //Bucle para recorreer infoTallas
                                    foreach($infoTallas as $tallasUsuario){
                                        if($filaTallas["IDTALLA"] == $tallasUsuario["ID"]){
                                            //Bucle para recorrer los colores de cada talla y comprobar que existe
                                            foreach($tallasUsuario["Colores"] as $coloresUsuario){
                                                if($colorReferencia == "{$coloresUsuario["ColorPatron"]} y {$coloresUsuario["ColorBase"]}"){
                                                    $existe = true;
                                                }
                                            }
                                        }
                                    }
                                }

                            }

                            if(!$existe){
                                $sqlDeleteTalla = "delete from tallasproductos where idvariacion = ? and idtalla = ?;";

                                $stmtDeleteTalla = $this->conex->prepare($sqlDeleteTalla);

                                $stmtDeleteTalla->execute([$filaTallas["IDVARIACION"], $filaTallas["IDTALLA"]]);
                            }

                            $existe = false;
                        }




                        //Recorremos las nuevas variaciones para ver que tallas le tenemos que poner
                        foreach($infoTallas as $datosUsuario){
                            foreach($datosUsuario["Colores"] as $coloresUsuario){
                                $colorAux = "{$coloresUsuario["ColorPatron"]} y {$coloresUsuario["ColorBase"]}";

                                foreach($idColores as $coloresServidor){
                                    if($colorAux == $coloresServidor["Colores"]){
                                        $idColor = $coloresServidor["ID"];
                                    }
                                }
                                $existe = false;

                                foreach($variacionesActualizadas as $datosVariacion){
                                    if($datosVariacion["IDCOLOR"] == $idColor){
                                        foreach($tallasVariaciones as $tallasServidor){
                                            if($tallasServidor["IDVARIACION"] == $datosVariacion["Id"] && $datosUsuario["ID"] == $tallasServidor["IDTALLA"]){
                                                $existe = true;
                                            }

                                        }
                                    }
                                    
                                }
                                
                            }


                            if(!$existe){
                                $sqlInsertTallas = "insert into tallasproductos (idvariacion, idtalla) values (?, ?);";

                                $stmtInsertTallas = $this->conex->prepare($sqlInsertTallas);

                                $stmtInsertTallas->execute([$datosVariacion["Id"], $datosUsuario["ID"]]);
                            }
                            $existe = false; 
                        }

                    }


                    if($idDescuento == "null" || $idDescuento == ""){
                        $idDescuento = null;
                    }

                    $sqlUpdateProducto = "update productos set nombre = ?, descripcion = ?, precio = ?, categoriaid = ?, coleccionid = ?, descuentoid = ? where id = ?;";
                    $stmtUpdateProducto = $this->conex->prepare($sqlUpdateProducto);

                    $stmtUpdateProducto->execute([$nombre, $description, $precio, $idCategoria, $idColeccion, $idDescuento, $id]);


                $this->conex->commit();
                
                return "Producto Modificado";
                
            }catch(PDOException $e){
                $this->conex->rollBack();
                return "Algo ha salido mal, contacte al administrador-->" . $e->getMessage();
            }
        }








        public function addProduct($datos){

            $uploadDir = 'uploads/'; // Ruta absoluta a la carpeta 'uploads'
            $tiposPermitidos = ['image/jpeg', 'image/png', 'image/webp'];
            
            // Array para recolectar los resultados del procesamiento de fotos
            $fotosResultados = []; 
            
            
            try{

                //Datos del producto
                $id = $datos["ID"];
                $nombre = $datos["Nombre"];
                $idCategoria = $datos["Categoria"];
                $idColeccion = $datos["Coleccion"];
                $precio = $datos["Precio"];
                $description = $datos["Descripcion"];
                $idDescuento =  $datos["Descuento"];

                //Datos relacionados con el produccto
                $infoTallas = $datos["Tallas"];
                $infoColores = $datos["Colores"];
                $rutasFotos = $datos["Fotos"];


                
                // print_r($datos);
                
                $this->conex->beginTransaction();
                //Comprobamos que todos los datos del producto no existan en otro producto ya
                if($idDescuento == "null" || $idDescuento == ""){
                        $idDescuento = null;
                    }

                if($idDescuento){
                    $sqlComprobarProducto = "select id from productos where nombre = ? and descripcion = ? and precio = ? and categoriaid = ? and coleccionid = ? and descuentoid = ?;";
                    $stmtComprobar = $this->conex->prepare($sqlComprobarProducto);
    
                    $stmtComprobar->execute([$nombre, $description, $precio, $idCategoria, $idColeccion, $idDescuento]);
                }else{
                    $sqlComprobarProducto = "select id from productos where nombre = ? and descripcion = ? and precio = ? and categoriaid = ? and coleccionid = ? and descuentoid is null;";
                    $stmtComprobar = $this->conex->prepare($sqlComprobarProducto);
    
                    $stmtComprobar->execute([$nombre, $description, $precio, $idCategoria, $idColeccion]);
                    
                }



                if($stmtComprobar->rowCount() > 0){
                    $id = $stmtComprobar->fetch()["id"];
                }

                if($id == ""){                    
                    $sqlInsertProducto = "insert into productos (nombre, descripcion, precio, categoriaid, coleccionid, descuentoid) values (?, ?, ?, ?, ?, ?);";
                    $stmtInsertProducto = $this->conex->prepare($sqlInsertProducto);
                    
                    $stmtInsertProducto->execute([$nombre, $description, $precio, $idCategoria, $idColeccion, $idDescuento]);
                    
                    $id = $this->conex->lastInsertId();
                }else{
                    $this->conex->rollBack();
                    return  "El producto se ha creado anteriormente";
                }


                    if (is_array($rutasFotos) && !empty($rutasFotos)) {
                            $sqlInsertFoto = "insert into imagenes (Ruta, IDPRODUCTO) values (?, ?);";
                            $stmtInsertFoto = $this->conex->prepare($sqlInsertFoto);
                            

                            foreach ($rutasFotos as $foto) {
                                $rutaBase64 = $foto['Ruta'];
                                $alt = $foto['Alt'];

                                if (preg_match('/^data:(image\/(jpeg|png|gif|webp));base64,/', $rutaBase64, $matches)) {
                                    $mimeType = $matches[1];
                                    $extension = explode('/', $mimeType)[1]; 
                                    $base64Data = substr($rutaBase64, strpos($rutaBase64, ',') + 1);
                                    $imageData = base64_decode($base64Data);
                                    
                                    $cleanedAlt = preg_replace('/[^a-zA-Z0-9-]/', '', str_replace(' ', '-', strtolower($alt)));
                                    
                                    // Si el 'alt' está vacío después de limpiar, usamos un nombre único
                                    $finalFileName = '';
                                    $pattern = '/^[a-z0-9-]+(?:-[a-z0-9]+){1,}$/';
                                    
                                    if (!empty($cleanedAlt) && preg_match($pattern, $cleanedAlt)) {
                                        $finalFileName = $cleanedAlt . '.' . $extension;
                                    } else {
                                        $finalFileName = "{$nombre}-sin-color-reverso.{$extension}";
                                    }
                                    
                                    $destPath = $uploadDir . $finalFileName;
                                    
                                    
                                    if(file_exists($destPath)){
                                        unlink($destPath);
                                    }
                                    
                                    
                                    // Guardar el archivo binario
                                    if (file_put_contents($destPath, $imageData) !== false) {
                                        
                                        $stmtInsertFoto->execute([$destPath, $id]);
                                        
                                    }else {
                                        $this->conex->rollBack();
                                        return "No se ha podido subir la imagen";
                                    }
                                }else{
                                    $this->conex->rollBack();
                                    return "Fallo con las miagenes subidas";
                                }
                            }
                        
                    }


                    //Comprobación de los colores
                    $sql = "select id, concat(colorPatron, ' y ', colorBase) as Colores from colores order by id    ";

                    $stmt = $this->conex->prepare($sql);
                    
                    $stmt->execute();

                    if($stmt->rowCount() > 0){
                        //Sacamos todos los colores, para comprobar si el usario ha añadido alguno nuevo o no
                        $coloresDB = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        $existe = false;
                        $idColores = [];

                        for($i = 0; $i < count($infoColores); $i++){   
                            foreach($coloresDB as $fila){
                                if($fila["Colores"] == $infoColores[$i]["Color"]){
                                    $existe = true;
                                    array_push($idColores, ["ID" => $fila["id"], "Colores" => trim($fila["Colores"])]);
                                }
                            }

                            if(!$existe){
                                
                                [$colorPatron, $colorBase] = explode(" y ", $infoColores[$i]["Color"]);
                                

                                $sqlAddColor = "insert into colores (colorPatron, colorBase) values (?, ?);";

                                $stmtAddColor = $this->conex->prepare($sqlAddColor);

                                $stmtAddColor->bindParam(1, $colorPatron, PDO::PARAM_STR);
                                $stmtAddColor->bindParam(2, $colorBase, PDO::PARAM_STR);

                                $stmtAddColor->execute();
 
                                $idNuevoColor = $this->conex->lastInsertId();
                                array_push($idColores, ["ID" => $idNuevoColor, "Colores" => trim("$colorPatron y $colorBase")]);

                            }

                            $existe = false;

                        }
                    }

                    // print_r($infoTallas);


                    //Comprobacion de variaciones
                        //Recorremos los colores para saber cual hemos añadido
                        for($i = 0; $i < count($idColores); $i++){
                                $sqlAddVariacion = "insert into variacionesproductos (idproducto, idcolor) values (?, ?);";
                                $stmtAddVariacion = $this->conex->prepare($sqlAddVariacion);
                                $stmtAddVariacion->execute([$id, $idColores[$i]["ID"]]);
                        }
                        $sqlVariaciones = "select * from variacionesproductos where idproducto = ?";
                        $stmtVariaciones = $this->conex->prepare($sqlVariaciones);
                        $stmtVariaciones->execute([$id]);
                        $variacionesActualizadas = $stmtVariaciones->fetchAll(PDO::FETCH_ASSOC);
                    //Comprobaciones del stock
                        foreach($variacionesActualizadas as $nuevasVariaciones){
                            foreach($idColores as $colinchis){
                                if($colinchis["ID"] == $nuevasVariaciones["IDCOLOR"]){
                                    foreach($infoColores as $colorinchis2){
                                        if ($colorinchis2["Color"] == $colinchis["Colores"]){
                                            $nuevoStock = $colorinchis2["Stock"];
                                        }
                                    }

                                }
                            }
                            $sqlAddStock = "insert into stock (idproducto, idvariacion, stock) values (?, ?, ?);";
                            $stmtAddStock = $this->conex->prepare($sqlAddStock);
                            $stmtAddStock->execute([$id, $nuevasVariaciones["Id"], $nuevoStock]);
                        }
    


                        $existe = false;
                        $colorReferencia = "";


                        //Recorremos las nuevas variaciones para ver que tallas le tenemos que poner
                        // print_r($infoTallas);
                        foreach($infoTallas as $datosUsuario){
                            if(isset($datosUsuario["Colores"])){
                                foreach($datosUsuario["Colores"] as $coloresUsuario){
                                    $colorAux = "{$coloresUsuario["ColorPatron"]} y {$coloresUsuario["ColorBase"]}";
                                    
                                    foreach($idColores as $coloresServidor){
                                        if($colorAux == $coloresServidor["Colores"]){
                                            $idColor = $coloresServidor["ID"];
                                        }
                                    }
                                    // $agregar = false;
                                    foreach($variacionesActualizadas as $datosVariacion){
                                        if($datosVariacion["IDCOLOR"] == $idColor){
                                            $idVar = $datosVariacion["Id"];
                                            $agregar = true;
                                        }
                                        
                                        if($agregar){
                                            $sqlInsertTallas = "insert into tallasproductos (idvariacion, idtalla) values (?, ?);";
                                            
                                            $stmtInsertTallas = $this->conex->prepare($sqlInsertTallas);
                                            
                                            $stmtInsertTallas->execute([$idVar, $datosUsuario["ID"]]);
                                        }
                                        $agregar = false; 
                                    }
                                    
                                }
                                
                                
                            }
                        }

                    


                    


                $this->conex->commit();
                
                return "Producto creado";
                
            }catch(PDOException $e){
                $this->conex->rollBack();
                return "Algo ha salido mal, contacte al administrador-->" . $e->getMessage();
            }
        }




        public function eliminarProd($id){

            try{
                //Sacamos las fotos del producto para borrarlas de la carpeta del servidor

                $sqlFotos = "select * from imagenes where idproducto = ?;";
                $stmtFotos = $this->conex->prepare($sqlFotos);


                if($stmtFotos->execute([$id])){
                    $fotos = $stmtFotos->fetchAll(PDO::FETCH_ASSOC);
                }


                //Borramos el producto
                $sqlProd = "delete from productos where id = ?;";

                $stmtProd = $this->conex->prepare($sqlProd);

                if($stmtProd->execute([$id])){
                    if($fotos){
                        foreach($fotos as $datosFoto){
                            if(file_exists($datosFoto["Ruta"])){
                                unlink($datosFoto["Ruta"]);
                            }
                        }
                    }
                    return "Producto borrado correctamente";
                }else{
                    return "No se ha encontrado el producto";
                }





            }catch(PDOException $e){
                return $e->getMessage();
            }



        }

    }

