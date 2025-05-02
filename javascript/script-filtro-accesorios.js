const nombre = document.getElementById("nombreProd");
const precio = document.getElementById("precioProd");
const descp = document.getElementById("descpProd");
const colores = document.getElementById("colores");
const imagen = document.getElementById("imagenProd");

let jsonFINAL;
let arrayINFO;
const arrayColores = [];





function mostrarEnPagina(mensaje) {
    const resultadoDiv = document.getElementById("resultado");
    resultadoDiv.textContent = mensaje;
}



async function rellenarProducto() {
    const urlParams = new URLSearchParams(window.location.search);
    const productId = urlParams.get('id');
    const productCategoria = urlParams.get('categoria');
    const url = `index.php?action=volcarApi&id=${productId}&categoria=${productCategoria}`;
    const datos = await fetch(url);

    jsonFINAL = await datos.json();

    // mostrarEnPagina(JSON.stringify(jsonFINAL, null, 2));

    nombre.innerHTML = jsonFINAL["Nombre"];
    precio.textContent = jsonFINAL["Precio"];
    descp.textContent = jsonFINAL["Descripcion"];



    arrayINFO = jsonFINAL["Colores"];

    for (let parCOLOR of arrayINFO) {
        let opcion = `${parCOLOR["ColorPatron"]} y ${parCOLOR["ColorBase"]}`;
        console.log(opcion);
        colores.innerHTML += `<option value=${opcion}> ${opcion} </option>`;
    }


}

function addToCart() {

}

rellenarProducto();
