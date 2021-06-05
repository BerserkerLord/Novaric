<?php
    require_once('controllers/sistema.controller.php');
    class FormaAspersion extends Sistema
    {
        var $id_forma_aspersion;
        var $forma_aspersion;
    
        function getIdFormaAspersion(){ return $this -> id_forma_aspersion; }
        function getFormaAspersion(){ return $this -> forma_aspersion; }
    
        function setIdFormaAspersion($id_f_a){ $this -> id_forma_aspersion = $id_f_a; }
        function setFormaAspersion($f_a){ $this -> forma_aspersion = $f_a; }
    
        function create($f_a)
        {
            $dbh = $this->connect();
            $sentencia = "INSERT INTO forma_aspersion(forma_aspersion) VALUES(:forma_aspersion)";
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindParam(':forma_aspersion', $f_a, PDO::PARAM_STR);
            $resultado = $stmt->execute();
            return $resultado;
        }
    
        function read()
        {
            $dbh = $this -> Connect();
            $busqueda = (isset($_GET['busqueda']))?$_GET['busqueda']:'';
            $ordenamiento = (isset($_GET['ordenamiento']))?$_GET['ordenamiento']:'fa.forma_aspersion';
            $limite = (isset($_GET['limite']))?$_GET['limite']:'5';
            $desde = (isset($_GET['desde']))?$_GET['desde']:'0';
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
    
        function update($id_f_a, $tb)
        {
            $dbh = $this->connect();
            $sentencia = "UPDATE forma_aspersion SET forma_aspersion = :forma_aspersion WHERE id_forma_aspersion = :id_forma_aspersion";
            $stmt = $dbh -> prepare($sentencia);
            $stmt->bindParam(':id_forma_aspersion', $id_f_a, PDO::PARAM_INT);
            $stmt->bindParam(':forma_aspersion', $tb, PDO::PARAM_STR);
            $resultado = $stmt->execute();
            return $resultado;
        }
    
        function delete($id_f_a)
        {
            $dbh = $this->connect();
            $sentencia = 'DELETE FROM forma_aspersion WHERE id_forma_aspersion = :id_forma_aspersion';
            $stmt= $dbh->prepare($sentencia);
            $stmt->bindParam(':id_forma_aspersion', $id_f_a, PDO::PARAM_INT);
            $resultado = $stmt->execute();
            return $resultado;
        }
    
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