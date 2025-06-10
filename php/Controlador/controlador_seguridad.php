<?php 
    require_once "php/Modelo/modelo_seguridad.php";

    class ControladorSeguridad{
        
        public function login(){
            $modeloSeguridad = new ModeloSeguridad();

            header("Content-Type: application/json");

            if($modeloSeguridad->login()){
                
                if($_SESSION["usuario"] == "Administrador"){
                    $respuesta = ["inicio" => true, "redirect" =>  "index.php?action=dashboard"];
                    echo json_encode($respuesta);
                }else{
                    $respuesta = ["inicio" => true, "redirect" =>  "index.php?action=paginausuario"];
                    echo json_encode($respuesta);
                }
            }else{
                $respuesta = ["inicio" => false, "mensaje" =>  "Inicio de sesión incorrecto"];
                echo json_encode($respuesta);
            }
            
            

        }


        public function cerrarSesion(){
            $modeloSeguridad = new ModeloSeguridad();

            $modeloSeguridad->cerrarSesion();

        }
    }

?>