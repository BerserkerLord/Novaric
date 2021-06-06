<?php
    require_once('controllers/sistema.controller.php');
    class Factura extends Sistema
    {
        function createFactura($id_estatus_factura)
        {
            $dbh = $this -> connect();
            $sentencia = "INSERT INTO factura(fecha, id_estatus_factura) VALUES(CURDATE(), :id_estatus_factura)";
            $stmt = $dbh->prepare($sentencia);
            $stmt -> bindParam(':id_estatus_factura', $id_estatus_factura, PDO::PARAM_INT);
            return $stmt;
        }

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

        function readOneFactura($id_factura)
        {
            $dbh = $this -> Connect();
            $sentencia = 'SELECT *, SUM(fss.monto) AS total FROM factura f
                                INNER JOIN estatus_factura USING(id_estatus_factura)
                                INNER JOIN factura_servicio USING(id_Factura)
                                INNER JOIN cliente_servicio USING(rfc)
                                INNER JOIN factura_servicio_servicio AS fss ON f.id_factura = fss.id_factura_servicio
                                INNER JOIN servicio AS s ON fss.id_servicio = s.id_servicio
                          WHERE id_factura = :id_factura
                          GROUP BY f.id_factura;';
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindParam(':id_factura', $id_factura, PDO::PARAM_INT);
            $stmt -> execute();
            $filas = $stmt -> fetchAll();
            return $filas;
        }
    }
?>