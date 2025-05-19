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

                //Creamos el patrón para ver si las contraseñas recuperadas están cifradas
                $patron = "/^\$2[ayb]\$.{56}$/";

                



                //Comprobamos que tiene contraseña
                if($passControl != -1){
                    //Comprobamos si la contraseña está cifrada
                    if(preg_match($patron, $passControl["password"]) && password_verify($password, PASSWORD_DEFAULT)){
                        if($this->comprobarAdministrador($email)){
                            $_SESSION["usuario"] = "Administrador";
                            return true;
                        }
                        $_SESSION["usuario"] = "Usuario";
                        return true;
                    }else if($passControl["password"] === $password){
                        if($this->comprobarAdministrador($email)){
                            $_SESSION["usuario"] = "Administrador";
                            return true;
                        }
                        $_SESSION["usuario"] = "Usuario";
                        return true;
                    }
                    return false;
                }else{
                    return false;
                }
            }
            
        }

        public function comprobarAdministrador($usuario){
            $arrayAdministradores = ["admin@farko.es"];

            if(in_array($usuario, $arrayAdministradores)){
                return true;
            }else{
                return false;
            }
        }


        public function cerrarSesion(){
            session_destroy();
        }
    }


?>