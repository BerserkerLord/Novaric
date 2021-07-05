<?php
    require_once('controllers/sistema.controller.php');

    /*
     * Clase principal para formas de conexiones
     */
    class FormaConexion extends Sistema
    {
        /*
        * Método para insertar un registro de formas de conexión a la base de datos Novaric
        * Params String @for recibe la forma de la conexión
        * Return integer con la cantidad de registros afectados
        */
        function create($for)
        {
            $dbh = $this -> connect();
            try {
                $sentencia = "INSERT INTO forma_conexion(forma_conexion) VALUES(:forma_conexion)";
                $stmt= $dbh -> prepare($sentencia);
                $stmt -> bindParam(':forma_conexion', $for, PDO::PARAM_STR);
                $stmt -> execute();
                $msg['msg'] = 'Forma de conexión registrada correctamente.';
                $msg['status'] = 'success';
                return $msg;
            } catch (Exception $e) {
                $msg['msg'] = 'Error al registrar, la forma de conexión ya existe.';
                $msg['status'] = 'danger';
                return $msg;
            }
        }

        /*
        * Método para obtener todos las formas de conexiones por cantidad
        * Return Array con todas las faormas de conexiones
        */
        function read()
        {
            $dbh = $this -> Connect();
            $busqueda = (isset($_GET['busqueda']))?$_GET['busqueda']:'';
            $ordenamiento = (isset($_GET['ordenamiento']))?$_GET['ordenamiento']:'f.forma_conexion';
            $limite = (isset($_GET['limite']))?$_GET['limite']:'3';
            $desde = (isset($_GET['desde']))?$_GET['desde']:'0';
            /*switch($_SESSION['engine']){
                case 'mariadb':
                    $sentencia = 'SELECT * FROM forma_conexion f WHERE f.forma_conexion LIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
                    break;
                case 'postgresql':
                    $sentencia = 'SELECT * FROM forma_conexion f WHERE f.forma_conexion ILIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
                    break;
            }*/
            $sentencia = 'SELECT * FROM forma_conexion f WHERE f.forma_conexion LIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindValue(":busqueda", '%' . $busqueda . '%', PDO::PARAM_STR);
            $stmt -> bindValue(":ordenamiento", $ordenamiento, PDO::PARAM_STR);
            $stmt -> bindValue(":limite", $limite, PDO::PARAM_INT);
            $stmt -> bindValue(":desde", $desde, PDO::PARAM_INT);
            $stmt -> execute();
            $filas = $stmt -> fetchAll();
            return $filas;
        }

        /*
        * Método para obtener todos las formas de conexiones
        * Return Array con todas las faormas de conexiones
        */
        function readAll()
        {
            $dbh = $this -> Connect();
            $sentencia = 'SELECT * FROM forma_conexion AS f';
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> execute();
            $filas = $stmt -> fetchAll();
            return $filas;
        }


        /*
         * Metodo para obtener la informacion de una forma de conexion
         * Params Integer @id_f recibe el id de una forma de conexion
         * Return Array con la información de la forma de conexion
         */
        function readOne($id_f)
        {
            $dbh = $this -> connect();
            $sentencia = 'SELECT * FROM forma_conexion WHERE id_forma_conexion = :id_forma_conexion';
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindParam(':id_forma_conexion', $id_f, PDO::PARAM_INT);
            $stmt -> execute();
            $filas = $stmt -> fetchAll();
            return $filas;
        }

        /*
         * Metodo para actualizar el registro de una forma de conexion
         * Params Integer @id_f recibe el id de una forma de conexion
         *        String  @for recibe la forma de conexion
         * Return integer con la cantidad de registros afectados
         */
        function update($id_f, $for)
        {
            $dbh = $this -> connect();
            try {
                $sentencia = 'UPDATE forma_conexion SET forma_conexion = :forma_conexion WHERE id_forma_conexion = :id_forma_conexion';
                $stmt= $dbh -> prepare($sentencia);
                $stmt -> bindParam(':id_forma_conexion', $id_f, PDO::PARAM_INT);
                $stmt -> bindParam(':forma_conexion', $for, PDO::PARAM_STR);
                $stmt -> execute();
                $msg['msg'] = 'Forma de conexión actualizada correctamente.';
                $msg['status'] = 'success';
                return $msg;
            } catch (Exception $e) {
                $msg['msg'] = 'Error al actualizar, la forma de conexión  ya existe.';
                $msg['status'] = 'danger';
                return $msg;
            }
        }

        /*
         * Metodo para elimina el registro de una forma de conexion
         * Params Integer @id_f recibe el id de una forma de conexion
         * Return integer con la cantidad de registros afectados
         */
        function delete($id_f)
        {
            $dbh = $this -> connect();
            try {
                $sentencia = 'DELETE FROM forma_conexion WHERE id_forma_conexion = :id_forma_conexion';
                $stmt= $dbh -> prepare($sentencia);
                $stmt -> bindParam(':id_forma_conexion', $id_f, PDO::PARAM_INT);
                $stmt -> execute();
                $msg['msg'] = 'Forma de conexión eliminada correctamente.';
                $msg['status'] = 'success';
                return $msg;
            } catch (Exception $e) {
                $msg['msg'] = 'Error al eliminar, la forma de conexión esta asociada a uno o mas productos.';
                $msg['status'] = 'danger';
                return $msg;
            }
        }

        /*
       * Método para extrater total de formas de conexiones
       * Return un entero que es la cantidad de formas de conexiones
       */
        function total(){
            $dbh = $this -> Connect();
            $sentencia = "SELECT COUNT(id_forma_conexion) AS total FROM forma_conexion";
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> execute();
            $rows = $stmt -> fetchAll();
            return $rows[0]['total'];
        }
    }
?>