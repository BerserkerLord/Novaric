<?php
    require_once('controllers/sistema.controller.php');

   /*
    * Clase principal para extremidades
    */
    class Extremidad extends Sistema
    {
        /*
        * Método para insertar un registro de una extremidad a la base de datos Novaric
        * Params String @ext recibe la extremidad
        * Return integer con la cantidad de registros afectados
        */
        function create($ext)
        {
            $dbh = $this -> connect();
            try {
                $sentencia = "INSERT INTO extremidad(extremidad) VALUES(:extremidad)";
                $stmt= $dbh->prepare($sentencia);
                $stmt -> bindParam(':extremidad', $ext, PDO::PARAM_STR);
                $stmt -> execute();
                $msg['msg'] = 'Extremidad registrada correctamente.';
                $msg['status'] = 'success';
                return $msg;
            } catch (Exception $e) {
                $msg['msg'] = 'Error al registrar, la extremidad ya existe.';
                $msg['status'] = 'danger';
                return $msg;
            }
        }

        /*
        * Método para obtener todos las extremidades por cantidades
        * Return Array con todas las extremidades
        */
        function read()
        {
            $dbh = $this -> Connect();
            $busqueda = (isset($_GET['busqueda']))?$_GET['busqueda']:'';
            $ordenamiento = (isset($_GET['ordenamiento']))?$_GET['ordenamiento']:'e.extremidad';
            $limite = (isset($_GET['limite']))?$_GET['limite']:'3';
            $desde = (isset($_GET['desde']))?$_GET['desde']:'0';
            /*switch($_SESSION['engine']){
                case 'mariadb':
                    $sentencia = 'SELECT * FROM extremidad e WHERE e.extremidad LIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
                    break;
                case 'postgresql':
                    $sentencia = 'SELECT * FROM extremidad e WHERE e.extremidad ILIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
                    break;
            }*/
            $sentencia = 'SELECT * FROM extremidad e WHERE e.extremidad LIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
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
        * Método para obtener todos las extremidades
        * Return Array con todas las extremidades
        */
        function readAll()
        {
            $dbh = $this -> Connect();
            $sentencia = 'SELECT * FROM extremidad e';
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> execute();
            $filas = $stmt -> fetchAll();
            return $filas;
        }

        /*
         * Metodo para obtener la informacion de una extremidad
         * Params Integer @id_ext recibe el id de una extremidad
         * Return Array con la información de la extremidad
         */
        function readOne($id_ext)
        {
            $dbh = $this -> connect();
            $sentencia = 'SELECT * FROM extremidad WHERE id_extremidad = :id_extremidad';
            $stmt = $dbh->prepare($sentencia);
            $stmt -> bindParam(':id_extremidad', $id_ext, PDO::PARAM_INT);
            $stmt -> execute();
            $filas = $stmt -> fetchAll();
            return $filas;
        }

        /*
         * Metodo para actualizar el registro de una extremidad
         * Params Integer @id_ext recibe el id de una extremidad
         *        String  @ext recibe la extremidad
         * Return integer con la cantidad de registros afectados
         */
        function update($id_ext, $ext)
        {
            $dbh = $this->connect();
            try {
                $sentencia = 'UPDATE extremidad SET extremidad = :extremidad WHERE id_extremidad = :id_extremidad';
                $stmt= $dbh->prepare($sentencia);
                $stmt->bindParam(':id_extremidad', $id_ext, PDO::PARAM_INT);
                $stmt->bindParam(':extremidad', $ext, PDO::PARAM_STR);
                $stmt -> execute();
                $msg['msg'] = 'Extremidad actualizada correctamente.';
                $msg['status'] = 'success';
                return $msg;
            } catch (Exception $e) {
                $msg['msg'] = 'Error al actualizar, la extremidad ya existe.';
                $msg['status'] = 'danger';
                return $msg;
            }
        }

        /*
         * Metodo para elimina el registro de una extremidad
         * Params Integer @id_ext recibe el id de una extremidad
         * Return integer con la cantidad de registros afectados
         */
        function delete($id_ext)
        {
            $dbh = $this->connect();
            try {
                $sentencia = 'DELETE FROM extremidad WHERE id_extremidad = :id_extremidad';
                $stmt= $dbh->prepare($sentencia);
                $stmt -> bindParam(':id_extremidad', $id_ext, PDO::PARAM_INT);
                $stmt -> execute();
                $msg['msg'] = 'Extremidad eliminada correctamente.';
                $msg['status'] = 'success';
                return $msg;
            } catch (Exception $e) {
                $msg['msg'] = 'Error al eliminar, la extremidad esta asociada a uno o mas productos.';
                $msg['status'] = 'danger';
                return $msg;
            }

        }

        /*
        * Método para extrater total de extremidades
        * Return un entero que es la cantidad de extremidades
        */
        function total(){
            $dbh = $this -> Connect();
            $sentencia = "SELECT COUNT(id_extremidad) AS total FROM extremidad";
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> execute();
            $rows = $stmt -> fetchAll();
            return $rows[0]['total'];
        }
    }
?>