//Declaración de variables
const carrito = localStorage.getItem("carrito");
const precioTotal = document.getElementById("precioTotal");
const btn = document.getElementById("enviar");




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
            document.querySelector(".carrito").innerHTML = html;
            //Calculamos el total del carrito
            calcularTotal();
        });
}

function calcularTotal(){
    let preciofinal = 0;
    const carrito = document.querySelectorAll(".producto");
    
    // console.log(carrito);
    for(let i = 0; i < carrito.length; i++){
        unidades = parseInt(carrito[i].querySelector("#unidades").value);
        precio = parseFloat(carrito[i].querySelector("#precio").innerHTML);
        preciofinal += parseFloat((unidades * precio))  ;
        // console.log(typeof(unidades));
        console.log((unidades * precio));
        console.log(preciofinal);
    }
    preciofinal = preciofinal.toFixed(2)
    console.log(preciofinal);

    precioTotal.innerHTML = `Precio total: ${preciofinal} €`;
}


enviarDatos();

btn.addEventListener("click", (event)=>{
    calcularTotal();
});
