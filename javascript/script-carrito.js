//Declaración de variables
let carrito = localStorage.getItem("carrito");
const precioTotal = document.getElementById("precioTotal");
const btnBorrar = document.getElementById("borrar");
const carritoDiv = document.querySelector(".carrito");
const controles = document.querySelector(".controles");


//Función para enviar los datos al servidor
async function enviarDatos(){
    //Generamos un array con los datos que vamos a enviar
    const dataToSend = {
        action: "generarCarrito",
        carrito: carrito
    };
    try{

        //Enviamos la petición al servidor con los datos necesarios
        fetch("../index.php?action=generarCarrito", {
            method: "POST",
            body: JSON.stringify(dataToSend),
            headers: {
                "Content-Type": "application/json",
            },
        })
        //Capturamos posibles errores en la respuesta del servidor
        .catch((error) => console.error("Error:", error))
        //Convertimos el objeto respuesta en texto, para poder leerlo
        .then(response => response.text())
        .then(html => {
            //Mostramos el carrito en la página
            carritoDiv.innerHTML = html;
            //Calculamos el total del carrito
            calcularTotal();
            //Activamos los listeners
            activarListeners();
            
            if(html){
                let btnComprar = document.createElement("button");
                btnComprar.setAttribute("type", "submit");
                btnComprar.setAttribute("id", "comprar");
                btnComprar.innerText = "Comprar";
                controles.appendChild(btnComprar);
            }
            
        });
    }catch(error){
        console.error("Error antes del fetch", error);
    }


}


//Función para calcular el total del carrito
function calcularTotal(){
    //Declaración de variables
    let preciofinal = 0;
    const productos = document.querySelectorAll(".producto");
    
    //Para cada productos, contamos las unidades y las multiplicamos por el precio
    for(let i = 0; i < productos.length; i++){
        unidades = parseInt(productos[i].querySelector("#unidades").value);
        precio = parseFloat(productos[i].querySelector("#precio").innerHTML);
        preciofinal += parseFloat((unidades * precio))  ;
    }

    //Parseamos el precio final a string para mostrarlo en la página HTML
    preciofinal = preciofinal.toFixed(2)
    precioTotal.innerHTML = `${preciofinal}`;
}

//Función para borrar el carrito
function borrarCarrito(){
    //Borramos el localStorage
    localStorage.removeItem("carrito");
    //Vaciamos el html
    if(carritoDiv.innerHTML != ""){
        let btnComprar = document.querySelector("#comprar");
        btnComprar.remove();
    }
    carritoDiv.innerHTML = "";
    //Generamos una alerta
    generarAlerta("Carrito Borrado");
}

//Funcón para actualizar el carrito, cuando cambiamos las cantidades de los productos
function actualizarCarrito(){
    //Declaración de variables
        //Generamos un array con el carrito
    carritoTemporal = JSON.parse(carrito);
    const productos = document.querySelectorAll(".producto");

    //Comprobamos las unidades de los productos y las guardamos en el carrito
    for(let i = 0; i < productos.length; i++){
        unidades = productos[i].querySelector("#unidades").value;
        carritoTemporal[i]["Cantidad"] = unidades;
    }

    //Una vez que se han actualizado las cantidades, guardamos el carrito en LocalStorage
    localStorage.setItem("carrito", JSON.stringify(carritoTemporal));


    //Volvemos a calcular el total con las nuevas cantidades
    calcularTotal();
}


//Función para eliminar un producto del carrito
function eliminarProducto(id, div){
    //Declaración de variables
    let carritoTemporal  = JSON.parse(carrito);
    let aux = false;



    //Recorremos el carrito temporal (no ponemos que sea <= ya que al comprobar carritoTemporal[i], si ponemos igual salta error y se para la ejecución)
    for(let i = 0; i < carritoTemporal.length; i++){
        //Comprobamos que el id sea igual al contador del carrito
        if(carritoTemporal[i]["contador"] == id){
            //Cuando coinciden borramos esa casilla y activamos la variable auxiliar
            carritoTemporal.splice(i, 1);
            aux = true;
        }

        //Si la variable auxiliar es verdadera, significa que hemos borrado una casilla, por lo que el contador debe ser una unidad menor, en caso contrario el contador será igual a i
        if(aux){
            div[i].setAttribute("id", (i-1).toString());
        }else{
            div[i].setAttribute("id", i.toString());
        }

        // Comprobamos que hemos llegado al final del carrito, ya que al borrar una celda la longitud cambia
        if(i == (carritoTemporal.length - 1)){
            div[i+1].setAttribute("id", i.toString());
        }

        if(carritoTemporal.length > 0){
            //Al final cambiamos el atributo contador, para que los objetos se identifiquen con la nueva posición que tienen en el array
            carritoTemporal[i]["contador"] = i;
            //Por último guardamos el carrito en LocalStorage
            localStorage.setItem("carrito", JSON.stringify(carritoTemporal));
        }else{
            carritoDiv.innerHTML = "";
            let btnComprar = document.querySelector("#comprar");
            btnComprar.remove();
            localStorage.removeItem("carrito");
        }
    }

    

    

}




//Función para activar los Listeners  de la página
function activarListeners(){
    //Sacamos todos los botones de eliminar
    const btnEliminar = document.getElementsByClassName("elmRop");
    const cantidades = document.querySelectorAll("input");

    // btnActualizar.addEventListener("click", (event)=>{
    //     actualizarCarrito();
    // });

    btnBorrar.addEventListener("click", (event) =>{
        borrarCarrito();
        calcularTotal();
    });

    //Por cada botón de eliminar añadimos el evento de click 
    for(let boton of btnEliminar){
        boton.addEventListener("click", (event)=>{
            //Cada vez que clicamos el botón recuperamos el carrito
            carrito = localStorage.getItem("carrito");
            //Recogemos todos los productos del carrito del DOM
            const productos  = document.querySelectorAll(".producto");
            //Guardamos el id del producto que queremos eliminar
            let id = event.target.parentNode.getAttribute("id");
            //Llamamos a la función eliminar producto 
            eliminarProducto(id, productos);
            //Borramos el producto
            event.target.parentNode.remove();
            //Calculamos el total actualizado
            calcularTotal();
            //Generamos la alerta de la actualización
            generarAlerta("Carrito Actualizado");
        });
    }  
    
    
    for(let casilla of cantidades){
        casilla.addEventListener("change", (event) => {
            actualizarCarrito();
        });
        // console.log(casilla);
    }


}

enviarDatos();

