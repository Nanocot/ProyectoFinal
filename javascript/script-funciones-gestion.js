window.addEventListener("DOMContentLoaded", (event)=>{

    activarListener();
});



function activarListener(){
    const btnEliminar = document.querySelectorAll(".eliminar");


    for(let boton of btnEliminar){
        boton.addEventListener("click", (event)=>{
            console.log("pulsado");
        });
    }
}

