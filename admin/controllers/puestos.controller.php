<?php
    require_once('sistema.controller.php');
    class Puesto extends Sistema
    {
        var $id_puesto;
        var $puesto;
        var $departamento;

        function getIdPuesto(){ return $this -> id_puesto; }
        function getPuesto(){ return $this -> puesto; }
        function getDepartamento(){ return $this -> departamento; }

        function setIdPuesto($id_pu){ $this -> id_puesto = $id_pu; }
        function setArea($pu){ $this -> puesto = $pu; }
        function setIdDepartamento($dep){ $this -> departamento = $dep; }

        function create($pu, $id_dep)
        {
            $dbh = $this->connect();
            $sentencia = "INSERT INTO puesto(puesto, id_departamento) VALUES(:puesto, :id_departamento)";
            $stmt= $dbh->prepare($sentencia);
            $stmt->bindParam(':puesto', $pu, PDO::PARAM_STR);
            $stmt->bindParam(':id_departamento', $id_dep, PDO::PARAM_INT);
            $resultado = $stmt->execute();
            return $resultado;
        }

        function read()
        {
            $dbh = $this -> Connect();
            $busqueda = (isset($_GET['busqueda']))?$_GET['busqueda']:'';
            $ordenamiento = (isset($_GET['ordenamiento']))?$_GET['ordenamiento']:'p.puesto';
            $limite = (isset($_GET['limite']))?$_GET['limite']:'5';
            $desde = (isset($_GET['desde']))?$_GET['desde']:'0';
            $sentencia = 'SELECT * FROM puesto p 
                              INNER JOIN departamento USING(id_departamento)
                          WHERE p.puesto LIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindValue(":busqueda", '%' . $busqueda . '%', PDO::PARAM_STR);
            $stmt -> bindValue(":ordenamiento", $ordenamiento, PDO::PARAM_STR);
            $stmt -> bindValue(":limite", $limite, PDO::PARAM_INT);
            $stmt -> bindValue(":desde", $desde, PDO::PARAM_INT);
            $stmt->execute();
            $filas=$stmt->fetchAll();
            return $filas;
        }

        function readOne($id_pu)
        {
            $dbh = $this->connect();
            $sentencia='SELECT * FROM puesto INNER JOIN departamento USING(id_departamento) 
                        WHERE id_puesto = :id_puesto';
            $stmt = $dbh->prepare($sentencia);
            $stmt->bindParam(':id_puesto', $id_pu, PDO::PARAM_INT);
            $stmt->execute();
            $filas=$stmt->fetchAll();
            return $filas;
        }

        function update($id_pu, $pu, $id_dep)
        {
            $dbh = $this->connect();
            $sentencia = 'UPDATE puesto SET puesto = :puesto, id_departamento = :id_departamento WHERE id_puesto = :id_puesto';
            $stmt= $dbh->prepare($sentencia);
            $stmt->bindParam(':id_puesto', $id_pu, PDO::PARAM_INT);
            $stmt->bindParam(':puesto', $pu, PDO::PARAM_STR);
            $stmt->bindParam(':id_departamento', $id_dep, PDO::PARAM_INT);
            $resultado = $stmt->execute();
            return $resultado;
        }

        function delete($id_pu)
        {
            $dbh = $this->connect();
            $sentencia = 'DELETE FROM puesto WHERE id_puesto = :id_puesto';
            $stmt= $dbh->prepare($sentencia);
            $stmt->bindParam(':id_puesto', $id_pu, PDO::PARAM_INT);
            $resultado = $stmt->execute();
            return $resultado;
        }

        function total(){
            $dbh = $this -> Connect();
            $sentencia = "SELECT COUNT(id_puesto) AS total FROM puesto";
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> execute();
            $rows = $stmt -> fetchAll();
            return $rows[0]['total'];
        }
    }
?>