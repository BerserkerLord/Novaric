<?php
    require_once('sistema.controller.php');

    /*
    * Clase principal para clientes de servicios
    */
    class Cliente extends Sistema{

       /*
        * Método para insertar un registro de clientes de servicios a la base de datos Novaric
        * Params String @rfc recibe el rfc de el cliente
        *        String @nombre recibe el nombre del cliente
        *        String @apaterno recibe el apellido paterno del cliente
        *        String @amaterno recibe el apellido materno del cliente
        *        String @email recibe el correo del empleado
        *        String @telefono recibe el telefono del cliente
        *        String @domicilio recibe el domicilio del cliente
        * Return Arreglo con informacion de exito al momento de hacer la operación
        */
        function create($rfc, $nombre, $apaterno, $amaterno, $email, $telefono, $domicilio){
            $dbh = $this -> Connect();
            try{
                $sentencia = "INSERT INTO cliente(rfc, nombre, apaterno, amaterno, email, telefono, domicilio)
                                                VALUES(:rfc, :nombre, :apaterno, :amaterno, :email, :telefono, :domicilio)";
                $stmt = $dbh -> prepare($sentencia);
                $stmt -> bindParam(":rfc", $rfc, PDO::PARAM_STR);
                $stmt -> bindParam(":nombre", $nombre, PDO::PARAM_STR);
                $stmt -> bindParam(":apaterno", $apaterno, PDO::PARAM_STR);
                $stmt -> bindParam(":amaterno", $amaterno, PDO::PARAM_STR);
                $stmt -> bindParam(":email", $email, PDO::PARAM_STR);
                $stmt -> bindParam(":telefono", $telefono, PDO::PARAM_STR);
                $stmt -> bindParam(":domicilio", $domicilio, PDO::PARAM_STR);
                $stmt -> execute();
                $msg['msg'] = 'Cliente registrado correctamente.';
                $msg['status'] = 'success';
                return $msg;
            } catch (Exception $e) {
                $msg['msg'] = 'Error al registrar, el RFC y/o el correo ya existen.';
                $msg['status'] = 'danger';
                return $msg;
            }
        }

       /*
        * Método para actualizar un registro de clientes de servicios a la base de datos Novaric
        * Params String @rfc recibe el rfc de el cliente
        *        String @nombre recibe el nombre del cliente
        *        String @apaterno recibe el apellido paterno del cliente
        *        String @amaterno recibe el apellido materno del cliente
        *        String @email recibe el correo del empleado
        *        String @telefono recibe el telefono del cliente
        *        String @domicilio recibe el domicilio del cliente
        * Return Arreglo con informacion de exito al momento de hacer la operación
        */
        function update($rfc, $nombre, $apaterno, $amaterno, $email, $telefono, $domicilio){
            $dbh = $this -> Connect();
            try {
                $sentencia = "UPDATE cliente SET nombre = :nombre, apaterno = :apaterno, amaterno = :amaterno, email = :email, telefono = :telefono,
                                      domicilio = :domicilio WHERE rfc = :rfc";
                $stmt = $dbh -> prepare($sentencia);
                $stmt -> bindParam(":nombre", $nombre, PDO::PARAM_STR);
                $stmt -> bindParam(":apaterno", $apaterno, PDO::PARAM_STR);
                $stmt -> bindParam(":amaterno", $amaterno, PDO::PARAM_STR);
                $stmt -> bindParam(":email", $email, PDO::PARAM_STR);
                $stmt -> bindParam(":telefono", $telefono, PDO::PARAM_STR);
                $stmt -> bindParam(":domicilio", $domicilio, PDO::PARAM_STR);
                $stmt -> bindParam(":rfc", $rfc, PDO::PARAM_STR);
                $stmt -> execute();
                $msg['msg'] = 'Cliente actualizado correctamente.';
                $msg['status'] = 'success';
                return $msg;
            } catch (Exception $e) {
                $msg['msg'] = 'Error al actualizar, el correo ya existe.';
                $msg['status'] = 'danger';
                return $msg;
            }
        }

        /*
         * Metodo para eliminar el registro de un cliente
         * Params String @rfc recibe el rfc de un cliente
         * Return Arreglo con informacion de exito al momento de hacer la operación
         */
        function delete($rfc){
            $dbh = $this -> Connect();
            try {
                $stmt = $dbh -> prepare('DELETE FROM cliente WHERE rfc = :rfc');
                $stmt -> bindParam(":rfc", $rfc, PDO::PARAM_STR);
                $stmt -> execute();
                $msg['msg'] = 'Cliente eliminado correctamente.';
                $msg['status'] = 'success';
                return $msg;
            } catch (Exception $e) {
                $msg['msg'] = 'Error al eliminar, el cliente tiene facturas asociadas.';
                $msg['status'] = 'danger';
                return $msg;
            }
        }

        /*
        * Método para obtener todos los clientes por cantidades
        * Return Array con todas los clientes
        */
        function read(){
            $dbh = $this -> Connect();
            $busqueda = (isset($_GET['busqueda']))?$_GET['busqueda']:'';
            $ordenamiento = (isset($_GET['ordenamiento']))?$_GET['ordenamiento']:'cs.rfc';
            $limite = (isset($_GET['limite']))?$_GET['limite']:'5';
            $desde = (isset($_GET['desde']))?$_GET['desde']:'0';
            /*switch($_SESSION['engine']){
                case 'mariadb':
                    $sentencia = 'SELECT * FROM cliente cs WHERE cs.rfc LIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
                    break;
                case 'postgresql':
                    $sentencia = 'SELECT * FROM cliente cs WHERE cs.rfc ILIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
                    break;
            }*/
            $sentencia = 'SELECT * FROM cliente cs WHERE cs.rfc LIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindValue(":busqueda", '%' . $busqueda . '%', PDO::PARAM_STR);
            $stmt -> bindValue(":ordenamiento", $ordenamiento, PDO::PARAM_STR);
            $stmt -> bindValue(":limite", $limite, PDO::PARAM_INT);
            $stmt -> bindValue(":desde", $desde, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt -> fetchAll();
            return $rows;
        }

        /*
         * Metodo para obtener la informacion de un cliente
         * Params String @rfc recibe el rfc de in cliente
         * Return Array con la información del cliente
         */
        function readOne($rfc)
        {
            $dbh = $this->connect();
            $sentencia='SELECT * FROM cliente WHERE rfc = :rfc';
            $stmt = $dbh->prepare($sentencia);
            $stmt->bindParam(':rfc', $rfc, PDO::PARAM_STR);
            $stmt->execute();
            $filas=$stmt->fetchAll();
            return $filas;
        }

        function readAll(){
            $dbh = $this -> Connect();
            $sentencia = 'SELECT * FROM cliente cs';
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> execute();
            $rows = $stmt -> fetchAll();
            return $rows;
        }

      /*
       * Método para extraer total de clientes
       * Return un entero que es la cantidad de clientes
       */
        function total(){
            $dbh = $this -> Connect();
            $sentencia = "SELECT COUNT(rfc) AS total FROM cliente";
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> execute();
            $rows = $stmt -> fetchAll();
            return $rows[0]['total'];
        }
    }
?>