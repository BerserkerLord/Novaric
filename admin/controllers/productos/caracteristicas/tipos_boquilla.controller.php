<?php
    require_once('controllers/sistema.controller.php');
    class TipoBoquilla extends Sistema
    {
        var $id_tipo_boquilla;
        var $tipo_boquilla;

        function getIdTipoBoquilla(){ return $this -> id_tipo_boquilla; }
        function getTipoBoquilla(){ return $this -> tipo_boquilla; }

        function setIdTipoBoquilla($id_t_b){ $this -> id_tipo_boquilla = $id_t_b; }
        function setTipoBoquilla($t_b){ $this -> tipo_boquilla = $t_b; }

        function create($t_b)
        {
            $dbh = $this->connect();
            $sentencia = "INSERT INTO tipo_boquilla(tipo_boquilla) VALUES(:tipo_boquilla)";
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindParam(':tipo_boquilla', $t_b, PDO::PARAM_STR);
            $resultado = $stmt->execute();
            return $resultado;
        }

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

        function readOne($id_t_b)
        {
            $dbh = $this->connect();
            $sentencia ='SELECT * FROM tipo_boquilla WHERE id_tipo_boquilla = :id_tipo_boquilla';
            $stmt = $dbh->prepare($sentencia);
            $stmt->bindParam(':id_tipo_boquilla', $id_t_b, PDO::PARAM_INT);
            $stmt -> execute();
            $filas = $stmt -> fetchAll();
            return $filas;
        }

        function update($id_t_b, $tb)
        {
            $dbh = $this->connect();
            $sentencia = "UPDATE tipo_boquilla SET tipo_boquilla = :tipo_boquilla WHERE id_tipo_boquilla = :id_tipo_boquilla";
            $stmt = $dbh -> prepare($sentencia);
            $stmt->bindParam(':id_tipo_boquilla', $id_t_b, PDO::PARAM_INT);
            $stmt->bindParam(':tipo_boquilla', $tb, PDO::PARAM_STR);
            $resultado = $stmt->execute();
            return $resultado;
        }

        function delete($id_t_b)
        {
            $dbh = $this->connect();
            $sentencia = 'DELETE FROM tipo_boquilla WHERE id_tipo_boquilla = :id_tipo_boquilla';
            $stmt= $dbh->prepare($sentencia);
            $stmt->bindParam(':id_tipo_boquilla', $id_t_b, PDO::PARAM_INT);
            $resultado = $stmt->execute();
            return $resultado;
        }

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