function activarListeners(){

    //Sacamos todos los datos que tenemos que comprobar
    const numTarj = document.querySelector("#numeroTar");
    const nombTitu = document.querySelector("#nombreTitu");
    const caducidad = document.querySelector("#expiryDate");
    const codigo = document.querySelector("#cvv");
    const btnPagar = document.querySelector("#btnPagar");

    const formulario = document.querySelector("#formularioPago");


    // formulario.addEventListener("submit", (event) => {
    //     event.preventDefault();

    //     console.log("HOLA");    
    // });

    // Agregar un "event listener" para detectar la entrada del usuario
    caducidad.addEventListener('input', (e) => {
        let value = e.target.value;
        // Eliminar cualquier caracter que no sea un dígito
        value = value.replace(/\D/g, ''); 

        //Comprobamos que los meses no pasen de doce
        if(value.substring(0, 2) <= 12 && value > 0){

            // Si la longitud del valor es exactamente 2, o si el usuario está borrando el "/", 
            // no se agrega una barra. Se añade un "/" si la longitud es 2.
            // Además si el primer digito es mayor a 1, no dejamos que escriba.
            if (value.length > 2 && !value.includes('/')) {
                value = value.substring(0, 2) + '/' + value.substring(2, 4);
            } else if (value.length === 2 && !value.includes('/')) {
                value = value + '/';
            }
            
            // Limitar la longitud del input a 5 caracteres (MM/AA)
            if (value.length > 5) {
                value = value.substring(0, 5);
            }
            
            e.target.value = value;
        }else if(value.substring(0) == 1){
            e.target.value = value[0];
        }else{
            e.target.value= "";
        }
    });

    btnPagar.addEventListener("click", (event) =>{
        
        let mensaje = "";

        let fechaHoy = new Date;
        let anio = fechaHoy.getFullYear();
        let anioUser = parseInt(caducidad.value.substring(3)) + 2000;


        if(numTarj.value === "" || nombTitu.value === "" || codigo.value === "" || caducidad.value === ""){
            event.preventDefault();
            mensaje = "Por favor rellene los campos"
        }

        if(anioUser < anio){
            event.preventDefault();
            mensaje = "La tarjeta está caducada";
        }

        if(mensaje != ""){
            generarAlerta(mensaje);
        }



    });



}

activarListeners();