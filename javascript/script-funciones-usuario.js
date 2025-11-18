window.addEventListener("DOMContentLoaded", (event) =>{


    activarListeners();

});



function activarListeners(){
    // Declaración de variables
    const cerrar = document.querySelectorAll(".cerrar");
    const cuadroDial = document.querySelector(".cuadrosDialogo");
    const cperfil = document.querySelector("#perfil");
    const chistorial = document.querySelector("#historial");
    const creclamaciones = document.querySelector("#reclamacion");

    const btnPerfil = document.querySelector("#modificarPerfil");
    const btnGuardarPerfil = document.querySelector("#btnModDatos");
    const btnHistorial = document.querySelector("#historialCompras");
    const btnReclamacion = document.querySelector("#cuadReclamacion");
    const btnEnviarReclamacion = document.querySelector("#enviarReclamacion");
    const btnModDireccion = document.querySelector("#btnDireccion");
    const btnGuardarDireccion = document.querySelector("#guardar");
    const btnCerrDet = document.querySelector(".cerrarDetalles");

    const contenidoDireccion = document.querySelector(".datosDireccion");
    const formulario = document.querySelector("#datosCliente");

    const filasCompras = document.querySelectorAll("tbody tr");
    const detalles = document.querySelector(".detalles");
    const usuario = document.querySelector("#email");

    cuadroDial.addEventListener("click", (event) =>{
        if(event.target == cuadroDial){   
            cuadroDial.style.visibility = "hidden";
            cuadroDial.style.opacity = "0";

            for(let dialogo of cuadroDial.children){
                dialogo.style.visibility = "hidden";
                dialogo.style.opacity = "0";
            }
        }
    });

    btnPerfil.addEventListener("click", (event) =>{
        cuadroDial.style.visibility = "visible";
        cuadroDial.style.opacity = "1";
        cperfil.style.visibility = "visible";
        cperfil.style.opacity = "1";
    });

    btnHistorial .addEventListener("click", (event) =>{
        
        cuadroDial.style.visibility = "visible";
        cuadroDial.style.opacity = "1";
        chistorial .style.visibility = "visible";
        chistorial .style.opacity = "1";
    });    

    btnReclamacion.addEventListener("click", (event) =>{
        cuadroDial.style.visibility = "visible";
        cuadroDial.style.opacity = "1";
        creclamaciones.style.visibility = "visible";
        creclamaciones.style.opacity = "1";
    });

    btnGuardarPerfil.addEventListener("click", (event) =>{
        let nombre = document.querySelector("#nombre");
        let apellidos = document.querySelector("#apellidos");
        let datos = {"nombre" : nombre.value, "apellidos" : apellidos.value, "usuario" : usuario.textContent};

        modDatos(datos);
    });




    btnModDireccion.addEventListener("click", (event) =>{
        event.target.classList.toggle("active");
        contenidoDireccion.classList.toggle("active");
        
        if(cperfil.style.overflowY != "scroll"){
            cperfil.style.overflowY = "scroll";
            cperfil.style.height = "75dvh";
        }else{
            cperfil.style.overflowY = "hidden";
            cperfil.style.height = "70dvh";
        }
        
        
    });

    btnCerrDet.addEventListener("click", (event) =>{
        detalles.style.visibility = "hidden";
        detalles.style.opacity = "0";
    });

    btnEnviarReclamacion.addEventListener("click", (event)=>{

        let descp = document.querySelector("#textReclamacion");
        
        let datos = {"user" : usuario.textContent, "descripcion" : descp.value};


        enviarReclamacion(datos);


    });
    

    btnGuardarDireccion.addEventListener("click", (event) =>{
        let calle = document.querySelector("#calle");
        let numero = document.querySelector("#numero");
        let planta = document.querySelector("#planta");
        let puerta = document.querySelector("#puerta");
        let poblacion = document.querySelector("#poblacion");
        let codPostal = document.querySelector("#codPostal");
        
        const datosEnvio = {"calle" : calle.value, "numero" : numero.value, "planta" : planta.value, "puerta" : puerta.value, "poblacion" : poblacion.value, "codPostal" : codPostal.value, "usuario" : user.textContent};


        modDireccion(datosEnvio);
    });


    



    formulario.addEventListener("submit", (event) =>{
        event.preventDefault();
        console.log(formulario.dataset.id);
    });

    detalles.addEventListener("click", (event) =>{
        if(event.target === detalles){
            detalles.style.opacity = 0;
            detalles.style.visibility = "hidden";
        }

    });


    for(let boton of cerrar){
        boton.addEventListener("click", (event) => {
            cuadroDial.style.visibility = "hidden";
            cuadroDial.style.opacity = "0";

            event.target.parentNode.style.visibility = "hidden";
            event.target.parentNode.style.opacity = "0";
        });
    }


    for(let fila of filasCompras){
        fila.addEventListener("click", (event) =>{
            let id = fila.dataset.id;
            let precioTotal = fila.children[1].innerText;
            let estado = fila.children[3].innerText;

            sacarDetalles(id, usuario, estado, precioTotal);

            detalles.style.opacity = 1;
            detalles.style.visibility = "visible";
        });
    }

}


async function sacarDetalles(id, usuario, estado, precioTotal){
    const detalles = document.querySelector(".infoProdus");
    const estadoPago = document.querySelector("#estado");
    const precTotal = document.querySelector(".precTotal");
    const totalProductos = document.querySelector(".totalProdus");


    precTotal.innerHTML = "";
    precTotal.innerHTML = precioTotal;
    totalProductos.innerHTML = "";

    

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

async function enviarReclamacion(datos) {
    
    let peticion = JSON.stringify(datos);

    // console.log(datos);

    try{
        //Enviamos la petición al servidor con los datos necesarios
        fetch("../index.php?action=enviarReclamacion", {
            method: "POST",
            body: peticion,
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

            let texto = document.querySelector("#textReclamacion");
            texto.value = "";

        });
    }catch(error){
        console.error("Error antes del fetch", error);
    }
    
}



async function modDireccion(datos) {
    
    let peticion = JSON.stringify(datos);

    try{
        //Enviamos la petición al servidor con los datos necesarios
        fetch("../index.php?action=modDireccion", {
            method: "POST",
            body: peticion,
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
        });
    }catch(error){
        console.error("Error antes del fetch", error);
    }
    
}



async function modDatos(datos) {
    
    let peticion = JSON.stringify(datos);

    try{
        //Enviamos la petición al servidor con los datos necesarios
        fetch("../index.php?action=modPerfil", {
            method: "POST",
            body: peticion,
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