//Declaración de variables
const carrito = localStorage.getItem("producto");
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
        .then(response => response.text()) // Esperamos texto (HTML) como respuesta
        .then(html => {
            console.log("Respuesta HTML recibida:", html);
            document.querySelector(".carrito").innerHTML = html; // Reemplaza el contenido del div "carrito"
            // O podrías reemplazar otra parte de tu página
        });
}

enviarDatos();


// window.addEventListener("load", (event) =>{
//     enviarDatos();
// });


btn.addEventListener("click", (event)=>{
    enviarDatos();
});
