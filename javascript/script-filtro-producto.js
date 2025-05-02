// Declaración de variables
const nombre = document.getElementById("nombreProd");
const precio = document.getElementById("precioProd");
const descp = document.getElementById("descpProd");
const colores = document.getElementById("colores");
const tallas = document.getElementById("tallas");
const imagen = document.getElementById("imagenProd");

let jsonFINAL;
let arrayINFO;
let tallaSELECT = "";
let colorSELECT = "";
const arrayTallas = [];
const arrayColores = [];




//Función para mostrar JSON en la página
function mostrarEnPagina(mensaje) {
    const resultadoDiv = document.getElementById("resultado");
    resultadoDiv.textContent = mensaje;
}


//Función para rellenar los datos del producto
async function rellenarProducto() {
    //Declaración de variables
    const urlParams = new URLSearchParams(window.location.search);
    const productId = urlParams.get('id');
    const productCategoria = urlParams.get('categoria');
    const url = `index.php?action=volcarApi&id=${productId}&categoria=${productCategoria}`;
    const datos = await fetch(url);

    jsonFINAL = await datos.json();

    // mostrarEnPagina(JSON.stringify(jsonFINAL, null, 2));

    //Añadimos los datos a la tarjeta del producto
    nombre.innerHTML = jsonFINAL["Nombre"];
    precio.textContent = jsonFINAL["Precio"];
    descp.textContent = jsonFINAL["Descripcion"];

    arrayINFO = jsonFINAL["Informacion"];

    //Generamos un array de las tallas disponibles del producto 
    Object.entries(arrayINFO).forEach((talla, value1) => {
        arrayTallas.push(talla);
    });

    // Generamos los selects del producto
    for (let talla of arrayTallas) {
        //Añadimos la opción con la talla correspondiente
        tallas.innerHTML += `<option value='${talla[0]}'>${talla[0]}</option>`;
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

}



//Función para cambiar los colores disponibles según la talla
function cambiarCOLORES(talla) {
    //Añadimos la opción de elija una, para que no se borre
    colores.innerHTML = "<option  disabled>Elija una</option>";
    //Guardamos la talla para que no se cambie constantemente
    tallaSELECT = talla;

    //Recorremos el array de las tallas con los colores disponbles de cada talla
    for(let celda of arrayTallas) {
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
}


//Función para cambiar las tallas disponibles según el color
function cambiarTALLAS(color) {
    //Añadimos la opción de elija una, para que no se borre
    tallas.innerHTML = "<option  disabled>Elija una</option>";
    //Dividimos los colores en un array para tener separado el color del patrón y de la base
    let colorinchis = color.split(" y ");
    //Guardamos el color para que no se cambie constantemente
    colorSELECT = color;
    //Recorremos todas las tallas disponibles con los colores de cada una
    for(let celda of arrayTallas) {
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
}


//Función para añadir al carrito
function addToCart() {
    //Comprobamos que tenemos seleccionado el color y la talla
    if(tallas.value != "Elija una" && colores.value  != "Ejina una" && tallas.value != "" && colores.value != ""){
        console.log("carrito actualizado");
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
});



//LLamamos a la función asincrona para que se rellenen los campos de la tarjeta del producto
rellenarProducto();







