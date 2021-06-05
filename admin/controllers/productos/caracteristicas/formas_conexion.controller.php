<?php
    require_once('controllers/sistema.controller.php');
    class FormaConexion extends Sistema
    {
        var $id_forma_conexion;
        var $forma_conexion;
    
        function getIdFormaConexion(){ return $this -> id_forma_conexion; }
        function getFormaConexion(){ return $this -> forma_conexion; }
    
        function setIdFormaConexion($id_f){ $this -> id_forma_conexion = $id_f; }
        function setFormaConexion($for){ $this -> forma_conexion = $for; }
    
        function create($for)
        {
            $dbh = $this -> connect();
            $sentencia = "INSERT INTO forma_conexion(forma_conexion) VALUES(:forma_conexion)";
            $stmt= $dbh -> prepare($sentencia);
            $stmt -> bindParam(':forma_conexion', $for, PDO::PARAM_STR);
            $resultado = $stmt -> execute();
            return $resultado;
        }
    
        function read()
        {
            $dbh = $this -> Connect();
            $busqueda = (isset($_GET['busqueda']))?$_GET['busqueda']:'';
            $ordenamiento = (isset($_GET['ordenamiento']))?$_GET['ordenamiento']:'f.forma_conexion';
            $limite = (isset($_GET['limite']))?$_GET['limite']:'5';
            $desde = (isset($_GET['desde']))?$_GET['desde']:'0';
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
        function readOne($id_f)
        {
            $dbh = $this -> connect();
            $sentencia = 'SELECT * FROM forma_conexion WHERE id_forma_conexion = :id_forma_conexion';
            $stmt = $dbh->prepare($sentencia);
            $stmt -> bindParam(':id_forma_conexion', $id_f, PDO::PARAM_INT);
            $stmt -> execute();
            $filas = $stmt -> fetchAll();
            return $filas;
        }
        function update($id_f, $for)
        {
            $dbh = $this->connect();
            $sentencia = 'UPDATE forma_conexion SET forma_conexion = :forma_conexion WHERE id_forma_conexion = :id_forma_conexion';
            $stmt= $dbh->prepare($sentencia);
            $stmt->bindParam(':id_forma_conexion', $id_f, PDO::PARAM_INT);
            $stmt->bindParam(':forma_conexion', $for, PDO::PARAM_STR);
            $resultado = $stmt -> execute();
            return $resultado;
        }
        function delete($id_f)
        {
            $dbh = $this->connect();
            $sentencia = 'DELETE FROM forma_conexion WHERE id_forma_conexion = :id_forma_conexion';
            $stmt= $dbh->prepare($sentencia);
            $stmt -> bindParam(':id_forma_conexion', $id_f, PDO::PARAM_INT);
            $resultado = $stmt -> execute();
            return $resultado;
        }
    
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