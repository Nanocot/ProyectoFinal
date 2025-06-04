
window.addEventListener("DOMContentLoaded", (event) =>{

    activarListener();

});




function activarListener(){

    const filas = document.querySelectorAll("tr");
    const detalles = document.querySelector(".detalles");


    detalles.addEventListener("click", (event) =>{
        if(event.target === detalles){
            detalles.style.opacity = 0;
            detalles.style.visibility = "hidden";
            console.log("Se cierra");
        }

    });



    for(let fila of filas){
        fila.addEventListener("click", (event)=>{
            let id = fila.dataset.id;
            let usuario = fila.children[1].innerText;
            let precioTotal = fila.children[2].innerText;
            let estado = fila.lastChild;

            sacarDetalles(id, usuario, estado, precioTotal);

            detalles.style.opacity = 1;
            detalles.style.visibility = "visible";
            
        });
    }



}


async function sacarDetalles(id, usuario, estado, precioTotal){
    const detalles = document.querySelector(".infoProdus");
    const numeroCompra = document.querySelector(".numero");
    const estadoPago = document.querySelector("#estado");
    const precTotal = document.querySelector(".precTotal");
    const emailUsuario = document.querySelector(".emailUsuario");
    const totalProductos = document.querySelector(".totalProdus");


    numeroCompra.innerHTML = "";
    precTotal.innerHTML = "";
    emailUsuario.innerHTML = "";
    numeroCompra.innerHTML = id;
    precTotal.innerHTML = precioTotal;
    emailUsuario.innerHTML = usuario;
    totalProductos.innerHTML = "";

    console.log(estadoPago);

    try{
        //Enviamos la petición al servidor con los datos necesarios
        fetch("../index.php?action=sacarDetalles", {
            method: "POST",
            body: id,
            headers: {
                "Content-Type": "application/json",
            },
        })
        //Capturamos posibles errores en la respuesta del servidor
        .catch((error) => console.error("Error:", error))
        //Convertimos el objeto respuesta en texto, para poder leerlo
        .then(response => response.json())
        .then(html => {
            console.log(html);
            totalProductos.innerHTML = html[1];
            detalles.innerHTML = "";
            
            
            
            for(let i = 0; i < html[0].length; i ++){
                const fila = document.createElement("tr");
                let columna1 = document.createElement("td");
                let columna2 = document.createElement("td");
                let columna3 = document.createElement("td");
                let columna4 = document.createElement("td");
                let columna5 = document.createElement("td");
            
                // fila.innerHTML = "";
                let {nombre, color, talla, cantidad, precio} = html[0][i];    
                columna1.innerText = nombre;    
                columna2.innerText = color;    
                columna3.innerText = talla;    
                columna4.innerText = cantidad;    
                columna5.innerText = precio;
                
                fila.appendChild(columna1);
                fila.appendChild(columna2);
                fila.appendChild(columna3);
                fila.appendChild(columna4);
                fila.appendChild(columna5);
                
                detalles.appendChild(fila);
            }
        
        
        });
    }catch(error){
        console.error("Error antes del fetch", error);
    }



}