//Declaración de variables
const nombre = document.getElementById("nombreProd");
const precio = document.getElementById("precioProd");
const descp = document.getElementById("descpProd");
const colores = document.getElementById("colores");
const imagen = document.getElementById("imagenProd");
const stock = document.getElementById("stock");
const candidad = document.getElementById("cantidad");

const urlParams = new URLSearchParams(window.location.search);
const productId = urlParams.get('id');
const productCategoria = urlParams.get('categoria');

let jsonFINAL;
let arrayINFO;
let unidades;
const arrayColores = [];




//Función para mostrar el JSON en la página
function mostrarEnPagina(mensaje) {
    const resultadoDiv = document.getElementById("resultado");
    resultadoDiv.textContent = mensaje;
}


//Función para rellenar el accesorio
async function rellenarProducto() {
    const url = `index.php?action=volcarApi&id=${productId}&categoria=${productCategoria}`;
    const datos = await fetch(url);

    jsonFINAL = await datos.json();

    // mostrarEnPagina(JSON.stringify(jsonFINAL, null, 2));

    //Rellenamos los datos del producto que son inmutables
    nombre.innerHTML = jsonFINAL["Nombre"];
    precio.textContent = jsonFINAL["Precio"];
    descp.textContent = jsonFINAL["Descripcion"];
    cantidad.setAttribute("max", jsonFINAL["Stock"]);
    imagen.setAttribute("src", jsonFINAL["Foto"][0]);

    //Guardamos los colores del accesorio en un array
    arrayINFO = jsonFINAL["Colores"];

    //Generamos la primera opción del select
    colores.innerHTML = "<option disabled selected>Elija una</option>";

    //Rellenamos el select de colores con todos los colores disponibles
    for (let parCOLOR of arrayINFO) {
        let opcion = `${parCOLOR["ColorPatron"]} y ${parCOLOR["ColorBase"]}`;
        colores.innerHTML += `<option value=${opcion}> ${opcion} </option>`;
    }

    

}

function cambiarFoto(color, fotos){
    let base = color.toLowerCase().split(" y ");
    for(let foto of fotos){
        let parametros = foto.split("-");
        if(parametros[1] === base[0]){
            return  foto;
        }
    }
}



//Añadimos listener para cuando seleccionamos el color, para generar el botón de limpiar los filtros 
colores.addEventListener("change", (event) =>{
    colorSELECT = event.target.value;
    producto.appendChild(btnLimpiar);
    let ruta = cambiarFoto(colorSELECT, jsonFINAL["Foto"]);
    if(ruta){
        imagen.setAttribute("src", ruta);
    }

    console.log(colorSELECT);
    stock.textContent = `Quedan: ${jsonFINAL["Stock"][colorSELECT]}`;
    unidades = sacarStock();
});


//Llamamos a la función para rellenar el accesorio
rellenarProducto();
