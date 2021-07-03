<?php
    require_once('controllers/sistema.controller.php');

    /*
     * Clase principal para formas de aspersión
     */
    class FormaAspersion extends Sistema
    {
        /*
        * Método para insertar un registro de forma de aspersion a la base de datos Novaric
        * Params String @f_a recibe la forma de aspersion
        * Return integer con la cantidad de registros afectados
        */
        function create($f_a)
        {
            $dbh = $this -> connect();
            try {
                $sentencia = "INSERT INTO forma_aspersion(forma_aspersion) VALUES(:forma_aspersion)";
                $stmt = $dbh -> prepare($sentencia);
                $stmt -> bindParam(':forma_aspersion', $f_a, PDO::PARAM_STR);
                $stmt -> execute();
                $msg['msg'] = 'Forma de aspersión registrada correctamente.';
                $msg['status'] = 'success';
                return $msg;
            } catch (Exception $e) {
                $msg['msg'] = 'Error al registrar, la forma de aspersión ya existe.';
                $msg['status'] = 'danger';
                return $msg;
            }
        }

        /*
        * Método para obtener todos las formas de aspersion por cantidad
        * Return Array con todas las formas de aspersion
        */
        function read()
        {
            $dbh = $this -> Connect();
            $busqueda = (isset($_GET['busqueda']))?$_GET['busqueda']:'';
            $ordenamiento = (isset($_GET['ordenamiento']))?$_GET['ordenamiento']:'fa.forma_aspersion';
            $limite = (isset($_GET['limite']))?$_GET['limite']:'5';
            $desde = (isset($_GET['desde']))?$_GET['desde']:'0';
            /*switch($_SESSION['engine']){
                case 'mariadb':
                    $sentencia = 'SELECT * FROM forma_aspersion fa WHERE fa.forma_aspersion LIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
                    break;
                case 'postgresql':
                    $sentencia = 'SELECT * FROM forma_aspersion fa WHERE fa.forma_aspersion ILIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
                    break;
            }*/

            $sentencia = 'SELECT * FROM forma_aspersion fa WHERE fa.forma_aspersion LIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
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
        * Método para obtener todos las formas de aspersion
        * Return Array con todas las formas de aspersion
        */
        function readAll()
        {
            $dbh = $this -> Connect();
            $sentencia = 'SELECT * FROM forma_aspersion fa WHERE fa.forma_aspersion LIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> execute();
            $filas = $stmt -> fetchAll();
            return $filas;
        }

        /*
         * Metodo para obtener la informacion de una forma de aspersion
         * Params Integer @id_f_a recibe el id de una forma de aspersion
         * Return Array con la información de la forma de aspersion
         */
        function readOne($id_f_a)
        {
            $dbh = $this->connect();
            $sentencia ='SELECT * FROM forma_aspersion WHERE id_forma_aspersion = :id_forma_aspersion';
            $stmt = $dbh->prepare($sentencia);
            $stmt->bindParam(':id_forma_aspersion', $id_f_a, PDO::PARAM_INT);
            $stmt -> execute();
            $filas = $stmt -> fetchAll();
            return $filas;
        }

        /*
         * Metodo para actualizar el registro de una forma de aspersion
         * Params Integer @id_f_a recibe el id de una forma de aspersion
         *        String  @tb recibe la forma de aspersion
         * Return integer con la cantidad de registros afectados
         */
        function update($id_f_a, $tb)
        {
            $dbh = $this -> connect();
            try {
                $sentencia = "UPDATE forma_aspersion SET forma_aspersion = :forma_aspersion WHERE id_forma_aspersion = :id_forma_aspersion";
                $stmt = $dbh -> prepare($sentencia);
                $stmt -> bindParam(':id_forma_aspersion', $id_f_a, PDO::PARAM_INT);
                $stmt -> bindParam(':forma_aspersion', $tb, PDO::PARAM_STR);
                $stmt -> execute();
                $msg['msg'] = 'Forma de aspersión actualizada correctamente.';
                $msg['status'] = 'success';
                return $msg;
            } catch (Exception $e) {
                $msg['msg'] = 'Error al actualizar, la forma de aspersión ya existe.';
                $msg['status'] = 'danger';
                return $msg;
            }
        }

        /*
         * Metodo para elimina el registro de una forma de aspersion
         * Params Integer @id_f_a recibe el id de una forma de aspersion
         * Return integer con la cantidad de registros afectados
         */
        function delete($id_f_a)
        {
            $dbh = $this -> connect();
            try {
                $sentencia = 'DELETE FROM forma_aspersion WHERE id_forma_aspersion = :id_forma_aspersion';
                $stmt= $dbh -> prepare($sentencia);
                $stmt -> bindParam(':id_forma_aspersion', $id_f_a, PDO::PARAM_INT);
                $stmt -> execute();
                $msg['msg'] = 'Forma de aspersión eliminada correctamente.';
                $msg['status'] = 'success';
                return $msg;
            } catch (Exception $e) {
                $msg['msg'] = 'Error al eliminar, la forma de aspersión esta asociada a uno o mas productos.';
                $msg['status'] = 'danger';
                return $msg;
            }
        }

        /*
        * Método para extrater total de formas de aspersion
        * Return un entero que es la cantidad de formas de aspersion
        */
        function total(){
            $dbh = $this -> Connect();
            $sentencia = "SELECT COUNT(id_forma_aspersion) AS total FROM forma_aspersion";
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> execute();
            $rows = $stmt -> fetchAll();
            return $rows[0]['total'];
        }
    }
?>