const nombre = document.getElementById("nombreProd");
const precio = document.getElementById("precioProd");
const descp = document.getElementById("descpProd");
const colores = document.getElementById("colores");
const tallas = document.getElementById("tallas");
const imagen = document.getElementById("imagenProd");

let jsonFINAL;
let arrayINFO;





function mostrarEnPagina(mensaje) {
    const resultadoDiv = document.getElementById("resultado");
    resultadoDiv.textContent = mensaje;
}



async function rellenarProducto(){
    const urlParams = new URLSearchParams(window.location.search);
    // console.log(urlParams);
    const productId = urlParams.get('id');
    // console.log(productId); 
    const url = `index.php?action=volcarApi&id=${productId}`;

    // const url = "productos-diferentes.json";
    const datos = await fetch(url);

    jsonFINAL  = await datos.json();
    // mostrarEnPagina(JSON.stringify(jsonFINAL, null, 2));


    nombre.innerHTML =  jsonFINAL["Nombre"];
    precio.textContent = jsonFINAL["Precio"];
    descp.textContent = jsonFINAL["Descripcion"];

    arrayINFO = jsonFINAL["Informacion"];

    const arrayTallas = [];

    Object.entries(arrayINFO).forEach((talla, value1)=>{
        arrayTallas.push(talla);
    });

    // console.log(arrayTallas);

    let cont = 0;

    for(let talla of arrayTallas){
        tallas.innerHTML += "<option>" + talla[0] + "</option>";
            if(cont == 0){
                for(let j = 0; j < arrayTallas[0][1].length; j++){
                    let opcion = `${arrayTallas[0][1][j]["ColorPatron"]} y ${arrayTallas[0][1][j]["ColorBase"]}`;
                    colores.innerHTML += "<option>" + opcion + "</option>";
                }
            }
            cont += 1;
        
    }
}


function addToCart(){
    
}

rellenarProducto();

    
    

    



// cogerAPI();







