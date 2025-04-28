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
        public function register($nombre, $apellido1, $apellido2 = null, $email, $password, $phoneNumber, $estado = true, $newsletter){
            try{
                //Nos aseguramos que los datos necesarios existen para evitar insercciones con los datos insuficientes
                if($nombre != null && $apellido1 != null && $email != null && $password != null && $phoneNumber != null && $newsletter!= null){    
                    //Preparamos el sql de insercción
                    $sql = "insert into usuarios (Email, Nombre, Apellido1, Apellido2, Password, Telefono, Estado, NewsLetter) values (?, ?, ?, ?, ?, ?, ?, ?);";
                    
                    //Ciframos la contraseña
                    $cifpass = password_hash($password, PASSWORD_DEFAULT);
                    
                    $stmt = $this->conex->prepare($sql);
                    
                    if($stmt->execute([$email, $nombre, $apellido1, $apellido2, $cifpass, $phoneNumber, $estado, $newsletter])){
                        return true;
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
            }catch(PDOException $e){
                if($e->getCode() == 23000){
                    return "Este correo ya está registrado";
                }

            }
        }

    }