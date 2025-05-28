window.addEventListener("DOMContentLoaded", (event) => {

    activarListener();

});




function activarListener(){

    const btnEliminar = document.querySelectorAll(".eliminar");
    const descripciones = document.querySelectorAll("textarea[name='descripcion']");
    const nombres = document.querySelectorAll("input[name='nombre']");
    const divModDesc = document.querySelector(".modificarDescp");
    const divNuevaCat = document.querySelector(".addCategoria");
    const descMod = document.querySelector("#modificarDescpTextarea");
    const btnGuardar = document.querySelectorAll("#guardar");
    const btnCancelar = document.querySelectorAll("#cancelar");
    const btnNuevaCat = document.querySelector(".add");


    let refDesc = null;
    let refNombre = null;

    for(let boton of btnEliminar){
        boton.addEventListener("click", (event) => {
            id = event.target.parentNode.dataset.id;

            borrar(id, event);
        });
    }


    for(let area of descripciones){
        area.addEventListener("click", (event) => {
            divModDesc.style.visibility = "visible";
            divModDesc.style.opacity = 1;
            descMod.value = event.target.value;
            descMod.focus();
            refDesc = event.target;
        });
    }


    for(let nombre of nombres){
        nombre.addEventListener("click", (event) => {
            refNombre = nombre.value;
        });


        nombre.addEventListener("change", (event) => {
            if(refNombre){
                const descripcion = document.querySelector(`#desc-${refNombre}`);
                id = event.target.parentNode.parentNode.dataset.id;

                descripcion.setAttribute("id", `desc-${event.target.value}`);

                console.log(descripcion);

                datosEnvio = {"Id" : id, "Nombre" : event.target.value, "Descripcion" : descripcion.value};

                actualizar(datosEnvio);
            }
        });
    }

    for(let boton of btnGuardar){

        boton.addEventListener("click", (event) =>{
            let nombre;
            let datosEnvio = {};
            if(refDesc){
                refDesc.value = descMod.value;
                divModDesc.style.visibility = "hidden";
                divModDesc.style.opacity = 0;
                
                id = refDesc.parentNode.parentNode.dataset.id;
                console.log(id);
                
                nombre = document.querySelector(`#nombre-${id}`).value;
                
                datosEnvio = {"Id" : id, "Nombre" : nombre, "Descripcion" : descMod.value};
                
                actualizar(datosEnvio);
                descMod.value = "";
                refDesc = null;
            }else{
                divNuevaCat.style.visibility = "hidden";
                divNuevaCat.style.opacity = 0;

                nombre = document.querySelector("#nuevoNombre");
                desc = document.querySelector("#nuevaDesc");

                datosEnvio = {"Nombre" : nombre.value, "Descripcion" : desc.value};
                crear(datosEnvio);

                nombre.value = "";
                desc.value = "";
            }
        });
    }

    for(let boton of btnCancelar){

        boton.addEventListener("click", (event) =>{
            let divPadre = event.target.parentNode.parentNode.parentNode;
            divPadre.style.visibility = "hidden";
            divPadre.style.opacity = 0;

            let clasePadre = divPadre.getAttribute("class");

            if(clasePadre == "modificarDescp"){
                descMod.value = "";
            }
        });
    }
        


    btnNuevaCat.addEventListener("click", (event) =>{
        divNuevaCat.style.visibility = "visible";
        divNuevaCat.style.opacity = 1;
    });



}


async function borrar(id, event){
    try{
        //Enviamos la petición al servidor con los datos necesarios
        fetch("../index.php?action=eliminarColeccion", {
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


async function actualizar(datos){
    datosEnvio = datos;
    try{
        //Enviamos la petición al servidor con los datos necesarios
        fetch("../index.php?action=actualizarColeccion", {
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
                console.log(html);
                generarAlerta(html);
        });
    }catch(error){
        console.error("Error antes del fetch", error);
    }
}


async function crear(datos){
    datosEnvio = datos;
    try{
        //Enviamos la petición al servidor con los datos necesarios
        fetch("../index.php?action=crearColeccion", {
            method: "POST",
            body: JSON.stringify(datosEnvio),
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
                generarAlerta(html.Mensaje);
                let tabla = document.querySelector("tbody");
                let nuevaFila = document.createElement("tr");
                let columna1 = document.createElement("td");
                let datosNombre = document.createElement("input");
                
                datosNombre.type = "text";
                datosNombre.name = "nombre";
                datosNombre.id = `nombre-${html.ID}`;
                datosNombre.value = `${datos.Nombre}`;

                columna1.appendChild(datosNombre);
                nuevaFila.appendChild(columna1);

                let columna2 = document.createElement("td");
                let datosDesc = document.createElement("textarea");

                datosDesc.name = "descripcion";
                datosDesc.id = `desc-${datos.Nombre}`;
                datosDesc.innerHTML = datos.Descripcion;

                columna2.appendChild(datosDesc);
                nuevaFila.appendChild(columna2);

                let columna3 = document.createElement("td");
                columna3.setAttribute("class", "eliminar");
                columna3.innerHTML = "&times;";
                nuevaFila.appendChild(columna3);

                tabla.appendChild(nuevaFila);
                activarListener();

        });
    }catch(error){
        console.error("Error antes del fetch", error);
    }
}