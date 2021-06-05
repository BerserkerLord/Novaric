<?php
    require_once('controllers/sistema.controller.php');
    class Unidad extends Sistema
    {
        var $id_unidad;
        var $unidad;

        function getIdUnidad(){ return $this -> id_unidad; }
        function getUnidad(){ return $this -> unidad; }

        function setIdUnidad($id_un){ $this -> id_unidad = $id_un; }
        function setUnidad($un){ $this -> unidad = $un; }

        function create($un)
        {
            $dbh = $this->connect();
            $sentencia = "INSERT INTO unidad(unidad) VALUES(:unidad)";
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindParam(':unidad', $un, PDO::PARAM_STR);
            $resultado = $stmt -> execute();
            return $resultado;
        }

        function read()
        {
            $dbh = $this -> Connect();
            $busqueda = (isset($_GET['busqueda']))?$_GET['busqueda']:'';
            $ordenamiento = (isset($_GET['ordenamiento']))?$_GET['ordenamiento']:'u.unidad';
            $limite = (isset($_GET['limite']))?$_GET['limite']:'5';
            $desde = (isset($_GET['desde']))?$_GET['desde']:'0';
            $sentencia = 'SELECT * FROM unidad u WHERE u.unidad LIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindValue(":busqueda", '%' . $busqueda . '%', PDO::PARAM_STR);
            $stmt -> bindValue(":ordenamiento", $ordenamiento, PDO::PARAM_STR);
            $stmt -> bindValue(":limite", $limite, PDO::PARAM_INT);
            $stmt -> bindValue(":desde", $desde, PDO::PARAM_INT);
            $stmt->execute();
            $filas = $stmt->fetchAll();
            return $filas;
        }
        function readOne($id_un)
        {
            $dbh = $this -> connect();
            $sentencia = 'SELECT * FROM unidad WHERE id_unidad = :id_unidad';
            $stmt = $dbh->prepare($sentencia);
            $stmt -> bindParam(':id_unidad', $id_un, PDO::PARAM_INT);
            $stmt -> execute();
            $filas = $stmt -> fetchAll();
            return $filas;
        }
        function update($id_un, $un)
        {
            $dbh = $this -> connect();
            $sentencia = 'UPDATE unidad SET unidad = :unidad WHERE id_unidad = :id_unidad';
            $stmt= $dbh -> prepare($sentencia);
            $stmt -> bindParam(':id_unidad', $id_un, PDO::PARAM_INT);
            $stmt -> bindParam(':unidad', $un, PDO::PARAM_STR);
            $resultado = $stmt -> execute();
            return $resultado;
        }
        function delete($id_un)
        {
            $dbh = $this -> connect();
            $sentencia = 'DELETE FROM unidad WHERE id_unidad = :id_unidad';
            $stmt= $dbh->prepare($sentencia);
            $stmt->bindParam(':id_unidad', $id_un, PDO::PARAM_INT);
            $resultado = $stmt -> execute();
            return $resultado;
        }

        function total(){
            $dbh = $this -> Connect();
            $sentencia = "SELECT COUNT(id_unidad) AS total FROM unidad";
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> execute();
            $rows = $stmt -> fetchAll();
            return $rows[0]['total'];
        }
    }
?>
