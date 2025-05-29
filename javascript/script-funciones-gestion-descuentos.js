window.addEventListener("DOMContentLoaded", (event) => {

    activarListener();

});

    let refDesc = null;



function activarListener(){

    const divModDesc = document.querySelector(".modificarDescp");
    const divNuevoDes = document.querySelector(".addDescuento");
    const descMod = document.querySelector("#modificarDescpTextarea");
    const btnGuardar1 = document.querySelector("#guardar1");
    const btnCancelar1 = document.querySelector("#cancelar1");
    const btnGuardar2 = document.querySelector("#guardar2");
    const btnCancelar2 = document.querySelector("#cancelar2");
    const btnNuevoDes = document.querySelector(".add");
    
    
    
    activarTabla();

    btnGuardar1.addEventListener("click", (event) =>{
        let datosEnvio = {};
        if(refDesc){
            refDesc.value = descMod.value;
            divModDesc.style.visibility = "hidden";
            divModDesc.style.opacity = 0;
            
            id = refDesc.parentNode.parentNode.dataset.id;
            
            datosEnvio = {"Id" : id, "Descripcion" : descMod.value};
            
            actualizar(datosEnvio);
            descMod.value = "";
            refDesc = null;
        }
    });

    btnGuardar2.addEventListener("click", (event) =>{
        let nombre, fecIni, fecFin, cantidad, tipo;
        let datosEnvio = {};
        
        

        nombre = document.querySelector("#nuevoNombre");
        desc = document.querySelector("#nuevaDesc");
        fecIni = document.querySelector("#nuevoInicio");
        fecFin = document.querySelector("#nuevoFin");
        cantidad = document.querySelector("#nuevaCantidad");
        tipo = document.querySelector("#nuevoTipo");

        if(nombre.value != "" && desc.value != "" && fecIni.value != "" && fecFin.value != "" && cantidad.value != "" && tipo.value != ""){
            divNuevoDes.style.visibility = "hidden";
            divNuevoDes.style.opacity = 0;
            
            // console.log("ENTRA");
            datosEnvio = {"Nombre" : nombre.value, "Descripcion" : desc.value, "FechaInicio" : fecIni.value, "FechaFin" : fecFin.value, "Cantidad" : cantidad.value, "Tipo" : tipo.value};
            crear(datosEnvio);
            
            nombre.value = "";
            desc.value = "";
            fecIni.value = "";
            fecFin.value = "";
            cantidad.value = "";
            tipo.value = "";
        }else{
            generarAlerta("Porfavor rellene los campos");
        }
        
    });




    btnCancelar1.addEventListener("click", (event) =>{
        let divPadre = event.target.parentNode.parentNode.parentNode;
        divPadre.style.visibility = "hidden";
        divPadre.style.opacity = 0;
        descMod.value = "";
    });

    btnCancelar2.addEventListener("click", (event) =>{
        let divPadre = event.target.parentNode.parentNode.parentNode;
        divPadre.style.visibility = "hidden";
        divPadre.style.opacity = 0;
    });
    
        


    btnNuevoDes.addEventListener("click", (event) =>{
        divNuevoDes.style.visibility = "visible";
        divNuevoDes.style.opacity = 1;
        fecIni = document.querySelector("#nuevoInicio");
        const hoy = new Date();
        const anio = hoy.getFullYear();
        const mes = (hoy.getMonth() + 1).toString().padStart(2, '0');
        const dia = hoy.getDate().toString().padStart(2, '0');

        const fechaFormateada = `${anio}-${mes}-${dia}`;

        fecIni.value = fechaFormateada;

    });
}


function activarTabla(){

    const divModDesc = document.querySelector(".modificarDescp");
    const descMod = document.querySelector("#modificarDescpTextarea");
    const btnEliminar = document.querySelectorAll(".eliminar");
    const descripciones = document.querySelectorAll("textarea[name='descripcion']");
    const nombres = document.querySelectorAll("input[name='nombre']");
    const fechasIni = document.querySelectorAll("input[name='fechaIni']");
    const fechasFin = document.querySelectorAll("input[name='fechaFin']");
    const cantidades = document.querySelectorAll("input[name='cantidad']");
    const tipos = document.querySelectorAll("select[name='tipo']");
    let refNombre = null;
    let refFechaIni = null;
    let refFechaFin = null;





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
            console.log(refNombre);
        });


        nombre.addEventListener("change", (event) => {

            if(refNombre != null){
                const descripcion = document.querySelector(`#desc-${refNombre}`);
                const fechaIni = document.querySelector(`#fechaIni-${refNombre}`);
                const fechaFin = document.querySelector(`#fechaFin-${refNombre}`);
                const cantidad = document.querySelector(`#cantidad-${refNombre}`);
                const tipo = document.querySelector(`#tipo-${refNombre}`);
                id = event.target.parentNode.parentNode.dataset.id;

                descripcion.setAttribute("id", `desc-${event.target.value}`);
                fechaIni.setAttribute("id", `fechaIni-${event.target.value}`);
                fechaFin.setAttribute("id", `fechaFin-${event.target.value}`);
                cantidad.setAttribute("id", `cantidad-${event.target.value}`);
                tipo.setAttribute("id", `tipo-${event.target.value}`);


                datosEnvio = {"Id" : id, "Nombre" : event.target.value};

                actualizar(datosEnvio);

                refNombre = event.target.value;
            }
        });
    }


    for(let fecha of fechasIni){
        fecha.addEventListener("focusin", (event) =>{
            
            refFechaIni = event.target.value; 
        });

        fecha.addEventListener("focusout", (event) =>{
            if(refFechaIni != null && event.target.value != refFechaIni){
                id = event.target.parentNode.parentNode.dataset.id;
            
                datosEnvio = {"Id" : id, "FechaInicio" : event.target.value};
                
                actualizar(datosEnvio);
            }
            refFechaIni = null;
            
        }); 
    }

    for(let fecha of fechasFin){
        fecha.addEventListener("focusin", (event) =>{
            
            refFechaFin = event.target.value; 
        });

        fecha.addEventListener("focusout", (event) =>{
            if(refFechaFin != null && event.target.value != refFechaFin){
                id = event.target.parentNode.parentNode.dataset.id;
                
                datosEnvio = {"Id" : id, "FechaFin" : event.target.value};
                
                actualizar(datosEnvio);
            }
            refFechaFin = null;
            
        }); 
    }

    for(let cantidad of cantidades){
        cantidad.addEventListener("change", (event) =>{
            
            id = event.target.parentNode.parentNode.dataset.id;
            
            datosEnvio = {"Id" : id, "Cantidad" : event.target.value};
            
            actualizar(datosEnvio);
        });
    }

    for(let tipo of tipos){
        tipo.addEventListener("change", (event) =>{

            id = event.target.parentNode.parentNode.dataset.id;
            
            datosEnvio = {"Id" : id, "Tipo" : event.target.value};
            
            actualizar(datosEnvio);
        });
    }




}


async function borrar(id, event){
    try{
        //Enviamos la petición al servidor con los datos necesarios
        fetch("../index.php?action=eliminarDescuento", {
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
            console.log(html);
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
        fetch("../index.php?action=actualizarDescuento", {
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
    console.log(datos);



    try{
        //Enviamos la petición al servidor con los datos necesarios
        fetch("../index.php?action=crearDescuento", {
            method: "POST",
            body: JSON.stringify(datosEnvio),
            headers: {
                "Content-Type": "application/json",
            },
        })
        //Capturamos posibles errores en la respuesta del servidor
        .catch((error) => console.error("Error:", error))
        //Convertimos el objeto respuesta en json, para leer el mensaje y el id 
        .then(response => response.json())
        .then(html => {
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
            let datosFecIni = document.createElement("input");


            datosFecIni.type = "date";
            datosFecIni.name = "fechaIni";
            datosFecIni.id = `fechaIni-${datos.Nombre}`;
            datosFecIni.value = datos.FechaInicio;
            columna3.appendChild(datosFecIni);
            nuevaFila.appendChild(columna3);
            
            let columna4 = document.createElement("td");
            let datosFecFin = document.createElement("input");

            console.log(datos.FechaFin);
            datosFecFin.type = "date";
            datosFecFin.name = "fechaFin";
            datosFecFin.id = `fechaFin-${datos.Nombre}`;
            datosFecFin.value = datos.FechaFin;
            columna4.appendChild(datosFecFin);
            nuevaFila.appendChild(columna4);


            let columna5 = document.createElement("td");
            let datosCantidad = document.createElement("input");

            datosCantidad.type = "number";
            datosCantidad.min = "0";
            datosCantidad.name = "cantidad";
            datosCantidad.id = `cantidad-${datos.Nombre}`;
            datosCantidad.value = datos.Cantidad;
            datosCantidad.step = "1";

            columna5.appendChild(datosCantidad);
            nuevaFila.appendChild(columna5);

            let columna6 = document.createElement("td");
            let datosTipo = document.createElement("select");
            let opcion1 = document.createElement("option");
            let opcion2 = document.createElement("option");
            let opcion3 = document.createElement("option");


            datosTipo.id = `tipo-${datos.Nombre}`;
            datosTipo.name = "tipo";

            opcion1.value = "";
            opcion1.innerHTML = "Elija una";
            opcion1.disabled = false;
            opcion2.value = "cantidad";
            opcion2.innerHTML = "Cantidad";
            opcion3.value = "porcentaje";
            opcion3.innerHTML = "Porcentaje";
            
            if(datos.Tipo == "cantidad"){
                opcion2.selected = true;
                
            }else if(datos.Tipo == "porcentaje"){
                opcion3.selected = true;
            }

            datosTipo.appendChild(opcion1);
            datosTipo.appendChild(opcion2);
            datosTipo.appendChild(opcion3);

            columna6.appendChild(datosTipo);

            nuevaFila.appendChild(columna6);




            let columna7 = document.createElement("td");
            columna7.setAttribute("class", "eliminar");
            columna7.innerHTML = "&times;";
            nuevaFila.appendChild(columna7);

            nuevaFila.dataset.id = `${html.ID}`;

            tabla.appendChild(nuevaFila);
            activarTabla();

        });
    }catch(error){
        console.error("Error antes del fetch", error);
    }
}