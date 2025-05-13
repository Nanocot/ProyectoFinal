// Declaración de variables
const nombre = document.getElementById("nombreProd");
const precio = document.getElementById("precioProd");
const descp = document.getElementById("descpProd");
const colores = document.getElementById("colores");
const tallas = document.getElementById("tallas");
const imagen = document.getElementById("imagenProd");
const stock = document.getElementById("stock");
const cantidad = document.getElementById("cantidad");

const urlParams = new URLSearchParams(window.location.search);
const productId = urlParams.get('id');
const productCategoria = urlParams.get('categoria');

let jsonFINAL;
let arrayINFO;
let arrayIDTALLAS;
let unidades;

const arrayTallasColores = [];
const arrayColores = [];
const arrayTallas = [];

//Función para mostrar JSON en la página
function mostrarEnPagina(mensaje) {
    const resultadoDiv = document.getElementById("resultado");
    resultadoDiv.textContent = mensaje;
}



//Función para rellenar los datos del producto
async function rellenarProducto() {
    //Declaración de variables
    const url = `index.php?action=volcarApi&id=${productId}&categoria=${productCategoria}`;
    const datos = await fetch(url);

    jsonFINAL = await datos.json();

    // mostrarEnPagina(JSON.stringify(jsonFINAL, null, 2));

    //Añadimos los datos a la tarjeta del producto
    nombre.innerHTML = jsonFINAL["Nombre"];
    precio.textContent = jsonFINAL["Precio"];
    descp.textContent = jsonFINAL["Descripcion"];
    cantidad.setAttribute("max", jsonFINAL["Stock"]);
    imagen.setAttribute("src", jsonFINAL["Foto"][0]);

    arrayINFO = jsonFINAL["Informacion"];
    arrayIDTALLAS = jsonFINAL["IdTallas"];

    //Generamos un array de las tallas disponibles del producto 
    Object.entries(arrayINFO).forEach((talla, value1) => {
        arrayTallasColores.push(talla);
    });

    Object.entries(arrayIDTALLAS).forEach((talla, value1) => {
        arrayTallas.push(talla);
    });

    //Llamamos a la función de generar los selects
    generarSelects();

    


}


//Función para generar los selects desde 0
function generarSelects(){
    tallas.innerHTML = "<option disabled selected>Elija una</option>";
    colores.innerHTML = "<option disabled selected>Elija una</option>";

    // Generamos los selects del producto
    for (let talla of arrayTallasColores) {
        //Añadimos la opción con la talla correspondiente
        tallas.innerHTML += `<option value='${  talla[0]}'>${talla[0]}</option>`;
            //Recorremos los colores de las tallas del producto
            for (let i = 0; i < talla[1].length; i++) {
                //Generamos la opción del color con la forma que queremos que se muestre al usuario
                let opcion = `${talla[1][i]["ColorPatron"]} y ${talla[1][i]["ColorBase"]}`;
                //Comprobamos que el color no ha sido añadido antes, ya que distintas tallas pueden tener los mismos colores
                if(!arrayColores.includes(opcion)){
                    //Generamos la opción del color con la forma que queremos que se muestre al usuario
                    colores.innerHTML += `<option value='${opcion}'> ${opcion} </option>`;0
                    arrayColores.push(opcion);
                }
            }
    }

    //Vaciamos el array de colores para que el botón de limpiar funcione
    arrayColores.length = 0;
}



//Función para cambiar los colores disponibles según la talla
function cambiarCOLORES(talla) {
    //Añadimos la opción de elija una, para que no se borre
    colores.innerHTML = "<option disabled>Elija una</option>";
    //Guardamos la talla para que no se cambie constantemente
    tallaSELECT = talla;

    //Recorremos el array de las tallas con los colores disponbles de cada talla
    for(let celda of arrayTallasColores) {
        //Cuando encontramos la talla dentro del array  añadimos los colores disponibles de la misma
        if (celda[0] == talla) {
            for (let i = 0; i < celda[1].length; i++) {
                let opcion = `${celda[1][i]["ColorPatron"]} y ${celda[1][i]["ColorBase"]}`;
                colores.innerHTML += `<option value="${opcion}"> ${opcion} </option>`;
            }
            
        }
    }
    //Comprobamos que los colores tengan el color seleccionado para que no se cambie constantemente
    if(colores.innerHTML.includes(colorSELECT) && colorSELECT != ""){
        colores.value = colorSELECT;
    }else{
        //Por defecto dejamos seleccionada la opción de Elija una
        colores.value = "Elija una";
    }

    //Al final añadimos el botón para limpiar los filtros
    producto.appendChild(btnLimpiar);
}


//Función para cambiar las tallas disponibles según el color
function cambiarTALLAS(color) {
    //Añadimos la opción de elija una, para que no se borre
    tallas.innerHTML = "<option disabled>Elija una</option>";
    //Dividimos los colores en un array para tener separado el color del patrón y de la base
    let colorinchis = color.split(" y ");
    //Guardamos el color para que no se cambie constantemente
    colorSELECT = color;
    //Recorremos todas las tallas disponibles con los colores de cada una
    for(let celda of arrayTallasColores) {
        //Dentro de cada talla comprobamos los colores
        for (let i = 0; i < celda[1].length; i++) {
            //Si la talla tiene el color seleccionado, añadimos la talla al select
            if(celda[1][i]["ColorPatron"] == colorinchis[0] && celda[1][i]["ColorBase"] == colorinchis[1]){
                tallas.innerHTML += `<option value="${celda[0]}"> ${celda[0]} </option>`;
            }
        }
        
    }

    //Comprobamos que la talla este dentro de las disponibles y la seleccionamos, para que no cambie constantemente
    if(tallas.innerHTML.includes(tallaSELECT) && tallaSELECT != ""){
        tallas.value = tallaSELECT;
    }else{
        //Por defecto dejamos seleccionada la opción de Elija una
        tallas.value = "Elija una";
    }

    //Al final añadimos el botón para limpiar el filtro
    producto.appendChild(btnLimpiar);
}

//Función para cambiar las fotos de las prendas
function cambiarFoto(color, fotos){
    let base = color.toLowerCase().split(" y ");
    for(let foto of fotos){
        let parametros = foto.split("-");
        if(parametros[1] === base[0] && parametros[2] === base[1]){
            return  foto;
        }
    }
}





//Evento para cambiar los colores disponibles según la talla
tallas.addEventListener("change", (event) => {
    let seleccionado = event.target.value;
    cambiarCOLORES(seleccionado);

});

//Evento para cambiar las tallas disponibles según el color
colores.addEventListener("change", (event) => {
    let seleccionado = event.target.value;
    cambiarTALLAS(seleccionado);
    let ruta = cambiarFoto(seleccionado, jsonFINAL["Foto"]);
    if(ruta){
        imagen.setAttribute("src", ruta);
    }
    stock.textContent = `Quedan: ${jsonFINAL["Stock"][seleccionado]}`;
    unidades = sacarStock();
});



//LLamamos a la función asincrona para que se rellenen los campos de la tarjeta del producto
rellenarProducto();







