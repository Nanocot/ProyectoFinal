//Declaración de variables
const carrito = localStorage.getItem("producto");




async function enviarDatos(){
        fetch("index.php?action=generarCarrito", {
            method: "POST",
            body: JSON.stringify(carrito),
            headers: {
                "Content-Type": "application/json",
            },
        })
        .catch((error) => console.error("Error:", error))
        .then((response) => console.log("Success:", response))
}


enviarDatos();

