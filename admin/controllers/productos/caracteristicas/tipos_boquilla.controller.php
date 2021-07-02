<?php
    require_once('controllers/sistema.controller.php');

    /*
     * Clase principal para tipos de boquillas
     */
    class TipoBoquilla extends Sistema
    {
        /*
        * Método para insertar un registro de tipo de boquilla a la base de datos Novaric
        * Params String @t_b recibe el tipo de boquilla
        * Return integer con la cantidad de registros afectados
        */
        function create($t_b)
        {
            $dbh = $this -> connect();
            $sentencia = "INSERT INTO tipo_boquilla(tipo_boquilla) VALUES(:tipo_boquilla)";
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindParam(':tipo_boquilla', $t_b, PDO::PARAM_STR);
            $resultado = $stmt -> execute();
            return $resultado;
        }

        /*
        * Método para obtener todos los tipos de boquillas por cantidad
        * Return Array con todos los tipos de boquillas
        */
        function read()
        {
            $dbh = $this -> Connect();
            $busqueda = (isset($_GET['busqueda']))?$_GET['busqueda']:'';
            $ordenamiento = (isset($_GET['ordenamiento']))?$_GET['ordenamiento']:'tb.tipo_boquilla';
            $limite = (isset($_GET['limite']))?$_GET['limite']:'5';
            $desde = (isset($_GET['desde']))?$_GET['desde']:'0';
            $sentencia = 'SELECT * FROM tipo_boquilla tb WHERE tb.tipo_boquilla LIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
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
        * Método para obtener todos los tipos de boquillas
        * Return Array con todos los tipos de boquillas
        */
        function readAll()
        {
            $dbh = $this -> Connect();
            $sentencia = 'SELECT * FROM tipo_boquilla AS tb';
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> execute();
            $filas = $stmt -> fetchAll();
            return $filas;
        }

        /*
         * Metodo para obtener la informacion de un tipo de boquilla
         * Params Integer @id_t_b recibe el id de un tipo de boquilla
         * Return Array con la información dei tipo de boquilla
         */
        function readOne($id_t_b)
        {
            $dbh = $this -> connect();
            $sentencia = 'SELECT * FROM tipo_boquilla WHERE id_tipo_boquilla = :id_tipo_boquilla';
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindParam(':id_tipo_boquilla', $id_t_b, PDO::PARAM_INT);
            $stmt -> execute();
            $filas = $stmt -> fetchAll();
            return $filas;
        }

        /*
         * Metodo para actualizar el registro de un tipo de boquilla
         * Params Integer @id_t_b recibe el id de un tipo de boquilla
         *        String  @tb recibe el tipo de boquilla
         * Return integer con la cantidad de registros afectados
         */
        function update($id_t_b, $tb)
        {
            $dbh = $this -> connect();
            $sentencia = "UPDATE tipo_boquilla SET tipo_boquilla = :tipo_boquilla WHERE id_tipo_boquilla = :id_tipo_boquilla";
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindParam(':id_tipo_boquilla', $id_t_b, PDO::PARAM_INT);
            $stmt -> bindParam(':tipo_boquilla', $tb, PDO::PARAM_STR);
            $resultado = $stmt -> execute();
            return $resultado;
        }

        /*
         * Metodo para elimina el registro de un tipo de boquilla
         * Params Integer @id_t_b recibe el id de un tipo de boquilla
         * Return integer con la cantidad de registros afectados
         */
        function delete($id_t_b)
        {
            $dbh = $this -> connect();
            $sentencia = 'DELETE FROM tipo_boquilla WHERE id_tipo_boquilla = :id_tipo_boquilla';
            $stmt= $dbh -> prepare($sentencia);
            $stmt -> bindParam(':id_tipo_boquilla', $id_t_b, PDO::PARAM_INT);
            $resultado = $stmt -> execute();
            return $resultado;
        }

        /*
        * Método para extrater total de tipos de boquillas
        * Return un entero que es la cantidad de tipos de boquillas
        */
        function total(){
            $dbh = $this -> Connect();
            $sentencia = "SELECT COUNT(id_tipo_boquilla) AS total FROM tipo_boquilla";
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> execute();
            $rows = $stmt -> fetchAll();
            return $rows[0]['total'];
        }
    }
?>