let cambios = false;
let original;
const  url =  window.location.href;
const  parametros =  new URLSearchParams(url);
const idURL = parametros.get("id");
const categoriaURL = parametros.get("categoria");

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
    let datos;

    if(categoria != 3){
        datos = {
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
        
    }else{
        datos = {
            "Nombre" : nombre,
            "Categoria" : categoria,
            "Coleccion" : coleccion,
            "Precio" : precio,
            "Descuento" : descuento,
            "Descripcion" : descripcion,
            "Colores": colores,
            "Fotos" : fotos
        }
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
        aux[0] = capitalize(aux[0]);
        aux[1] = capitalize(aux[1]);

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
        let id = datos.id.split("-")[1];
        const listaColores =[];
        for(let fila of datos.querySelectorAll("li")){
            textoColores = fila.textContent.replace(" ×", "");
            listaColores.push(textoColores);
        }
        colorTallas[talla] = {"Colores": listaColores, "ID" : id};
    }

    return colorTallas;
}

async function actualizar(datos){
    
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
        // console.log(Tallas[talla]);
        for(let atributo in Tallas[talla]){
            for(let fila of Tallas[talla][atributo]){
                
                
                if(atributo == "Colores"){
                    [colorPatron, colorBase] = fila.split(" y ");
                    
                    if(!nuevasTallas[talla]){
                        nuevasTallas[talla] = {"Colores" :[{"ColorPatron": colorPatron, "ColorBase": colorBase}]};
                        console.log(nuevasTallas);
                    }else{
                        nuevasTallas[talla]["Colores"].push({"ColorPatron" : colorPatron, "ColorBase" : colorBase});
                    }
                }else{
                    console.log(Tallas[talla][atributo]);
                    nuevasTallas[talla]["ID"] = Tallas[talla][atributo];
                }
            }
        }
    }
    console.log(nuevasTallas);


    const datosEnvio = {
        "ID" : idURL,
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




function activarListener(){

    
    const categoria = document.getElementById("categoria");
    const coleccion = document.getElementById("coleccion");
    const descripcion = document.getElementById("description");
    const descuento = document.getElementById("descuento");
    const inputs = document.querySelectorAll("input");
    const btnActualizar = document.querySelector(".aplicarCambios");
    const btnAddColores = document.querySelector("#nuevoColor");
    const btnAdd = document.querySelector("#addColor");
    const radios = document.getElementsByName("opcion");
    let valorRadio = 0;

    activarCruces();
    

    window.addEventListener("beforeunload", (event) =>{    
        if(cambios){
            event.preventDefault(); 
        }
    });

    
    
    for(let boton of inputs){
        if(boton.type != "radio" && boton.type != "checkbox"){    
            boton.addEventListener("change", (event) =>{
                console.log(event.target.value);
                cambios = true;
            });
        }
    }
    
    

    for(let radio of radios){
        radio.addEventListener("change", (event) =>{
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            const divAlgunas = document.querySelector(".algunasTallas");

            if(event.target.value == 2){
                divAlgunas.style.opacity = "1";
                divAlgunas.style.pointerEvents = "auto";
                for(let casilla of checkboxes){
                    casilla.disabled = false;
                }    
                valorRadio = event.target.value;
            }else{
                divAlgunas.style.opacity = "0.5";
                divAlgunas.style.pointerEvents = "none";
                for(let casilla of checkboxes){
                    casilla.disabled = true;
                    casilla.checked = false;
                }
                valorRadio = event.target.value;
            }
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
        

        const colorPatron = document.querySelector("#colorPatron");
        const colorBase = document.querySelector("#colorBase");


        if(categoriaURL != "Accesorios" && colorPatron.value != "" && colorBase.value != ""){
            const divColores = document.querySelector(".addColores");
            divColores.style.display = "flex";
        }else if(colorPatron.value != "" && colorBase.value != ""){
            const stockColores = document.querySelector(".stock ul");
            const nuevaFila = document.createElement("li");

            nuevaFila.innerHTML = `${capitalize(colorPatron.value)} y ${capitalize(colorBase.value)} <span class="quitarColor">&times;</span> <input type="number" min="0" id="${colorPatron.value}${colorBase.value}" value="0">`;
            
            stockColores.appendChild(nuevaFila);

            colorPatron.value = "";
            colorBase.value = "";
        }else{
            generarAlerta("No hay ningun color nuevo");
        }
    });

    btnAdd.addEventListener("click", (event) =>{
        event.preventDefault();
        const colorPatron = document.querySelector("#colorPatron");
        const colorBase = document.querySelector("#colorBase");
        const divColores = document.querySelector(".addColores");
        
        if(colorPatron.value != "" && colorBase.value != ""){
            
            const tallas = document.querySelectorAll(".talla");
            const checkboxes = document.querySelectorAll("input[type=checkbox]")
            const stockColores = document.querySelector(".stock ul");
            
            const nuevaFila = document.createElement("li");
            nuevaFila.innerHTML = `<span class="color">${capitalize(colorPatron.value)} y ${capitalize(colorBase.value)}</span> <span class="quitarColorTalla">&times;</span>`;
            
            if(valorRadio == 1){
                for(let div of tallas){
                    let lista = div.querySelector("ul");
                    let nuevaFilaCopia = nuevaFila.cloneNode(true);
                    lista.appendChild(nuevaFilaCopia);
                    console.log(lista.innerHTML);
                }
            }else if(valorRadio == 2){
                const casillas = [];
                for(let casilla of checkboxes){
                    if(casilla.checked){
                        casillas.push(casilla.value);
                    }
                }
                for(let div of tallas){
                    let nombreTalla = div.querySelector("h4").textContent.split(" ")[1];
                    
                    if(casillas.includes(nombreTalla)){
                        let lista = div.querySelector("ul");
                        let nuevaFilaCopia = nuevaFila.cloneNode(true);
                        lista.appendChild(nuevaFilaCopia);
                    }
                }
                
                
            }
            
            nuevaFila.innerHTML = `${capitalize(colorPatron.value)} y ${capitalize(colorBase.value)} <span class="quitarColor">&times;</span> <input type="number" min="0" id="${capitalize(colorPatron.value)}${capitalize(colorBase.value)}" value="0">`;
            
            stockColores.appendChild(nuevaFila);
            
            
            divColores.style.display = "none";
            colorPatron.value = "";
            colorBase.value = "";
            activarCruces();
        }else{
            divColores.style.display = "none";
            generarAlerta("No hay ningun color nuevo");
        }
    });


    



}



function activarCruces(){
    const btnFotos = document.querySelectorAll(".imagenProducto .eliminar");
    const colores = document.querySelectorAll(".stock .quitarColor");
    const tallas = document.querySelectorAll(".talla .quitarColorTalla");
    const cerrarDialogo = document.querySelector(".cerrarCuadro");
    let lista = document.querySelectorAll(".color");
    

    for(let boton of colores){
        boton.addEventListener("click", (event) => {
            let color = event.target.parentNode.textContent;
            color = color.slice(0, color.indexOf("×"));

            for(let dato of lista){
                if(dato.textContent.trim() == color.trim()){
                    dato.parentNode.remove();
                }
            }
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

    for(let boton of btnFotos){
        boton.addEventListener("click", (event) =>{
            event.target.parentNode.remove();
            cambios = true;
        });
    }

    cerrarDialogo.addEventListener("click", (event) =>{
        const divColores = document.querySelector(".addColores");
        divColores.style.display = "none";
    });
}