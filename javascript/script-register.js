
function activarListeners(){

    
    let btnEnviar = document.querySelector("button");
    let formulario = document.querySelector("form");


    btnEnviar.addEventListener("click", (event) =>{
        event.preventDefault();
        let mensaje = "";
        let error = 0;



        let nombre = document.querySelector("#nombre");
        let ape1 = document.querySelector("#apellido1");
        let ape2 = document.querySelector("#apellido2");
        let correo = document.querySelector("#email");
        let pass1 = document.querySelector("#password1");
        let pass2 = document.querySelector("#password2");
        let telf = document.querySelector("#phonenumber");
        let noticias = document.querySelector("#newsletter");
        
        let valEmail = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;


        if(nombre.value == ""){
            mensaje = "El nombre está vacio";
            error +=1;
            generarAlerta(mensaje);
        }else if(ape1.value == "" && ape2.value == ""){
            mensaje = "Los apellidos están vacios";
            error += 1;
            generarAlerta(mensaje);
        }else if(!valEmail.test(correo.value)){
            mensaje = "El correo está mal escrito";
            error += 1;
            generarAlerta(mensaje);
        }else if(pass1.value != pass2.value){
            error += 1;
            mensaje = "Las contraseñas no coinciden";
            generarAlerta(mensaje);
        }


        if(error == 0){
            localStorage.setItem("user", correo.value);
            localStorage.setItem("pass", pass1.value);
            formulario.submit();
        }

        
    });

}



function redirigir(){
    let alerta = document.querySelector(".alerta");
    console.log(alerta.textContent);

    if(alerta.textContent == "Usuario registrado con éxito"){
        setTimeout(()=>{
            let email = localStorage.getItem("user");
            let pass = localStorage.getItem("pass");
            localStorage.removeItem("user");
            localStorage.removeItem("pass");
            enviarFormulario(email, pass);

        }, 1000);
    }
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


activarListeners();
borrarAlerta();
redirigir();



