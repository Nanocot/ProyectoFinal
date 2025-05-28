window.addEventListener("DOMContentLoaded", (event)=>{

    activarListener();
});



function activarListener(){
    const btnEliminar = document.querySelectorAll(".eliminar");
    const filas = document.querySelectorAll("tr");

    for(let boton of btnEliminar){
        boton.addEventListener("click", (event)=>{
            enlace = event.target.parentNode.dataset;
            datosEnlace = enlace.href.split("&");
            idProd = datosEnlace[1].split("=")[1];

            borrar(idProd, event);
        });
    }

    for(let columnas of filas){
            columnas.addEventListener("click", (event) =>{
                if(event.target.className != "eliminar"){
                    enlace = event.target.parentNode.dataset;
                    if(enlace.href){
                        window.location.href = enlace.href;
                    }else{
                        enlace = event.target.parentNode.parentNode.dataset;
                        window.location.href = enlace.href;
                    }
                }
                
                
                
            });
    }


}


async function borrar(id, event){
    try{
        //Enviamos la petición al servidor con los datos necesarios
        fetch("../index.php?action=eliminarProd", {
            method: "POST",
            body: id,
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
                event.target.parentNode.remove();
        });
    }catch(error){
        console.error("Error antes del fetch", error);
    }
}

