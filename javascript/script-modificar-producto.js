let cambios = false;
let original;

window.addEventListener("DOMContentLoaded", (event) =>{
    // Declaración de variables
     original  = cogerDatos();


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
    const colores = document.querySelectorAll(".stock li");


    for(let color of colores){
        aux = color.textContent.trim().split(" y ");
        aux[1] = aux[1].split(" ")[0];
        stock = document.getElementById(`${aux[0]}${aux[1]}`).value;

        fila = {
            "Color": `${aux[0]} y ${aux[1]}`, 
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

async function actualizar(datos){
    const  url =  window.location.href;
    const  parametros =  new URLSearchParams(url);
    const id = parametros.get("id");
    const {Nombre, Categoria, Coleccion, Precio, Descuento, Descripcion, Tallas, Colores, Fotos} = datos;

    const rutasFotos = [];
    let nuevasTallas = {};

    

    for(let foto of Fotos){
        ruta = foto.querySelector("img").getAttribute("src");
        rutasFotos.push(ruta);
    }


    for(let talla in Tallas){
        let colorPatron;
        let colorBase;
        for(let fila of Tallas[talla]){
            [colorPatron, colorBase] = fila.split(" y ");
            if(!nuevasTallas[talla]){
                nuevasTallas[talla] = [{"ColorPatron": colorPatron, "ColorBase": colorBase}];
            }else{
                nuevasTallas[talla].push({"ColorPatron" : colorPatron, "ColorBase" : colorBase});
            }
        }
    }

    const datosEnvio = {
        "ID" : id,
        "Nombre" : Nombre,
        "Categoria" : Categoria,
        "Coleccion" : Coleccion,
        "Precio" : Precio,
        "Descuento" : Descuento,
        "Descripcion" : Descripcion,
        "Tallas" : nuevasTallas,
        "Colores": Colores,
        "Fotos" : rutasFotos
    }
    

    try{

        //Enviamos la petición al servidor con los datos necesarios
        fetch("../index.php?action=actualizarProducto", {
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
        });
    }catch(error){
        console.error("Error antes del fetch", error);
    }

}


// function cuadroNuevosColores(){
//     const form = document.createElement("form");
//     const todas = document.createElement("input");
//     const etiquetaTodoas = document.createElement("label");
//     const algunas = document.createElement("input");
//     const etiquetasAlgunas = document.createElement("")

//     todas.type = "radio";
//     todas.id = "todas";
//     todas.name = "opciones";
//     algunas.type = "radio";
//     algunas.id = "algunas";
//     algunas.name = "opciones";





// }







function activarListener(){

    const btnFotos = document.querySelectorAll(".imagenProducto .eliminar");
    const categoria = document.getElementById("categoria");
    const coleccion = document.getElementById("coleccion");
    const descripcion = document.getElementById("description");
    const descuento = document.getElementById("descuento");
    const colores = document.querySelectorAll(".stock .quitarColor");
    const tallas = document.querySelectorAll(".talla .quitarColorTalla");
    const inputs = document.querySelectorAll("input");
    const btnActualizar = document.querySelector(".aplicarCambios");
    const btnAddColores = document.querySelector("#nuevoColor");
    

    window.addEventListener("beforeunload", (event) =>{    
        if(cambios){
            event.preventDefault(); 
        }
    });

    for(let boton of btnFotos){
        boton.addEventListener("click", (event) =>{
            event.target.parentNode.remove();
            cambios = true;
        });
    }
    
    for(let boton of inputs){
        boton.addEventListener("change", (event) =>{
            console.log(event.target.value);
            cambios = true;
        });
    }
    
    for(let boton of colores){
        boton.addEventListener("click", (event) => {
            event.target.parentNode.remove();
            cambios = true;
        });
    }
    
    for(let boton of tallas){
        boton.addEventListener("click", (event) => {
            event.target.parentNode.remove();
            cambios = true;
        });
    }
    
    categoria.addEventListener("change", (event) =>{
        console.log(event.target.value);
        cambios = true;
    });
    
    coleccion.addEventListener("change", (event) =>{
        console.log(event.target.value);
        cambios = true;
    });
    
    descuento.addEventListener("change", (event) =>{
        console.log(event.target.value);
        cambios = true;
    });
    
    descripcion.addEventListener("change", (event) =>{
        console.log("cambiando");
        cambios = true;
    });

    btnActualizar.addEventListener("click", (event) =>{
        const copia = cogerDatos();
        
        let originalJSON = JSON.stringify(original);
        let copiaJSON = JSON.stringify(copia);

        if(cambios && copiaJSON !== originalJSON){
            actualizar(copia);
        }else if(copiaJSON === originalJSON){
            generarAlerta("No hay cambios"); 
        }
    });

    btnAddColores.addEventListener("click", (event)=>{
        event.preventDefault();


        




    })



}