<?php
    require_once('controllers/sistema.controller.php');
    class Extremidad extends Sistema
    {
        var $id_extremidad;
        var $extremidad;
    
        function getIdExtremidad(){ return $this -> id_extremidad; }
        function getExtremidad(){ return $this -> extremidad; }
    
        function setIdExtremidad($id_ext){ $this -> id_extremidad = $id_ext; }
        function setExtremidad($ext){ $this -> extremidad = $ext; }
    
        function create($ext)
        {
            $dbh = $this -> connect();
            $sentencia = "INSERT INTO extremidad(extremidad) VALUES(:extremidad)";
            $stmt= $dbh->prepare($sentencia);
            $stmt -> bindParam(':extremidad', $ext, PDO::PARAM_STR);
            $resultado = $stmt -> execute();
            return $resultado;
        }
    
        function read()
        {
            $dbh = $this -> Connect();
            $busqueda = (isset($_GET['busqueda']))?$_GET['busqueda']:'';
            $ordenamiento = (isset($_GET['ordenamiento']))?$_GET['ordenamiento']:'e.extremidad';
            $limite = (isset($_GET['limite']))?$_GET['limite']:'5';
            $desde = (isset($_GET['desde']))?$_GET['desde']:'0';
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
        function update($id_ext, $ext)
        {
            $dbh = $this->connect();
            $sentencia = 'UPDATE extremidad SET extremidad = :extremidad WHERE id_extremidad = :id_extremidad';
            $stmt= $dbh->prepare($sentencia);
            $stmt->bindParam(':id_extremidad', $id_ext, PDO::PARAM_INT);
            $stmt->bindParam(':extremidad', $ext, PDO::PARAM_STR);
            $resultado = $stmt -> execute();
            return $resultado;
        }
        function delete($id_ext)
        {
            $dbh = $this->connect();
            $sentencia = 'DELETE FROM extremidad WHERE id_extremidad = :id_extremidad';
            $stmt= $dbh->prepare($sentencia);
            $stmt -> bindParam(':id_extremidad', $id_ext, PDO::PARAM_INT);
            $resultado = $stmt -> execute();
            return $resultado;
        }
    
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