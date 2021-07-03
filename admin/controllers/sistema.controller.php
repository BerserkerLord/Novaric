<?php
    session_start();
    require_once dirname(__FILE__).'../../../vendor/autoload.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    require_once('init.php');

    class Sistema
    {
        //Para PostgresSQL
        /*var $dsn = "pgsql:host=localhost;port=5432;dbname=hospital";
        var $user = "hospital";
        var $pass = "123456";
        var $engine = "postgresql";*/

        //Para MariaDB
        var $dsn = "mysql:host=localhost;dbname=novaric";
        var $user = "admin_novaric";
        var $pass = "123456";
        var $engine = "mariadb";

       /*
        * Metodo que regresa el motor que se esta usando
        * Return String con el motor que se esta usando
        */
        function getEngine(){ return $this -> engine; }

        /*
        * Método para conectar a ka base de datos
        * Return variable con la conexión a la base de fatos
        */
        function Connect(){
            $dbh = new PDO($this -> dsn, $this -> user, $this -> pass);
            return $dbh;
        }

        /*
        * Método para obtener RFC de un empleado
        * Params String  @correo recibe el correo del usuario
        * Return String con el RFC del usuario
        */
        function getRFCEmpleado($correo){
            $dbh = $this -> Connect();
            $sentencia = "SELECT rfc FROM empleado WHERE correo = :correo";
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindParam(':correo', $correo, PDO::PARAM_STR);
            $stmt -> execute();
            $dato = $stmt -> fetchAll();
            return $dato[0]['rfc'];
        }

        /*
        * Método para obtener todos los roles de un usuario
        * Params String @correo recibe el correo del usuario
        * Return Arreglo con los roles del usuario
        */
        function getPuesto($correo){
            $dbh = $this ->Connect();
            $query = "SELECT p.id_puesto, p.puesto FROM empleado e 
                            JOIN puesto p USING(id_puesto) 
                      WHERE correo = :correo";
            $stmt = $dbh ->prepare($query);
            $stmt -> bindParam(":correo", $correo, PDO::PARAM_STR);
            $stmt -> execute();
            $fila = $stmt -> fetchAll(PDO::FETCH_ASSOC);
            $puestos = array();
            foreach($fila as $key => $value):
                array_push($puestos, $value['puesto']);
            endforeach;
            return $puestos;
        }

       /*
        * Metodo para obtener todos los puestos
        * Return arreglo con todos los puestos
        */
        function getPuestos(){
            $dbh = $this ->Connect();
            $query = "SELECT id_puesto, puesto FROM puesto p";
            $stmt = $dbh ->prepare($query);
            $stmt -> execute();
            $fila = $stmt -> fetchAll(PDO::FETCH_ASSOC);
            $puestos = array();
            foreach($fila as $key => $value):
                array_push($puestos, $value['puesto']);
            endforeach;
            return $puestos;
        }

        /*
        * Método para validar un email
        * Params String  @correo recibe el correo
        * Return Boolean validando el correo
        */
        function validateEmail($correo){
            if (filter_var($correo, FILTER_VALIDATE_EMAIL))
                return true;
        }

       /*
        * Método para validar el token de un usuario
        * Params String  @correo recibe el correo del usuario
        *        String  @token recibe el token del usuario
        * Return Boolean validando el token del usuario
        */
        function validateToken($correo, $token){
            $dbh = $this ->Connect();
            if(!is_null($token)){
                $query = "SELECT * FROM empleado WHERE correo = :correo AND token = :token";
                $stmt = $dbh -> prepare($query);
                $stmt -> bindParam(":correo", $correo, PDO::PARAM_STR);
                $stmt -> bindParam(":token", $token, PDO::PARAM_STR);
                $stmt -> execute();
                $fila = $stmt -> fetchAll();
                return isset($fila[0]['correo'])? true : false;
            }
        }

        /*
        * Método para validar al usuario
        * Params String  @correo recibe el correo del usuario
        *        String  @contrasena recibe la contraseña del usuario
        * Return Boolean validando al usuario
        */
        function validateEmpleado($correo, $contrasena){
            $contrasena = MD5($contrasena);
            $dbh = $this -> Connect();
            $query = "SELECT * FROM empleado WHERE correo = :correo AND contrasenia = :contrasena";
            $stmt = $dbh ->prepare($query);
            $stmt -> bindParam(":correo", $correo, PDO::PARAM_STR);
            $stmt -> bindParam(":contrasena", $contrasena, PDO::PARAM_STR);
            $stmt -> execute();
            $fila = $stmt -> fetchAll();
            return isset($fila[0]['correo'])? true : false;
        }

        /*
        * Método para validar un rol
        * Params String  @rol recibe el rol
        * Return Boolean validando el rol
        */
        function validarPuesto($puesto){
            $this -> verificarSesion();
            $puestos = $_SESSION['puesto'];
            if(in_array($puesto, $puestos)){
                return true;
            }
            return false;
        }

        /*
        * Metodo para verificar la existencia de la sesión
        */
        function verificarSesion()
        {
            if(!isset($_SESSION['validado'])){
                $mensaje = 'Es necesario iniciar sesión';
                include('../login/views/header.php');
                include('../login/views/login.php');
                include('../login/views/footer.php');
                die();
            }
        }

        /*
        * Método para verificar un puesto
        * Params String  @puesto recibe el puesto
        */
        function verificarPuesto($puestos){
            $this -> verificarSesion();
            $puesto = $_SESSION['puesto'];
            $c = 0;
            foreach($puestos as $p):
                $c++;
                if(!in_array($p, $puesto) && $c == count($puestos)){
                    $mensaje = 'Usted no tiene el rol adecuado.';
                    print_r($p);
                    include('../login/views/header.php');
                    include('../login/views/login.php');
                    include('../login/views/footer.php');
                    die();
                } else if(in_array($p, $puesto)) {
                    break;
                }
            endforeach;
        }

       /*
        * Método para envia un correo de cambio de password para un usuario
        * Params String  @correo recibe el correo del usuario
        */
        function changePass($correo){
            $rfc = $this -> getRFCEmpleado($correo);
            if(!is_numeric($rfc)){
                //$token = substr(MD5(rand(1, 10)), 1, 10);
                $token = substr(crypt(sha1(hash('sha512', md5(rand(1, 9999)).$rfc)), 'cruzazul campeon'), 1, 10);
                $dbh = $this -> Connect();
                $query = "UPDATE empleado SET token = :token WHERE rfc = :rfc";
                $stmt = $dbh -> prepare($query);
                $stmt -> bindParam(":token", $token, PDO::PARAM_STR);
                $stmt -> bindParam(":rfc", $rfc, PDO::PARAM_STR);
                $stmt -> execute();
                $mensaje = "Se envió un correo electronico a su cuenta";
                require '../vendor/autoload.php';
                $mail = new PHPMailer();
                $mail -> isSMTP();
                $mail -> SMTPDebug = SMTP::DEBUG_OFF;
                $mail -> Host = 'smtp.gmail.com';
                $mail -> Port = 587;
                $mail -> SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail -> SMTPAuth = true;
                $mail -> Username = '18030948@itcelaya.edu.mx';
                $mail -> Password = PASSGMAIL;
                $mail -> setFrom('18030948@itcelaya.edu.mx', 'Dario Sebastian Zarate Ceballos');
                $mail -> addReplyTo('18030948@itcelaya.edu.mx', 'Dario Sebastian Zarate Ceballos');
                $mail -> addAddress($correo, 'Dario Zarate');
                $mail -> Subject = 'Recuperación de contraseña del sistema del Hospital San Juan';
                $cuerpo = "Estimado usuario, por favor presione la siguiente liga para recuperar su contraseña </br><a href='http://localhost/Novaric/login/login.php?action=change_pass&correo=" . $correo . "&token=" . $token . "'>Recuperar Contraseña</a>";
                $mail -> msgHTML($cuerpo);
                $mail -> AltBody = 'Mensaje alternativo';
                $mail -> send();
            }
        }

        function resetPassword($correo, $token, $contrasena){
            $dbh = $this -> Connect();
            if($this -> validateEmail($correo)){
                if($this -> validateToken($correo, $token)){
                    $dbh = $this ->Connect();
                    $contrasena = md5($contrasena);
                    $query = "UPDATE empleado SET contrasenia = :contrasena, token = NULL WHERE correo = :correo";
                    $stmt = $dbh -> prepare($query);
                    $stmt -> bindParam(":contrasena", $contrasena, PDO::PARAM_STR);
                    $stmt -> bindParam(":correo", $correo, PDO::PARAM_STR);
                    $fila = $stmt -> execute();
                    if($fila){ return true; }
                    return false;
                }
            }
            return false;
        }
    }
?>