<?php

    require_once  "conexion.php";

    class ModeloUsuarios{

        private $conex;

        public function __construct(){
            $this->conex = ModeloConexion::conectar();
        }

        //Función para sacar todos los usuarios y sus datos de inicio de sesión
        public function datosInicio($email){
            //Generamos el sql en el que vamos a recuperar la contraseña del email solicitado
            $sql = "select password from usuarios where email = ?";
            $stmt = $this->conex->prepare($sql);

            //Comprobamos que el email esté registrado dentro de la base de datos
            if($stmt->execute([$email]) && $stmt->rowCount() > 0){
                //En caso de que exista, devolvemos la constraseña
                $password = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $password[0];
            }else{
                //Si no existe devolvemos un valor negativo
                return -1;
            }
        }




        //Función para registro de usuario
        public function register(){
            
        }

    }