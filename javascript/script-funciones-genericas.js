//Declaración de variables 
const producto = document.getElementsByClassName("producto")[0];
const almLocal = window.localStorage
let tallaSELECT = "";
let colorSELECT = "";
let productos = [];

//Creamos el botón para limpiar las opciones del formulario
const btnLimpiar = document.createElement("button");
btnLimpiar.setAttribute("onclick", "limpiar()");
btnLimpiar.textContent = "LIMPIAR";


//Función para añadir al carrito
function addToCart() {
    //Recuperamos la cantidad del producto
    let cantidad = parseInt(document.getElementById("cantidad").value);
    let contador = 0;
    //Comprobamos que la cantidad que quiere añadir, no supera el stock disponible
    if (cantidad <= unidades) {

        

        //Comprobamos que si el  carrito ya está creado
        if (almLocal.getItem("carrito")) {
            //Transformamos el JSON del carrito a un array para poder añadir nuevos productos
            productos = JSON.parse(almLocal.getItem("carrito"));
            contador = productos.length;
        }

        //Comprobamos la categoria del producto
        if (productCategoria != "Accesorios") {
            //Comprobamos que tenemos seleccionado el color y la talla
            if (tallas.value != "Elija una" && colores.value != "Elija una" && tallas.value != "" && colores.value != "") {
                //Generamos el objeto prenda con la información que necesitamos guardar dentro del carrito
                const prenda = {
                    "IdProd": parseInt(productId, 10),
                    "Categoria": productCategoria,
                    "Nombre": nombre.textContent,
                    "Precio": parseFloat(precio.textContent),
                    "Foto": imagen.getAttribute("src"),
                    "Cantidad": parseInt(cantidad, 10),
                    "Colores": colores.value,
                    "Talla": tallas.value,
                    "IDTalla": arrayIDTALLAS[tallas.value],
                    "contador" : contador
                };

                if(comprobacionArticulo(productos, prenda)){
                    generarAlerta("Producto duplicado");
                }else{
                    //Añadimos al array de productos la prenda
                    productos = [...productos, prenda];
                    
                    //Actualizamos el carrito
                    almLocal.setItem("carrito", JSON.stringify(productos));
                    contador += 1;
                    generarAlerta("Carrito Actualizado");
                }
            }else{
                generarAlerta("Por favor compruebe las opciones");
            }
        } else {
            //Comprobamos que haya elejido una opción de los colores disponibles 
            if (colores.value != "Elija una" && colores.value != "") {

                //Generamos el objeto accesorio con los datos que necesitamos guardar
                const accesorio = {
                    "IdProd": parseInt(productId, 10),
                    "Categoria": productCategoria,
                    "Nombre": nombre.textContent,
                    "Precio": parseFloat(precio.textContent),
                    "Foto": imagen.getAttribute("src"),
                    "Cantidad": parseInt(cantidad, 10),
                    "Colores": colores.value,
                    "contador" : contador
                };

                if(comprobacionArticulo(productos, accesorio)){
                    generarAlerta("Producto duplicado");
                }else{
                    //Añadimos al array de productos la prenda
                    productos = [...productos, accesorio];
                    
                    //Actualizamos el carrito
                    almLocal.setItem("carrito", JSON.stringify(productos));
                    contador += 1;
                    generarAlerta("Carrito Actualizado");
                }
            }else{
                generarAlerta("Por favor seleccione una opción");
            }
        }
    }else{
        generarAlerta("No hay stock suficiente");
    }

}


//Función para limpiar los filtros 
function limpiar() {
    //Comprobamos si se ha seleccionado un color
    if (colorSELECT != "" && colorSELECT != "Elija una") {
        colorSELECT = "";
        colores.value = "Elija una";
    }
    //Comprobamos si se ha seleccionado una talla 
    if (tallaSELECT != "" && tallaSELECT != "Elija una") {
        tallaSELECT = "";
        tallas.value = "Elija una";
    }

    //Borramos el botón
    producto.removeChild(btnLimpiar);
    if (productCategoria != "Accesorios") {
        //Generamos los selects por defecto solo cuando no es un accesorio
        generarSelects();
    }

    let patron = /home/;

    if(patron.test(jsonFINAL["Foto"][0])){
        imagen.setAttribute("src", jsonFINAL["Foto"][0]);
    }

    stock.textContent = "Quedan: ";
}

function sacarStock() {
    unidades = stock.innerHTML.split(":")[1];
    return unidades;
}

//Función para generar alerta
function generarAlerta(mensaje){
    //Guardamos el div de alerta anterior, para evitar alertas multiples
    let alertaRepetida = document.querySelector(".alerta");

    //En caso de que exista, borramos el div
    if(alertaRepetida){
        alertaRepetida.remove();
    }
    //Creamos el div de la alerta y lo añadimos al body
    let div = document.createElement("div");
    div.classList.add("alerta");
    div.textContent = mensaje;
    document.body.appendChild(div);

    //Ponemos un tiempo de espera para que el usuario lea el mensaje y desaparezca
    setTimeout(() =>{
        div.remove();
    }
    , 2000);
}


//Función para comprobar la existencia de un articulo dentro del carrito y evitar duplicados
function comprobacionArticulo(productos, articulo){

    //Los primero que hacemos es comparar la categoría del articulo que vamos a añadir, para no tener que compararlo en cada iteración del bucle,
    //además dependiendo de la categoría buscaremos características distintas
    if(articulo["Categoria"] != "Accesorios"){    
        for(objeto of productos){
            //Comprobamos que el id, los colores y la talla sean iguales, eso quiere decir que la prenda está repetido en el carrito
            if(articulo["ID"] === objeto["ID"] && articulo["Colores"] === objeto["Colores"] && articulo["Talla"] === objeto["Talla"]){
                return true;
            }
        }
    }else{
        for(objeto of productos){
            //Comprobamos que el id y los colores sean iguales, eso quiere decir que el accesorio está repetido en el carrito
            if(articulo["ID"] === objeto["ID"] && articulo["Colores"] === objeto["Colores"]){
                return true;
            }
        }
    }

    //Por defecto devolvemos false
    return false;
}


async function  cerrarSesion (){
    //Generamos un array con los datos que vamos a enviar
    const dataToSend = {
        action: "cerrarSesion",
    };
    try{

        //Enviamos la petición al servidor con los datos necesarios
        fetch("../index.php?action=cerrarSesion", {
            method: "POST",
            body: JSON.stringify(dataToSend),
            headers: {
                "Content-Type": "application/json",
            },
        })
            //Capturamos posibles errores en la respuesta del servidor
            .catch((error) => console.error("Error:", error))
            //Convertimos el objeto respuesta en texto, para poder leerlo
            .then(respuesta => {
                window.location.reload();
            });
        }catch(error){
            console.error("Error antes del fetch", error);
        }
}
    

function capitalize(cadena){

    let cadenaAux = cadena.toLowerCase();
    cadenaAux = cadenaAux.charAt(0).toUpperCase() + cadenaAux.slice(1);

    return cadenaAux;
}