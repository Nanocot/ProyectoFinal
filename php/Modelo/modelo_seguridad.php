<?php 
    require_once "conexion.php";
    require_once "modelo_usuarios.php";

    class ModeloSeguridad{

        private $conex;

        public function __construct(){
            $this->conex = ModeloConexion::conectar();
        }

        public function login(){
            $modeloUsuario = new ModeloUsuarios();
            //Comprobamos que han enviado un formulario
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $email  = $_POST["email"];
                $password = $_POST["password"];
                //Guardamos la contraseña que ha devuelto la base de datos
                $passControl = $modeloUsuario->datosInicio($email);

                //Comprobamos que tiene contraseña y que es la correcta
                if($passControl != -1 && $passControl["password"] === $password){
                    return true;
                }else{
                    return false;
                }
            }



            
        }



    }


?>