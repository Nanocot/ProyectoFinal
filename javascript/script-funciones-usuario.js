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
    const btnHistorial = document.querySelector("#historialCompras");
    const btnReclamacion = document.querySelector("#realizarReclamacion");

    const btnModDireccion = document.querySelector("#btnDireccion");
    const btnGuardarDireccion = document.querySelector("#guardar");
    const contenidoDireccion = document.querySelector(".datosDireccion");
    const formulario = document.querySelector("#datosCliente");


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


    btnModDireccion.addEventListener("click", (event) =>{

        // console.log(event.target.classList);
        event.target.classList.toggle("active");
        contenidoDireccion.classList.toggle("active");
        
        if(cperfil.style.overflowY != "scroll"){
            cperfil.style.overflowY = "scroll";
            cperfil.style.height = "75dvh";
        }else{
            cperfil.style.overflowY = "hidden";
            cperfil.style.height = "50dvh";
        }
        
        
    });
    

    formulario.addEventListener("submit", (event) =>{
        event.preventDefault();
        console.log(formulario.dataset.id);
    });

    // btnGuardarDireccion.addEventListener("click", (event) =>{
    // });





    for(let boton of cerrar){
        boton.addEventListener("click", (event) => {
            cuadroDial.style.visibility = "hidden";
            cuadroDial.style.opacity = "0";

            event.target.parentNode.style.visibility = "hidden";
            event.target.parentNode.style.opacity = "0";
        });
    }

}