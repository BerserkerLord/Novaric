<?php
    require_once('controllers/sistema.controller.php');
    class Factura extends Sistema
    {
        function changeStatus($id_factura, $id_estatus_factura)
        {
            $dbh = $this -> connect();
            $sentencia = "UPDATE factura SET id_estatus_factura = :id_estatus_factura WHERE id_factura = :id_factura";
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindParam(':id_estatus_factura', $id_estatus_factura, PDO::PARAM_INT);
            $stmt -> bindParam(':id_factura', $id_factura, PDO::PARAM_INT);
            $resultado = $stmt -> execute();
            return $resultado;
        }

        function readEstatuses(){
            $dbh = $this -> connect();
            $sentencia = "SELECT * FROM estatus_factura";
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> execute();
            $filas = $stmt -> fetchAll();
            return $filas;
        }
    }
?>