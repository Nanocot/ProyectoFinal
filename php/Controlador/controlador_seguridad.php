<?php 
    require_once "php/Modelo/modelo_seguridad.php";

    class ControladorSeguridad{
        
        public function login(){
            $modeloSeguridad = new ModeloSeguridad();
            

            if($modeloSeguridad->login()){
                
                if($_SESSION["usuario"] == "Administrador"){
                    header("location: index.php?action=dashboard");
                }else{
                    header("location: index.php?action=paginausuario");
                }


            }else{
                echo "Inicio de sesión incorrecto";
            }
            
            

        }


        public function cerrarSesion(){
            $modeloSeguridad = new ModeloSeguridad();

            $modeloSeguridad->cerrarSesion();

        }
    }

?>