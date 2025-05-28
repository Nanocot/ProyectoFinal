let cambios = false;
let original;

window.addEventListener("DOMContentLoaded", (event) =>{
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

async function addProducto(datos){
    
    const {Nombre, Categoria, Coleccion, Precio, Descuento, Descripcion, Tallas, Colores, Fotos} = datos;

    const rutasFotos = [];
    let nuevasTallas = {};
    

    for(let foto of Fotos){
        ruta = foto.querySelector("img").getAttribute("src");
        alt = foto.querySelector("img").getAttribute("alt");
        rutasFotos.push({"Ruta" : ruta, "Alt" : alt});
    }

    for(let talla in Tallas){
        let colorPatron;
        let colorBase;
        for(let atributo in Tallas[talla]){
            for(let fila of Tallas[talla][atributo]){
                
                console.log(atributo);
                if(atributo == "Colores"){
                    [colorPatron, colorBase] = fila.split(" y ");


                    
                    if(!nuevasTallas[talla]){
                        nuevasTallas[talla] = {"Colores" :[{"ColorPatron": colorPatron, "ColorBase": colorBase}]};
                    }else{
                        nuevasTallas[talla]["Colores"].push({"ColorPatron" : colorPatron, "ColorBase" : colorBase});
                    }
                    console.log(nuevasTallas);
                }else{
                    if(!nuevasTallas[talla]){
                        nuevasTallas[talla] = {"ID" : Tallas[talla][atributo]};
                    }else{
                        nuevasTallas[talla]["ID"] = Tallas[talla][atributo];
                    }
                }
            }
        }
    }

    if(Categoria != "Elija una" && Coleccion != "Elija una"){

        const datosEnvio = {
            "ID" : "",
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
            fetch("../index.php?action=addProducto", {
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
            cambios = false;
            generarAlerta("Error, contacte con el administrador");
            console.error("Error antes del fetch", error);
        }
    }else{
        generarAlerta("Compruebe los datos");
    }

}




function activarListener(){

    
    const categoria = document.getElementById("categoria");
    const coleccion = document.getElementById("coleccion");
    const descripcion = document.getElementById("description");
    const descuento = document.getElementById("descuento");
    const inputs = document.querySelectorAll("input");
    const btnaddProducto = document.querySelector(".addProducto");
    const btnAddColores = document.querySelector("#nuevoColor");
    const btnAdd = document.querySelector("#addColor");
    const btnAddFoto = document.querySelector(".btnAddFoto");
    const radios = document.getElementsByName("opcion");
    const btnSubirFoto = document.querySelector("#subirFoto");
    const inputSubirFoto = document.querySelector("#fotoSubida");
    const imagePreview = document.querySelector("#previsualizacion");
    const divFotos = document.querySelector(".fotos");
    let valorRadio = 0;

    activarCruces();
    

    window.addEventListener("beforeunload", (event) =>{    
        let copia = cogerDatos();
        if(cambios && original != copia){
            event.preventDefault(); 
        }
    });

    
    
    for(let boton of inputs){
        if(boton.type != "radio" && boton.type != "checkbox" && boton.type != "file"){    
            boton.addEventListener("change", (event) =>{
                // console.log(event.target.value);
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
        // console.log(event.target.value);
        cambios = true;
        let tituloColoresTallas = document.querySelector(".colores h4");
        let divColoresTallas = document.querySelector(".colDisponibles");
        if(event.target.value == 3){
            console.log("ACCESORIOS"); 
            tituloColoresTallas.style.display = "none";
            divColoresTallas.style.display = "none";
        }else{
            tituloColoresTallas.style.display = "block";
            divColoresTallas.style.display = "flex";
        }
    });
    
    coleccion.addEventListener("change", (event) =>{
        // console.log(event.target.value);
        cambios = true;
    });
    
    descuento.addEventListener("change", (event) =>{
        // console.log(event.target.value);
        cambios = true;
    });
    
    descripcion.addEventListener("change", (event) =>{
        // console.log("cambiando");
        cambios = true;
    });


    

    btnaddProducto.addEventListener("click", (event) =>{
        const copia = cogerDatos();
        
        let originalJSON = JSON.stringify(original);
        let copiaJSON = JSON.stringify(copia);

        if(cambios && copiaJSON !== originalJSON){
            addProducto(copia);
            cambios = false;
        }else if(copiaJSON === originalJSON || !cambios){
            generarAlerta("No ha introducido datos"); 
        }
    });

    btnAddColores.addEventListener("click", (event)=>{
        event.preventDefault();
        

        const colorPatron = document.querySelector("#colorPatron");
        const colorBase = document.querySelector("#colorBase");


        if(categoria.value != 3 && colorPatron.value != "" && colorBase.value != ""){
            const divColores = document.querySelector(".addColores");
            divColores.style.display = "flex";
        }else if(colorPatron.value != "" && colorBase.value != ""){
            const stockColores = document.querySelector(".stock ul");
            const nuevaFila = document.createElement("li");

            nuevaFila.innerHTML = `${capitalize(colorPatron.value)} y ${capitalize(colorBase.value)} <span class="quitarColor">&times;</span> <input type="number" min="0" id="${capitalize(colorPatron.value)}${capitalize(colorBase.value)}" value="0">`;
            
            stockColores.appendChild(nuevaFila);

            colorPatron.value = "";
            colorBase.value = "";

            cambios = true;
        }else{
            generarAlerta("Añada un color");
        }
    });

    btnAdd.addEventListener("click", (event) =>{
        event.preventDefault();
        const colorPatron = document.querySelector("#colorPatron");
        const colorBase = document.querySelector("#colorBase");
        const divColores = document.querySelector(".addColores");
        let coloresReferencia = `${capitalize(colorPatron.value)} y ${capitalize(colorBase.value)}`;
        
        if(colorPatron.value != "" && colorBase.value != ""){
            
            const tallas = document.querySelectorAll(".talla");
            const checkboxes = document.querySelectorAll("input[type=checkbox]")
            const stockColores = document.querySelector(".stock ul");
            
            const nuevaFila = document.createElement("li");
            nuevaFila.innerHTML = `<span class="color">${coloresReferencia}</span> <span class="quitarColorTalla">&times;</span>`;
            let existeColor = false; 
            
            
            if(valorRadio == 1){
                for(let div of tallas){
                    let lista = div.querySelector("ul");
                    existeColor = false; 
                    for(let fila of lista.childNodes){
                        let colorFila = fila.textContent.replace(" ×", "");
                        if(coloresReferencia == colorFila){
                            existeColor = true;
                        }
                    }

                    if(!existeColor){
                        let nuevaFilaCopia = nuevaFila.cloneNode(true);
                        lista.appendChild(nuevaFilaCopia);
                    }
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
                        for(let fila of lista.childNodes){
                            let colorFila = fila.textContent.replace(" ×", "");
                            if(coloresReferencia == colorFila){
                                existeColor = true;
                            }
                        }

                        if(!existeColor){
                            let nuevaFilaCopia = nuevaFila.cloneNode(true);
                            lista.appendChild(nuevaFilaCopia);
                        }
                    }
                }    
            }

            nuevaFila.innerHTML = `${capitalize(colorPatron.value)} y ${capitalize(colorBase.value)} <span class="quitarColor">&times;</span> <input type="number" min="0" id="${capitalize(colorPatron.value)}${capitalize(colorBase.value)}" value="0">`;
            let existe = false;

            for(let fila of stockColores.childNodes){
                let colorFila = fila.textContent.replace(" ×", "");
                if(coloresReferencia.trim() == colorFila.trim()){
                    existe = true;
                }
            }
            if(!existe){
                stockColores.appendChild(nuevaFila);
            }
            
            
            divColores.style.display = "none";
            colorPatron.value = "";
            colorBase.value = "";
            activarCruces();
        }else{
            divColores.style.display = "none";
            generarAlerta("Añada un color");
        }
    });




    btnAddFoto.addEventListener("click", (event)=>{
        const divAddFoto = document.querySelector(".addFoto");
        const coloresFoto = document.querySelector(".stock ul");
        const coloresAddFoto = document.querySelector(".colorFoto");
        let radioColor = document.createElement("input");
        radioColor.type = "radio";
        radioColor.name = "colorFoto";
        let labelRadioColor = document.createElement("label");
        const datosFotos = document.querySelectorAll(".imagenProducto img");
        const coloresReferencias = [];

        imagePreview.src = "#";


        if(coloresAddFoto.innerHTML != ""){
            coloresAddFoto.innerHTML = "";
        }

        if(categoria.value != 3){   
            for(let imagen of datosFotos){
                let ruta = imagen.src.split("-");
                if(ruta.length > 1){
                    let colorReferencia = `${capitalize(ruta[1])} y ${capitalize(ruta[2])}`;
                    coloresReferencias.push(colorReferencia);
                }else{
                    ruta = imagen.alt.split("-");
                    let colorReferencia = `${capitalize(ruta[1])} y ${capitalize(ruta[2])}`;
                    coloresReferencias.push(colorReferencia);
                }
            }
        }else{
            for(let imagen of datosFotos){
                let ruta = imagen.src.split("-");
                if(ruta.length > 1){
                    let colorReferencia = `${capitalize(ruta[1])} y ${capitalize(ruta[1])}`;
                    coloresReferencias.push(colorReferencia);
                }else{
                    ruta = imagen.alt.split("-");
                    let colorReferencia = `${capitalize(ruta[1])} y ${capitalize(ruta[1])}`;
                    coloresReferencias.push(colorReferencia);
                }
            }
        }


        for(let fila of coloresFoto.childNodes){
            let colorFila = fila.textContent.replace(" ×", "").trim();

            if(!coloresReferencias.includes(colorFila)){
                radioColor.id = `${colorFila}`;
                radioColor.value = `${colorFila}`;
                radioColor.disabled = false;
                labelRadioColor.innerText = `${colorFila}`;
                radioColor.style.cursor = "pointer";
                radioColor.style.opacity = 1;
                labelRadioColor.style.opacity = 1;
                
            }else{
                radioColor.id = `${colorFila}`;
                radioColor.value = `${colorFila}`;
                radioColor.disabled = true;
                labelRadioColor.innerText = `${colorFila}`;
                radioColor.style.cursor = "not-allowed";
                radioColor.style.opacity = 0.5;
                labelRadioColor.style.opacity = 0.5;
            }

            if(colorFila != ""){
                let copiaRadio = radioColor.cloneNode(true);
                let copiaLabel = labelRadioColor.cloneNode(true);
                
                coloresAddFoto.appendChild(copiaRadio);
                coloresAddFoto.appendChild(copiaLabel);
            }
        }
        divAddFoto.style.display = "flex";
    });


    inputSubirFoto.addEventListener('change', (event) => {
                const fichero = event.target.files[0];
                const tamanioMaximoMB = 5;
                const tamanioMaximoBytes = tamanioMaximoMB * 1024 * 1024;       
                const tiposPermitidos = ['image/jpeg', 'image/png',  'image/webp'];
                // 'image/gif',
                let mensaje = "";
                

                if (!tiposPermitidos.includes(fichero.type)) {
                    mensaje = `Tipo de archivo no permitido: ${fichero.type}. Solo se aceptan JPEG, PNG, GIF o WEBP.`;
                    event.target.value = '';
                    btnSubirFoto.disabled = true;
                    btnSubirFoto.style.cursor = 'not-allowed';
                    generarAlerta(mensaje);
                    return;
                }

                // Validación de tamaño de archivo
                if (fichero.size > tamanioMaximoBytes) {
                    mensaje = `El archivo es demasiado grande (${(fichero.size / (1024 * 1024)).toFixed(2)} MB). Máximo ${tamanioMaximoMB} MB.`;
                    event.target.value = '';
                    btnSubirFoto.disabled = true;
                    btnSubirFoto.style.cursor = 'not-allowed';
                    generarAlerta(mensaje);
                    return;
                }

                if (fichero) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        imagePreview.src = e.target.result;
                        imagePreview.style.display = 'flex';
                    };
                    reader.readAsDataURL(fichero);
                    btnSubirFoto.disabled = false;
                } else {
                    imagePreview.style.display = 'none';
                    btnSubirFoto.style.cursor = 'auto';
                    imagePreview.src = '#';
                }
                
            });


    btnSubirFoto.addEventListener("click", (event) => {
        event.preventDefault();


        if(inputSubirFoto.files.length > 0){

            const nombre  = document.getElementById("nombre").value.toLowerCase();
            const nombreSinEspacios = nombre.replace(/ /g, "");
            
            const opcionesColor = document.getElementsByName("colorFoto");
            let  colorFoto;
            
            for(let color of opcionesColor){
                if(color.checked){
                    colorFoto = color.value;
                }
            }
            
            if(colorFoto){
                const fichero = inputSubirFoto.files[0];
                const [colorPatron, colorBase] = colorFoto.toLowerCase().split(" y "); 
                const nombreFoto =  `${nombreSinEspacios}-${colorPatron}-${colorBase}-anverso`;

                const nuevaImagenPersonalizada = {
                    file: fichero, 
                    dataURL: imagePreview.src,
                    customName: nombreFoto || file.name.split('.')[0]
                };



                const fotosCliente = document.querySelector(".fotos");


                const divNuevaFoto = document.createElement('div');
                divNuevaFoto.className = 'imagenProducto';

                const nuevaFoto = document.createElement('img');
                nuevaFoto.src = nuevaImagenPersonalizada.dataURL;
                nuevaFoto.alt = nuevaImagenPersonalizada.customName || nuevaImagenPersonalizada.originalFileName;

                const removeBtn = document.createElement('span');
                removeBtn.className = 'eliminar';
                removeBtn.innerHTML = '&times;';

                divNuevaFoto.appendChild(removeBtn);
                divNuevaFoto.appendChild(nuevaFoto);
                
                
                fotosCliente.appendChild(divNuevaFoto);
                
                activarCruces();
                cambios = true;

                document.querySelector(".addFoto").style.display = "none";

            }else{
                generarAlerta("Seleccione un color")
            }
        }else{
            generarAlerta("Añada una foto");
        }

    });


}



function activarCruces(){
    const btnFotos = document.querySelectorAll(".imagenProducto .eliminar");
    const colores = document.querySelectorAll(".stock .quitarColor");
    const tallas = document.querySelectorAll(".talla .quitarColorTalla");
    const cerrarDialogo = document.querySelectorAll(".cerrarCuadro");
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

    for(let boton of cerrarDialogo){
        boton.addEventListener("click", (event) =>{
            const elementoPadre = boton.parentNode;
            elementoPadre.style.display = "none";
        });
    }
}