function activarListeners(){
    const estados = document.getElementsByName("estado");

    for(selectores of estados){
        selectores.addEventListener("change", (event)=>{
            let estado = event.target.value;
            let idReclamacion = event.target.parentNode.parentNode.dataset.id;
            let datos = {"id" : idReclamacion, "estado" : estado};

            cambiarEstado(datos);
        });
    }

}

async function cambiarEstado(datos){
    try{
        //Enviamos la petición al servidor con los datos necesarios
        fetch("../index.php?action=cambiarIncidencia", {
            method: "POST",
            body: JSON.stringify(datos),
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
                console.log(html);
        });
    }catch(error){
        console.error("Error antes del fetch", error);
    }
}




activarListeners();