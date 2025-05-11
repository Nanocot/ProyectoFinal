<?php
    require_once "php/Controlador/controlador_seguridad.php";
    require_once "php/Controlador/controlador_tablas.php";
    require_once "php/Controlador/controlador_navegador.php";

    
    //Comprobamos si la sesión está iniciada, si no lo está, la iniciamos
    if(!isset($_SESSION)) {
        session_start();
    }


    //Creamos los objetos controladores
    $controladorSeguridad = new ControladorSeguridad();
    $controladorTablas = new ControladorTablas();
    $controladorNavegador = new ControladorNavegador();


    //Comprobamos la acción que va a realizar el usuario
    // $action = isset($_GET["action"]) ? $_GET["action"] : "home";
    $action = $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["action"]) ? $_POST["action"] : (isset($_GET["action"]) ? $_GET["action"] : "home");

    echo $action;


    //Comprobamos a que controlador pertenece la acción
    if(method_exists($controladorSeguridad, $action)){
        //En el caso de que exista usamos el método
        $controladorSeguridad->$action();
    }else if(method_exists($controladorTablas, $action)){
        $controladorTablas->$action();
    }else if(method_exists($controladorNavegador, $action)){
        $controladorNavegador->$action();
    }else{
        //Por defecto mandamos a la página de error 404
        $controladorNavegador->err404();
    }


