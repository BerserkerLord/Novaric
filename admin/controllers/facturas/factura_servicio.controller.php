<?php
    require_once('factura.controller.php');
    class FacturaServicio extends Factura
    {
        function read()
        {
            $dbh = $this -> Connect();
            $busqueda = (isset($_GET['busqueda']))?$_GET['busqueda']:'';
            $ordenamiento = (isset($_GET['ordenamiento']))?$_GET['ordenamiento']:'fa.id_factura_servicio';
            $limite = (isset($_GET['limite']))?$_GET['limite']:'5';
            $desde = (isset($_GET['desde']))?$_GET['desde']:'0';
            $sentencia = 'SELECT *, SUM(fss.monto) AS total FROM factura f
                                INNER JOIN estatus_factura USING(id_estatus_factura)
                                INNER JOIN factura_servicio USING(id_Factura)
                                INNER JOIN cliente_servicio USING(rfc)
                                INNER JOIN factura_servicio_servicio AS fss ON f.id_factura = fss.id_factura_servicio
                                INNER JOIN servicio AS s ON fss.id_servicio = s.id_servicio
                          WHERE f.nombre LIKE :busqueda
                          GROUP BY f.id_factura
                          ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindValue(":busqueda", '%' . $busqueda . '%', PDO::PARAM_STR);
            $stmt -> bindValue(":ordenamiento", $ordenamiento, PDO::PARAM_STR);
            $stmt -> bindValue(":limite", $limite, PDO::PARAM_INT);
            $stmt -> bindValue(":desde", $desde, PDO::PARAM_INT);
            $stmt -> execute();
            $filas = $stmt -> fetchAll();
            return $filas;
        }
    }
?>