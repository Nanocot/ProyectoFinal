
function aplicarCambios(){
    const estado = document.getElementById("estado").value;
    enviarCambios(estado);
}

async function enviarCambios(estado){
    const email = sacarEmail();

    const datosEnvio = {
        "action": "cambiarEstado",
        "estado": estado,
        "email": email 
    };


   //Enviamos la petición al servidor con los datos necesarios
        fetch("../index.php?action=cambiarEstado", {
            method: "POST",
            body: JSON.stringify(datosEnvio),
            headers: {
                "Content-Type": "application/json",
            },
        })
        //Capturamos posibles errores en la respuesta del servidor
        .catch((error) => console.error("Error:", error))
        //Convertimos el objeto respuesta en texto, para poder leerlo
        .then(response => response.text())
        .then(html => {        
            generarAlerta(html);
        })


}




function sacarEmail(){
    const p = document.querySelectorAll("p");
    const email = p[2].textContent.split(": ")[1];
    return email;
}