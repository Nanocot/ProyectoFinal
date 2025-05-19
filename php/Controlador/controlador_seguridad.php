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
                require_once "php/Vista/login.php";
                echo "<div class='error'>Inicio de sesión incorrecto</div>";
            }
            
            

        }


        public function cerrarSesion(){
            $modeloSeguridad = new ModeloSeguridad();

            $modeloSeguridad->cerrarSesion();

        }
    }

?>