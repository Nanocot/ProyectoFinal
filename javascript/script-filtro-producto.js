function mostrarEnPagina(mensaje) {
    const resultadoDiv = document.getElementById("resultado");
    resultadoDiv.textContent = mensaje;
}



async function cogerAPI(){
    const urlParams = new URLSearchParams(window.location.search);
    // console.log(urlParams);
    const productId = urlParams.get('id');
    // console.log(productId); 
    const url = `index.php?action=volcarApi&id=${productId}`;

    const datos = await fetch(url);

    const datosJSON  = await datos.json();
    mostrarEnPagina(JSON.stringify(datosJSON, null, 2));
}


function mostrarTallas(datos, divColores){


}



datos = cogerAPI();
console.log(typeof(datos));

window.addEventListener("load", (event) =>{
    const nombre = document.getElementById("nombreProd");
    const precio = document.getElementById("precioProd");
    const descp = document.getElementById("descpProd");
    const colores = document.getElementById("coloresProd");
    const tallas = document.getElementById("tallasProd");
    const imagen = document.getElementById("imagenProd");

    nombre.innerHTML =  datos["Nombre"];
    precio.textContent = datos["Precio"];
    descp.textContent = datos["Descripcion"];

});

// cogerAPI();







