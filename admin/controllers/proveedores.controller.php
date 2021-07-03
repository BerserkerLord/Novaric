<?php
    require_once('sistema.controller.php');

    /*
     * Clase principal para proveedores
     */
    class Proveedor extends Sistema{

       /*
        * Método para insertar un registro de proveedores a la base de datos Novaric
        * Params String @rfc recibe el rfc de un proveedor
        *        String @razon_social recibe la razón social de un proveedor
        *        String @domicilio recibe el domicilio de un proveedor
        *        String @telefono recibe el telefono de un provedor
        * Return Arreglo con informacion de exito al momento de hacer la operación
        */
        function create($rfc, $razon_social, $domicilio, $telefono){
            $dbh = $this -> Connect();
            try {
                $sentencia = "INSERT INTO proveedor(rfc, razon_social, domicilio, telefono)
                                            VALUES(:rfc, :razon_social, :domicilio, :telefono)";
                $stmt = $dbh -> prepare($sentencia);
                $stmt -> bindParam(":rfc", $rfc, PDO::PARAM_STR);
                $stmt -> bindParam(":razon_social", $razon_social, PDO::PARAM_STR);
                $stmt -> bindParam(":domicilio", $domicilio, PDO::PARAM_STR);
                $stmt -> bindParam(":telefono", $telefono, PDO::PARAM_STR);
                $stmt -> execute();
                $msg['msg'] = 'Proveedor registrado correctamente.';
                $msg['status'] = 'success';
                return $msg;
            } catch (Exception $e) {
                $msg['msg'] = 'Error al registrar, el RFC ya existe.';
                $msg['status'] = 'danger';
                return $msg;
            }
        }

        /*
         * Metodo para actualizar el registro de un proveedor
         * Params String @rfc recibe el rfc de un proveedor
         *        String @razon_social recibe la razón social de un proveedor
         *        String @domicilio recibe el domicilio de un proveedor
         *        String @telefono recibe el telefono de un provedor
         * Return integer con la cantidad de registros afectados
         */
        function update($rfc, $razon_social, $domicilio, $telefono){
            $dbh = $this -> Connect();
            try {
                $sentencia = "UPDATE proveedor SET razon_social = :razon_social, domicilio = :domicilio, telefono = :telefono
                                  WHERE rfc = :rfc";
                $stmt = $dbh -> prepare($sentencia);
                $stmt -> bindParam(":razon_social", $razon_social, PDO::PARAM_STR);
                $stmt -> bindParam(":domicilio", $domicilio, PDO::PARAM_STR);
                $stmt -> bindParam(":telefono", $telefono, PDO::PARAM_STR);
                $stmt -> bindParam(":rfc", $rfc, PDO::PARAM_STR);
                $stmt -> execute();
                $msg['msg'] = 'Proveedor actualizado correctamente.';
                $msg['status'] = 'success';
                return $msg;
            } catch (Exception $e) {
                $msg['msg'] = 'Error al actualizar, el RFC ya existe.';
                $msg['status'] = 'danger';
                return $msg;
            }
        }

        /*
         * Metodo para elimina el registro de un proveedor
         * Params Integer @rfc recibe el rfc de un proveedor
         * Return integer con la cantidad de registros afectados
         */
        function delete($rfc){
            $dbh = $this -> Connect();
            try {
                $stmt = $dbh -> prepare('DELETE FROM proveedor WHERE rfc = :rfc');
                $stmt -> bindParam(":rfc", $rfc, PDO::PARAM_STR);
                $stmt -> execute();
                $msg['msg'] = 'Proveedor eliminado correctamente.';
                $msg['status'] = 'success';
                return $msg;
            } catch (Exception $e) {
                $msg['msg'] = 'Error desconocido al eliminar, favor de contactar con el desarrollador.';
                $msg['status'] = 'danger';
                return $msg;
            }
        }

        /*
        * Método para obtener todos los proveedores
        * Return Array con todos los proveedores
        */
        function read(){
            $dbh = $this -> Connect();
            $busqueda = (isset($_GET['busqueda']))?$_GET['busqueda']:'';
            $ordenamiento = (isset($_GET['ordenamiento']))?$_GET['ordenamiento']:'p.rfc';
            $limite = (isset($_GET['limite']))?$_GET['limite']:'3';
            $desde = (isset($_GET['desde']))?$_GET['desde']:'0';
            /*switch($_SESSION['engine']){
                case 'mariadb':
                    $sentencia = 'SELECT * FROM proveedor p WHERE p.rfc LIKE :busqueda ORDER BY :ordenamiento ASC LIMIT :limite OFFSET :desde';
                    break;
                case 'postgresql':
                    $sentencia = 'SELECT * FROM proveedor p WHERE p.rfc ILIKE :busqueda ORDER BY :ordenamiento ASC LIMIT :limite OFFSET :desde'';
                    break;
            }*/
            $sentencia = 'SELECT * FROM proveedor p WHERE p.rfc LIKE :busqueda ORDER BY :ordenamiento ASC LIMIT :limite OFFSET :desde';
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindValue(":busqueda", '%' . $busqueda . '%', PDO::PARAM_STR);
            $stmt -> bindValue(":ordenamiento", $ordenamiento, PDO::PARAM_STR);
            $stmt -> bindValue(":limite", $limite, PDO::PARAM_INT);
            $stmt -> bindValue(":desde", $desde, PDO::PARAM_INT);
            $stmt -> execute();
            $rows = $stmt -> fetchAll();
            return $rows;
        }

        /*
         * Metodo para obtener la informacion de un proveedor
         * Params Integer @rfc recibe el rfc de un proveedor
         * Return Array con la información de un proveedor
         */
        function readOne($rfc)
        {
            $dbh = $this -> connect();
            $sentencia = 'SELECT * FROM proveedor WHERE rfc = :rfc';
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindParam(':rfc', $rfc, PDO::PARAM_STR);
            $stmt -> execute();
            $filas = $stmt -> fetchAll();
            return $filas;
        }

        /*
        * Método para extrater total de proveedores
        * Return un entero que es la cantidad de proveedores
        */
        function total(){
            $dbh = $this -> Connect();
            $sentencia = "SELECT COUNT(rfc) AS total FROM proveedor";
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> execute();
            $rows = $stmt -> fetchAll();
            return $rows[0]['total'];
        }
    }
?>