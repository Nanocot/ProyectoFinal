let cambios = false;

window.addEventListener("DOMContentLoaded", (event) =>{
    // Declaración de variables
    const original  = cogerDatos();
    


    activarListener();
});




function cogerDatos(){
    const fotos = document.querySelectorAll(".imagenProducto");
    const nombre  = document.getElementById("nombre").value;
    const precio = document.getElementById("precio").value;
    const categoria = document.getElementById("categoria").value;
    const coleccion = document.getElementById("coleccion").value;
    const descripcion = document.getElementById("description").value;
    const descuento = document.getElementById("descuento").value;
    const colores = coloresStock();
    const tallas = coloresTallas();




    const datos = {
        "Nombre" : nombre,
        "Categoria" : categoria,
        "Coleccion" : coleccion,
        "Precio" : precio,
        "Descuento" : descuento,
        "Descripcion" : descripcion,
        "Tallas" : tallas,
        "Colores": colores,
        "Fotos" : fotos
    }


    return datos;
}



function coloresStock(){

    const coloresFinal = [];
    const colores = document.querySelectorAll(".stock .color");

    for(let color of colores){
        aux = color.textContent.trim().split(" y ");
        stock = document.getElementById(`${aux[0]}${aux[1]}`).value;

        fila = {
            "Color": color.textContent, 
            "Stock": stock
        }
        coloresFinal.push(fila);
    }
    return coloresFinal;
}


function coloresTallas(){

    const colores = document.querySelectorAll(".talla");
    let colorTallas = {};

    for(let datos  of colores){
        let titulo =  datos.querySelector("h4").textContent;
        let talla = titulo.split(" ")[1];
        const listaColores =[];
        for(let fila of datos.querySelectorAll("li")){
            textoColores = fila.textContent.replace(" ×", "");
            listaColores.push(textoColores);
        }
        colorTallas[talla] = listaColores;
    }

    return colorTallas;
}


function activarListener(){

    const btnFotos = document.querySelectorAll(".imagenProducto .eliminar");
    const categoria = document.getElementById("categoria");
    const coleccion = document.getElementById("coleccion");
    const descripcion = document.getElementById("description");
    const descuento = document.getElementById("descuento");
    const colores = document.querySelectorAll(".stock .quitarColor");
    const tallas = document.querySelectorAll(".talla .quitarColorTalla");
    const inputs = document.querySelectorAll("input");
    

    window.addEventListener("beforeunload", (event) =>{    
        if(cambios){
            event.preventDefault(); 
        }
    });

    for(let boton of btnFotos){
        boton.addEventListener("click", (event) =>{
            event.target.parentNode.remove();
        });
    }

    for(let boton of inputs){
        boton.addEventListener("change", (event) =>{
            console.log(event.target.value);
        });
    }

    for(let boton of colores){
        boton.addEventListener("click", (event) => {
            event.target.parentNode.remove();
        });
    }

    for(let boton of tallas){
        boton.addEventListener("click", (event) => {
            event.target.parentNode.remove();
        });
    }
    
    categoria.addEventListener("change", (event) =>{
        console.log(event.target.value);
    });
    
    coleccion.addEventListener("change", (event) =>{
        console.log(event.target.value);
    });
    
    descuento.addEventListener("change", (event) =>{
        console.log(event.target.value);
    });
    
    descripcion.addEventListener("change", (event) =>{
        console.log("cambiando");
    });






}