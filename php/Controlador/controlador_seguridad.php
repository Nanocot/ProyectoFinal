<?php 
    require_once "php/Modelo/modelo_seguridad.php";

    class ControladorSeguridad{
        
        public function login(){
            $modeloSeguridad = new ModeloSeguridad();
            

            if($modeloSeguridad->login()){
                echo "Inicio de sesión correcto";
            }else{
                echo "HAS FALLADO";
            }
            
            

        }
    }

?>