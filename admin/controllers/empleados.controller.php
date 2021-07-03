<?php
    include("sistema.controller.php");
   /*
    * Clase principal para empleados
    */
    class Empleado extends Sistema{

        function create($errefece, $nom, $apa, $ama, $dir, $usu, $corr, $con, $id_pu)
        {

           /*
            * Método para insertar un registro de empleados a la base de datos Novaric
            * Params String @errefece recibe el rfc de el empleado
            *        String @nom recibe el nombre del empleado
            *        String @apa recibe el apellido paterno del empleado
            *        String @ama recibe el apellido materno del empleado
            *        String @dir recibe la dirección del empleado
            *        String @usu recibe el nombre de usuario del empleado
            *        String @corr recibe el correo del empleado
            *        String @con recibe la contraseña del empleado
            *        String @id_pu recibe el id del puesto del empleado
            * Return Arreglo con informacion de exito al momento de hacer la operación
            */
            $dbh = $this->connect();
            $foto = $this -> guardarFotografia();
            try {
                $sentencia = "INSERT INTO empleado(rfc, nombre, apaterno, amaterno, direccion, usuario, correo, contrasenia, fotografia, id_puesto) 
                          VALUES(:rfc, :nombre, :apaterno, :amaterno, :direccion, :usuario, :correo, MD5(:contrasenia), :fotografia, :id_puesto)";
                $stmt= $dbh->prepare($sentencia);
                $stmt->bindParam(':rfc', $errefece, PDO::PARAM_STR);
                $stmt->bindParam(':nombre', $nom, PDO::PARAM_STR);
                $stmt->bindParam(':apaterno', $apa, PDO::PARAM_STR);
                $stmt->bindParam(':amaterno', $ama, PDO::PARAM_STR);
                $stmt->bindParam(':direccion', $dir, PDO::PARAM_STR);
                $stmt->bindParam(':usuario', $usu, PDO::PARAM_STR);
                $stmt->bindParam(':correo', $corr, PDO::PARAM_STR);
                $stmt->bindParam(':contrasenia', $con, PDO::PARAM_STR);
                $stmt->bindParam(':fotografia', $foto, PDO::PARAM_STR);
                $stmt->bindParam(':id_puesto', $id_pu, PDO::PARAM_INT);;
                $stmt->execute();
                $msg['msg'] = 'Empleado registrado correctamente.';
                $msg['status'] = 'success';
                return $msg;
            } catch (Exception $e) {
                $msg['msg'] = 'Error al registrar, el RFC y/o el correo ya existen.';
                $msg['status'] = 'danger';
                return $msg;
            }
        }

        /*
        * Método para obtener todos los empleados por cantidades
        * Return Array con todas los empleados
        */
        function read()
        {
            $busqueda = (isset($_GET['busqueda']))?$_GET['busqueda']:'';
            $ordenamiento = (isset($_GET['ordenamiento']))?$_GET['ordenamiento']:'e.nombre';
            $limite = (isset($_GET['limite']))?$_GET['limite']:'5';
            $desde = (isset($_GET['desde']))?$_GET['desde']:'0';
            $dbh = $this->connect();

            /*switch($_SESSION['engine']){
                case 'mariadb':
                    $sentencia = 'SELECT * FROM empleado e
                                    INNER JOIN puesto USING(id_puesto)
                                  WHERE e.rfc LIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
                    break;
                case 'postgresql':
                    $sentencia = 'SELECT * FROM empleado e
                                    INNER JOIN puesto USING(id_puesto)
                                  WHERE e.rfc ILIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
                    break;
            }*/

            $sentencia = 'SELECT * FROM empleado e
                              INNER JOIN puesto USING(id_puesto)
                          WHERE e.rfc LIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindValue(":busqueda", '%' . $busqueda . '%', PDO::PARAM_STR);
            $stmt -> bindValue(":ordenamiento", $ordenamiento, PDO::PARAM_STR);
            $stmt -> bindValue(":limite", $limite, PDO::PARAM_INT);
            $stmt -> bindValue(":desde", $desde, PDO::PARAM_INT);
            $stmt->execute();
            $filas=$stmt->fetchAll();
            return $filas;
        }

        /*
         * Metodo para obtener la informacion de una marca
         * Params Integer @errefece recibe el efc de un empleado
         * Return Array con la información del empleado
         */
        function readOne($errefece)
        {
            $dbh = $this->connect();
            $sentencia = 'SELECT * FROM empleado INNER JOIN puesto USING(id_puesto) WHERE rfc = :rfc';
            $stmt = $dbh->prepare($sentencia);
            $stmt->bindParam(':rfc', $errefece, PDO::PARAM_STR);
            $stmt->execute();
            $filas = $stmt->fetchAll();
            return $filas;
        }
        /*
         * Método para actualizar un registro de empleados a la base de datos Novaric
         * Params String @errefece recibe el rfc de el empleado
         *        String @nom recibe el nombre del empleado
         *        String @apa recibe el apellido paterno del empleado
         *        String @ama recibe el apellido materno del empleado
         *        String @dir recibe la dirección del empleado
         *        String @usu recibe el nombre de usuario del empleado
         *        String @corr recibe el correo del empleado
         *        String @id_pu recibe el id del puesto del empleado
         * Return Arreglo con informacion de exito al momento de hacer la operación
         */
        function update($errefece, $nom, $apa, $ama, $dir, $usu, $corr, $con, $id_pu)
        {
            $dbh = $this->connect();
            $foto = $this -> guardarFotografia();
            try {
                if($foto){
                    $sentencia = 'UPDATE empleado SET nombre = :nombre, apaterno = :apaterno, amaterno = :amaterno,
                          direccion = :direccion, usuario = :usuario, correo = :correo, contrasenia = :contrasenia,
                          fotografia = :fotografia, id_puesto = :id_puesto WHERE rfc = :rfc';
                    $stmt = $dbh -> prepare($sentencia);
                    $stmt -> bindParam(":fotografia", $foto, PDO::PARAM_STR);
                }
                else{
                    $sentencia = 'UPDATE empleado SET nombre = :nombre, apaterno = :apaterno, amaterno = :amaterno,
                          direccion = :direccion, usuario = :usuario, correo = :correo, contrasenia = :contrasenia,
                          id_puesto = :id_puesto WHERE rfc = :rfc';
                    $stmt = $dbh -> prepare($sentencia);
                }
                $stmt->bindParam(':nombre', $nom, PDO::PARAM_STR);
                $stmt->bindParam(':apaterno', $apa, PDO::PARAM_STR);
                $stmt->bindParam(':amaterno', $ama, PDO::PARAM_STR);
                $stmt->bindParam(':direccion', $dir, PDO::PARAM_STR);
                $stmt->bindParam(':usuario', $usu, PDO::PARAM_STR);
                $stmt->bindParam(':correo', $corr, PDO::PARAM_STR);
                $stmt->bindParam(':contrasenia', $con, PDO::PARAM_STR);
                $stmt->bindParam(':id_puesto', $id_pu, PDO::PARAM_INT);;
                $stmt->bindParam(':rfc', $errefece, PDO::PARAM_STR);
                $stmt->execute();
                $msg['msg'] = 'Empleado actualizado correctamente.';
                $msg['status'] = 'success';
                return $msg;
            } catch (Exception $e) {
                $msg['msg'] = 'Error al actualizar, el correo ya existe.';
                $msg['status'] = 'danger';
                return $msg;
            }
        }

        /*
         * Metodo para elimina el registro de un empleado
         * Params Integer @errefece recibe el rfc de un empleado
         * Return Arreglo con informacion de exito al momento de hacer la operación
         */
        function delete($errefece)
        {
            $dbh = $this->connect();
            try {
                $sentencia = 'DELETE FROM empleado WHERE rfc = :rfc';
                $stmt= $dbh->prepare($sentencia);
                $stmt->bindParam(':rfc', $errefece, PDO::PARAM_STR);
                $stmt->execute();
                $msg['msg'] = 'Empleado eliminado correctamente.';
                $msg['status'] = 'success';
                return $msg;
            } catch (Exception $e) {
                $msg['msg'] = 'Error desconocido al eliminar, favor de contactarse con el desarrollador.';
                $msg['status'] = 'danger';
                return $msg;
            }
        }

      /*
       * Método para subir una imagen de un empleado
       * Return Booleano señalando si la imagen es valida de acuerdo al formato o no
       */
        function guardarFotografia()
        {
            $archivo = $_FILES['fotografia'];
            $tipos = array('image/jpeg', 'image/png', 'image/gif');
            if ($archivo['error'] == 0) {
                if ($archivo['size'] <= 2097152) {
                    $a = explode('/', $archivo['type']);
                    $nueva_imagen = MD5(time()) . '.' . $a[1];
                    if (move_uploaded_file($archivo['tmp_name'], '../archivos/' . $nueva_imagen)) {
                        return $nueva_imagen;
                    }
                }
            }
        }

        /*
        * Método para extraer total de empleados
        * Return un entero que es la cantidad de empleados
        */
        function total(){
            $dbh = $this -> Connect();
            $sentencia = "SELECT COUNT(rfc) AS total FROM empleado";
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> execute();
            $rows = $stmt -> fetchAll();
            return $rows[0]['total'];
        }
    }
?>