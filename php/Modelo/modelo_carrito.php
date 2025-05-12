<?php

    require_once "conexion.php";

    class ModeloCarrito{

        public function __construct(){
            $conex = ModeloConexion::conectar();
        }


        public function addCarrito(){

        }


        public function mostrarCarrito($jsonDecode){
            //Declaración de variables
            $arrayProductos = [];
            $producto = [];
            $contadorProds = 0;
            $html = "";


            //Hacemos un bucle para guardar todos los productos que nos pasan como atributo
            for($i = 0; $i < count($jsonDecode); $i++){
                //Generamos el identificador de cada producto
                $index = "Producto$contadorProds";
                //Separamos los datos, en clave valor para guardarlos dentro del producto
                $celda = explode(":", $jsonDecode[$i]);

                //Comprobamos que la celda en la clave de la celda es ID y el contador es distinto de 0, para comprobar que cambiamos de producto
                if($celda[0] == "ID" && $i != 0){
                    //Guardamos el producto dentro del array de productos
                    $arrayProductos += [$index => $producto];
                    //Vaciamos el producto
                    $producto = [];
                    //Aumentamos el indice de los productos
                    $contadorProds += 1;
                }

                //Construimos el producto
                $producto  += [$celda[0] => $celda[1]];

                //Comprobamos que hemos llegado al final de los productos para guardar el último producto
                if($i == (count($jsonDecode) - 1)){
                    $arrayProductos += [$index => $producto];
                }
            }
        
            //Construimos el html para cada producto
            foreach($arrayProductos as $tarjeta){
                //Comprobamos que la categoria no sea "Accesorios"
                if($tarjeta["Categoria"] != "Accesorios"){

                    $html .= "
                    <div class='producto'>
                        <span class='carrImg'><img src='{$tarjeta['Foto']}' alt='Foto del producto {$tarjeta["Nombre"]}'></span>
                        <span class='elmRop'>&times;</span>
                        <span class='tituloCarr'><h4>{$tarjeta["Nombre"]}</span>
                        <span class='unidades'>Unidades:<input type='number' name='unidades' id='unidades' value='{$tarjeta["Cantidad"]}' min=1></span>
                        <span class='precioCarr'>Precio: <span id='precio'>{$tarjeta["Precio"]}</span> €</span>
                        <span class='talla'>Talla: {$tarjeta["Talla"]}</span>
                        <span class='idtalla' hidden>{$tarjeta["IDTalla"]}</span>
                    </div>
                    ";
                }else{
                    $html .= "
                    <div class='producto'>
                        <span class='carrImg'><img src='{$tarjeta['Foto']}' alt='Foto del producto {$tarjeta["Nombre"]}'></span>
                        <span class='elmRop'>&times;</span>
                        <span class='tituloCarr'><h4>{$tarjeta["Nombre"]}</span>
                        <span class='unidades'>Unidades:<input type='number' name='unidades' id='unidades' value='{$tarjeta["Cantidad"]}' min=1></span>
                        <span class='precioCarr'>Precio: <span id='precio'>{$tarjeta["Precio"]}</span> €</span>
                    </div>
                    ";
                }
            }
            //Devolvemos el html de todos los productos
            return $html;
        }



    }
