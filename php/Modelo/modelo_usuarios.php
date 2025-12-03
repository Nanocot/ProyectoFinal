<?php

    require_once  "conexion.php";

    class ModeloUsuarios{

        private $conex;

        public function __construct(){
            $this->conex = ModeloConexion::conectar();
        }

        //Función para sacar todos los usuarios y sus datos de inicio de sesión
        public function datosInicio($email){
            try{

                //Generamos el sql en el que vamos a recuperar la contraseña del email solicitado
                $sql = "select password from usuarios where email = ?";
                $stmt = $this->conex->prepare($sql);
                
                //Comprobamos que el email esté registrado dentro de la base de datos
                if($stmt->execute([$email]) && $stmt->rowCount() > 0){
                    //En caso de que exista, devolvemos la constraseña
                    $password = $stmt->fetch(PDO::FETCH_ASSOC);
                    return $password;
                }else{
                    //Si no existe devolvemos un valor negativo
                    return -1;
                }
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }




        //Función para registro de usuario
        public function register($nombre, $apellido1, $apellido2 = null, $email, $password, $phoneNumber, $estado = true, $newsletter){
            try{
                //Nos aseguramos que los datos necesarios existen para evitar insercciones con los datos insuficientes
                if($nombre != null && $apellido1 != null && $email != null && $password != null && $phoneNumber != null){    
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
                    return false ;
                }
            }catch(PDOException $e){
                if($e->getCode() == 23000){
                    return "Este correo ya está registrado";
                }
                return $e->getMessage();

            }
        }

        //Función para mostrar los usuarios dentro del dashboard
        public function mostrarUsuarios(){
            try{
                //Generamos la sentencia sql con los datos que necesitamos
                $sql = "select email, nombre, apellido1, apellido2, telefono, estado, newsletter
                from usuarios;";

                $stmt = $this->conex->prepare($sql);

                $stmt->execute();

                //Comprobamos que nos devuelve datos
                if($stmt->rowCount() > 0){
                    //En caso de que devuelva datos, volcamos los datos en un array
                    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    //Devolvemos el array de usuarios
                    return $usuarios;
                }else{
                    return "No hay usuarios registrados";
                }
            }catch(PDOException $e){
                return $e->getMessage();
            }
        }


        //Función para sacar un usuario en específico
        public function sacarUsuario($email){
            try{
                //Generamos la consulta, con lo todos los datos del usuario que queremos buscar
                $sql = "select u.nombre, u.apellido1, u.apellido2, u.telefono, u.estado, u.newsletter, d.numero, d.codpostal, d.calle, d.poblacion, d.puerta, d.planta
                from usuarios u left join direcciones d on u.email = d.emailusuario 
                where email = ?;";


                $stmt = $this->conex->prepare($sql);

                $stmt->bindParam(1, $email, PDO::PARAM_STR);

                $stmt->execute();

                if($stmt->rowCount() > 0){
                    //Volcamos los datos en un array (En este caso uso solo fetch, ya que solo se espera una fila)
                    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

                    return $resultado;
                }else{
                    return "Usuario no encontrado";
                }



            }catch(PDOException $e){
                return $e->getMessage();
            }
        }


        //Función para modificar el estado de un usuario
        public function modificarEstado($email, $estado){

            try{
                //Generamos la sentencia sql
                $sql = "update usuarios set estado = ? where email = ?";

                $stmt = $this->conex->prepare($sql);
                //Bindeamos los parametros a la sentencia
                $stmt->bindParam(1, $estado, PDO::PARAM_BOOL);
                $stmt->bindParam(2, $email, PDO::PARAM_STR);

                if($stmt->execute()){
                    //Al ser una actualización, si ejecuta significa que ha salido bien
                    return true;
                }else{
                    return false;
                }



            }catch(PDOException $e){
                return $e->getMessage();
            }




        }



        // Función para sacar los datos del usuario
        public function datosUsuario(){
            try{


                //Sentencia sql para sacar los datos necesarios
                $sql = "select u.nombre, concat_ws(' ', u.apellido1, u.apellido2) as apellidos, u.telefono, u.newsletter, d.id, d.numero, d.codPostal, d.calle, d.poblacion, d.puerta, d.planta 
                from usuarios u 
                left join direcciones d on u.email = d.emailusuario
                where u.email = '{$_SESSION["usuario"]}'";
                
                $stmt = $this->conex->prepare($sql);

                if($stmt->execute()){
                    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

                    return $resultado;
                }else{
                    return false;
                }


            }catch(PDOException $e){
                return $e->getMessage();
            }
        }


        public function modPerfil($email, $nombre, $apellidos){
            try{
                [$apellido1, $apellido2] = explode(" ", $apellidos);
                



                $sql = "update usuarios set nombre = ?, apellido1 = ?, apellido2 = ? where email = ?";

                $stmt = $this->conex->prepare($sql);

                if($stmt->execute([$nombre, $apellido1, $apellido2, $email])){
                    return true;
                }else{
                    return false;
                }


            }catch(PDOException $e){
                return $e->getMessage();
            }




        }






    }