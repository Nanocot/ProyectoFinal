window.addEventListener("DOMContentLoaded", (event) => {
    activarListener();
});



function activarListener(){
    const btnIniciar = document.querySelector("#envio");



    btnIniciar.addEventListener("click", (event) =>{
        event.preventDefault();

        const  email = document.querySelector("#email");
        const password = document.querySelector("#password");

        if(email.value != "" && password.value != ""){
            enviarFormulario(email.value, password.value);
        }else{
            generarAlerta("Rellene los campos");
        }


    });
}



async function enviarFormulario(email, password){

    const datosEnvio = {"email" : email,  "password" : password}

    const datosPOST = new URLSearchParams(datosEnvio).toString();

    try{
        fetch("../index.php?action=login", {
            method : "POST",
            body: datosPOST,
            headers: {
                "Content-Type" : "application/x-www-form-urlencoded"
            }
        })
        .catch((reject) => console.log(reject))
        .then((response) => response.json())
        .then((html) => {
            
            if(html["inicio"]){
                window.location.href = html["redirect"];
            }else{
                generarAlerta(html["mensaje"]);
            }


        });
    }catch(error){
        console.log("Error antes del fetch", error);
    }


}