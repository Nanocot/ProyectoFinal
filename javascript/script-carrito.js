//Declaración de variables
const carrito = localStorage.getItem("carrito");
const precioTotal = document.getElementById("precioTotal");
const btnActualizar = document.getElementById("enviar");
const btnBorrar = document.getElementById("borrar");
const btnEliminar = document.getElementsByClassName("elmRop");
const carritoDiv = document.querySelector(".carrito");




async function enviarDatos(){
    const dataToSend = {
        action: "generarCarrito",
        carrito: carrito // Tu objeto carrito
    };


        fetch("../index.php?action=generarCarrito", {
            method: "POST",
            body: JSON.stringify(dataToSend),
            headers: {
                "Content-Type": "application/json",
            },
        })
        .catch((error) => console.error("Error:", error))
        .then(response => response.text())
        .then(html => {
            // console.log("Respuesta HTML recibida:", html);
            carritoDiv.innerHTML = html;
            //Calculamos el total del carrito
            calcularTotal();
        });
}

function calcularTotal(){
    let preciofinal = 0;
    const productos = document.querySelectorAll(".producto");
    
    // console.log(productos);
    for(let i = 0; i < productos.length; i++){
        unidades = parseInt(productos[i].querySelector("#unidades").value);
        precio = parseFloat(productos[i].querySelector("#precio").innerHTML);
        preciofinal += parseFloat((unidades * precio))  ;
    }
    preciofinal = preciofinal.toFixed(2)
    precioTotal.innerHTML = `${preciofinal}`;
}


function borrarCarrito(){
    localStorage.removeItem("carrito");
    carritoDiv.innerHTML = "";
    generarAlerta("Carrito Borrado");
}

function actualizarCarrito(){
    carritoTemporal = JSON.parse(carrito);
    console.log(carritoTemporal);
    const productos = document.querySelectorAll(".producto");

    for(let i = 0; i < productos.length; i++){
        unidades = productos[i].querySelector("#unidades").value;
        carritoTemporal[i]["Cantidad"] = unidades;
    }

    localStorage.setItem("carrito", JSON.stringify(carritoTemporal));

    calcularTotal();
}

function eliminarProducto(target){
    
}


enviarDatos();

btnActualizar.addEventListener("click", (event)=>{
    actualizarCarrito();
});

btnBorrar.addEventListener("click", (event) =>{
    borrarCarrito();
    window.refresh();
});


