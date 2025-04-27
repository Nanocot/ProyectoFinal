<?php
    require_once "php/Controlador/controlador_seguridad.php";
    
    //Comprobamos si la sesión está iniciada, si no lo está, la iniciamos
    if(!isset($_SESSION)) {
        session_start();
    }


    //Creamos los objetos controladores
    $controladorSeguridad = new ControladorSeguridad();


    //Comprobamos la acción que va a realizar el usuario
    $action = isset($_GET["action"]) ? $_GET["action"] : "home";


    //Comprobamos a que controlador pertenece la acción
    if(method_exists($controladorSeguridad, $action)){
        //En el caso de que exista usamos el método
        $controladorSeguridad->$action();
    }


