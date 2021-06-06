<?php
    require_once('factura.controller.php');
    class FacturaServicio extends Factura
    {

        function createFacturaServicio($id_servicios, $montos, $rfc, $descripcion, $domicilio)
        {
            $dbh = $this -> Connect();
            $dbh -> beginTransaction();
            try{
                $this -> createFactura(1) -> execute();
                $idLast = $dbh -> lastInsertId();
                $sentencia = 'INSERT INTO factura_servicio(id_factura, rfc, descripcion, domicilio) VALUES(:id_factura, :rfc, :descripcion, :domicilio)';
                $stmt = $dbh -> prepare($sentencia);
                $stmt -> bindValue(":id_factura", $idLast, PDO::PARAM_STR);
                $stmt -> bindValue(":rfc", $rfc, PDO::PARAM_STR);
                $stmt -> bindValue(":descripcion", $descripcion, PDO::PARAM_INT);
                $stmt -> bindValue(":domicilio", $domicilio, PDO::PARAM_INT);
                $stmt -> execute();
                foreach($id_servicios as $key => $id_servicio):
                    $sentencia = "INSERT INTO factura_servicio_servicio(id_factura, id_servicio, monto) VALUES(:id_factura, :id_servicio, :monto)";
                    $stmt = $dbh -> prepare($sentencia);
                    $stmt -> bindValue(":id_factura", $idLast, PDO::PARAM_STR);
                    $stmt -> bindValue(":id_servicio", $id_servicio, PDO::PARAM_STR);
                    $stmt -> bindValue(":monto", $montos[key], PDO::PARAM_INT);
                    $stmt -> execute();
                endforeach;
            }
            catch(Exception $e){
                echo 'Excepción capturada: ',  $e -> getMessage(), "\n";
                $dbh -> rollBack();
            }
            $dbh -> rollBack();
        }

        function readFactura()
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
                          WHERE f.id_factura LIKE :busqueda
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