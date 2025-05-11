//Declaración de variables 
const producto = document.getElementsByClassName("producto")[0];
let tallaSELECT = "";
let colorSELECT = "";
const almLocal = window.localStorage;
let productos = [];

//Creamos el botón para limpiar las opciones del formulario
const btnLimpiar = document.createElement("button");
btnLimpiar.setAttribute("onclick", "limpiar()");
btnLimpiar.textContent = "LIMPIAR";


//Función para añadir al carrito
function addToCart() {
    //Recuperamos la cantidad del producto
    let cantidad = document.getElementById("cantidad").value;
    
    //Comprobamos la categoria del producto
    if(productCategoria != "Accesorios"){
        //Transformamos el JSON del carrito a un array para poder añadir nuevos productos
        productos = JSON.parse(almLocal.getItem("carrito"));    
        //Comprobamos que tenemos seleccionado el color y la talla
        if(tallas.value != "Elija una" && colores.value != "Elija una" && tallas.value != "" && colores.value != ""){
            //Generamos el objeto prenda con la información que necesitamos guardar dentro del carrito
            const prenda = {
                "ID": parseInt(productId, 10), 
                "Categoria" : productCategoria,
                "Nombre" : nombre.textContent,  
                "Precio" : parseFloat(precio.textContent), 
                "Foto" : imagen.getAttribute("src"),
                "Cantidad" : parseInt(cantidad, 10),
                "Colores": colores.value,
                "Talla": tallas.value,
                "IDTalla": arrayIDTALLAS[tallas.value] 
            };

            //Añadimos al array de productos la prenda
            productos = [...productos, prenda];

            //Actualizamos el carrito
            almLocal.setItem("carrito", JSON.stringify(productos));
        }
    }else{
        //Comprobamos que haya elejido una opción de los colores disponibles 
        if(colores.value != "Elija una" && colores.value != ""){

            //Generamos el objeto accesorio con los datos que necesitamos guardar
            const accesorio = {
                "ID": parseInt(productId, 10),
                "Categoria" : productCategoria, 
                "Nombre" : nombre.textContent,  
                "Precio" : parseFloat(precio.textContent), 
                "Foto" : imagen.getAttribute("src"),
                "Cantidad" : parseInt(cantidad, 10),
                "Colores": colores.value
            };
            
            //Añadimos al array de productos el accesorio
            productos = [...productos, accesorio];

            //Actualizamos el carrito
            almLocal.setItem("carrito", JSON.stringify(productos));

        }
    }

}


//Función para limpiar los filtros 
function limpiar(){
    //Comprobamos si se ha seleccionado un color
    if(colorSELECT != "" && colorSELECT != "Elija una"){
        colorSELECT = "";
        colores.value = "Elija una";
    }
    //Comprobamos si se ha seleccionado una talla 
    if(tallaSELECT != "" && tallaSELECT != "Elija una"){
        tallaSELECT = "";
        tallas.value = "Elija una";
    }

    //Borramos el botón
    producto.removeChild(btnLimpiar);
    if(productCategoria != "Accesorios"){
        //Generamos los selects por defecto solo cuando no es un accesorio
        generarSelects();
    }
}