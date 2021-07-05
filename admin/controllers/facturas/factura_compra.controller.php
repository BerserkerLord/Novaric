<?php
    require_once('factura.controller.php');

    /*
    * Clase principal para facturas de compras
    */
    class FacturaCompra extends Factura
    {

       /*
        * Método para insertar de una factura de una compra
        * Params String  @rfc recibe el rfc del proveedor
        *        Double  @codigo_producto recibe el codigo del producto
        *        Integer @cantidad del producto
        * Return Arreglo con informacion de exito al momento de hacer la operación
        */
        function createFacturaCompra($rfc, $codigo_producto, $caantidad)
        {
            $dbh = $this -> Connect();
            $dbh -> beginTransaction();
            try{
                $sentencia = 'SELECT existencias FROM producto WHERE codigo_producto = :codigo_producto';
                $stmt = $dbh -> prepare($sentencia);
                $stmt -> bindParam(':codigo_producto', $codigo_producto, PDO::PARAM_STR);
                $stmt -> execute();
                $row = $stmt -> fetchAll();
                $existencias = $row[0]['existencias'];
                $existencias_actuales = $existencias + $caantidad;
                $sentencia = "INSERT INTO factura(fecha, id_estatus_factura) VALUES(CURDATE(), 1)";
                $stmt = $dbh -> prepare($sentencia);
                $stmt -> execute();
                $id_last_compra = $dbh -> lastInsertId();
                $sentencia = 'INSERT INTO factura_compra(id_factura, rfc) VALUES(:id_factura, :rfc)';
                $stmt = $dbh -> prepare($sentencia);
                $stmt -> bindValue(":id_factura", $id_last_compra, PDO::PARAM_INT);
                $stmt -> bindValue(":rfc", $rfc, PDO::PARAM_STR);
                $stmt -> execute();
                $sentencia = 'INSERT INTO detalle_factura_producto_compra(id_factura, codigo_producto, cantidad) VALUES(:id_factura, :codigo_producto, :cantidad)';
                $stmt = $dbh -> prepare($sentencia);
                $stmt -> bindValue(":id_factura", $id_last_compra, PDO::PARAM_INT);
                $stmt -> bindValue(":codigo_producto", $codigo_producto, PDO::PARAM_STR);
                $stmt -> bindValue(":cantidad", $caantidad, PDO::PARAM_STR);
                $stmt -> execute();
                $sentencia = 'UPDATE producto SET existencias = :existencias WHERE codigo_producto = :codigo_producto';
                $stmt = $dbh -> prepare($sentencia);
                $stmt -> bindParam(':existencias', $existencias_actuales, PDO::PARAM_STR);
                $stmt -> bindParam(':codigo_producto', $codigo_producto, PDO::PARAM_STR);
                $stmt -> execute();
                $dbh -> commit();
                $msg['msg'] = 'Factura registrada correctamente.';
                $msg['status'] = 'success';
                return $msg;
            } catch (Exception $e) {
                $dbh -> rollBack();
                $msg['msg'] = "Error desconocido al registrar, favor de contactar con el desarrollador";
                $msg['status'] = 'danger';
                return $msg;
            }
        }

        function insertProducto($id_factura, $codigo_producto, $cantidad){
            $dbh = $this -> Connect();
            $dbh -> beginTransaction();
            try {
                $sentencia = 'SELECT existencias FROM producto WHERE codigo_producto = :codigo_producto';
                $stmt = $dbh -> prepare($sentencia);
                $stmt -> bindParam(':codigo_producto', $codigo_producto, PDO::PARAM_STR);
                $stmt -> execute();
                $row = $stmt -> fetchAll();
                $existencias = $row[0]['existencias'];
                $existencias_actuales = $existencias + $cantidad;

                $sentencia = 'INSERT INTO detalle_factura_producto_compra(id_factura, codigo_producto, cantidad) VALUES(:id_factura, :codigo_producto, :cantidad)';
                $stmt = $dbh -> prepare($sentencia);
                $stmt -> bindValue(":id_factura", $id_factura, PDO::PARAM_INT);
                $stmt -> bindValue(":codigo_producto", $codigo_producto, PDO::PARAM_STR);
                $stmt -> bindValue(":cantidad", $cantidad, PDO::PARAM_STR);
                $stmt -> execute();

                $sentencia = 'UPDATE producto SET existencias = :existencias WHERE codigo_producto = :codigo_producto';
                $stmt = $dbh -> prepare($sentencia);
                $stmt -> bindParam(':existencias', $existencias_actuales, PDO::PARAM_STR);
                $stmt -> bindParam(':codigo_producto', $codigo_producto, PDO::PARAM_STR);
                $stmt -> execute();

                $dbh -> commit();
                $msg['msg'] = 'Producto asignado correctamente.';
                $msg['status'] = 'success';
                return $msg;
            } catch (Exception $e) {
                $dbh -> rollBack();
                $msg['msg'] = 'Error desconcido al asignar, favor de contactar con el desarrollador.';
                $msg['status'] = 'danger';
                return $msg;
            }
        }

        /*
         * Metodo para leer todas las facturas por cantidades
         * Return Array con la informacion de las facturas por cantidades
         */
        function readFactura()
        {
            $dbh = $this -> Connect();
            $busqueda = (isset($_GET['busqueda']))?$_GET['busqueda']:'';
            $ordenamiento = (isset($_GET['ordenamiento']))?$_GET['ordenamiento']:'fa.id_factura_compra';
            $limite = (isset($_GET['limite']))?$_GET['limite']:'5';
            $desde = (isset($_GET['desde']))?$_GET['desde']:'0';

            /*switch($_SESSION['engine']){
                case 'mariadb':
                    $sentencia = 'SELECT f.id_factura AS id_factura, f.fecha AS fecha, pro.rfc AS rfc, es.estatus_factura AS estatus_factura, SUM(dfp.cantidad * costo) AS total FROM factura f
                                     INNER JOIN estatus_factura AS es USING(id_estatus_factura)
                                     INNER JOIN factura_compra AS fc USING(id_factura)
                                     INNER JOIN proveedor AS pro USING(rfc)
                                     INNER JOIN detalle_factura_producto_compra AS dfp ON fc.id_factura = dfp.id_factura
                                     INNER JOIN producto AS p USING(codigo_producto)
                                 WHERE pro.rfc LIKE :busqueda
                                 GROUP BY f.id_factura
                                 ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
                    break;
                case 'postgresql':
                    $sentencia = 'SELECT f.id_factura AS id_factura, f.fecha AS fecha, pro.rfc AS rfc, es.estatus_factura AS estatus_factura, SUM(dfp.cantidad * costo) AS total FROM factura f
                                     INNER JOIN estatus_factura AS es USING(id_estatus_factura)
                                     INNER JOIN factura_compra AS fc USING(id_factura)
                                     INNER JOIN proveedor AS pro USING(rfc)
                                     INNER JOIN detalle_factura_producto_compra AS dfp ON fc.id_factura = dfp.id_factura
                                     INNER JOIN producto AS p USING(codigo_producto)
                                 WHERE pro.rfc ILIKE :busqueda
                                 GROUP BY f.id_factura
                                 ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
                    break;
            }*/

            $sentencia = 'SELECT f.id_factura AS id_factura, f.fecha AS fecha, pro.razon_social AS razon_social, es.estatus_factura AS estatus_factura, SUM(dfp.cantidad * costo) AS total FROM factura f
                                    INNER JOIN estatus_factura AS es USING(id_estatus_factura)
                                    INNER JOIN factura_compra AS fc USING(id_factura)
                                    INNER JOIN proveedor AS pro USING(rfc)
                                    INNER JOIN detalle_factura_producto_compra AS dfp ON fc.id_factura = dfp.id_factura
                                    INNER JOIN producto AS p USING(codigo_producto)
                              WHERE pro.rfc LIKE :busqueda
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

        /*
        * Metodo para leer una sola factura
        * Params Integer @id_Factura recibe el id de la factura
        * Return Array con la informacion de la factura
        */
        function readOneFactura($id_factura)
        {
            $dbh = $this -> Connect();
            $sentencia = 'SELECT f.id_factura AS id_factura, f.fecha AS fecha, pro.razon_social AS razon_social, es.estatus_factura AS estatus_factura, SUM(dfp.cantidad * costo) AS total FROM factura f
                                    INNER JOIN estatus_factura AS es USING(id_estatus_factura)
                                    INNER JOIN factura_compra AS fc USING(id_factura)
                                    INNER JOIN proveedor AS pro USING(rfc)
                                    INNER JOIN detalle_factura_producto_compra AS dfp ON fc.id_factura = dfp.id_factura
                                    INNER JOIN producto AS p USING(codigo_producto)
                          WHERE f.id_factura = :id_factura
                          GROUP BY f.id_factura;';
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindParam(':id_factura', $id_factura, PDO::PARAM_INT);
            $stmt -> execute();
            $filas = $stmt -> fetchAll();
            return $filas;
        }

        /*
        * Metodo para leer los productos que hay en una factura
        * Params Integer @id_factura recibe el id de la factura
        * Return Arreglo con la informacion de los productos de la factura
        */
        function readProductosFactura($id_factura){
            $dbh = $this -> Connect();
            $sentencia = 'SELECT p.codigo_producto, p.producto, p.costo, dfp.cantidad FROM factura f
                                    INNER JOIN detalle_factura_producto_compra AS dfp ON f.id_factura = dfp.id_factura
                                    INNER JOIN producto AS p ON dfp.codigo_producto = p.codigo_producto
                                    WHERE f.id_factura = :id_factura';
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindValue(":id_factura", $id_factura, PDO::PARAM_INT);
            $stmt -> execute();
            $filas = $stmt -> fetchAll();
            return $filas;
        }

        /*
        * Metodo para leer el proveedor que hay en una factura
        * Params Integer @id_factura recibe el id de la factura
        * Return Arreglo con la informacion del proveedor de la factura
        */
        function readProveedorCompra($id_factura){
            $dbh = $this -> Connect();
            $sentencia = 'SELECT pro.rfc AS rfc, pro.razon_social AS razon_social, pro.domicilio AS domicilio, pro.telefono AS telefono FROM factura AS f
                                  INNER JOIN factura_compra AS fc USING(id_factura)
                                  INNER JOIN proveedor AS pro USING(rfc)
                              WHERE f.id_factura = :id_factura';
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindValue(":id_factura", $id_factura, PDO::PARAM_INT);
            $stmt -> execute();
            $filas = $stmt -> fetchAll();
            return $filas;
        }

        /*
        * Metodo para leer la informacion basica de una factura
        * Params Integer @id_factura recibe el id de la factura
        * Return Arreglo con la informacion de la factura
        */
        function readFacturaCompra($id_factura){
            $dbh = $this -> Connect();
            $sentencia = 'SELECT * FROM factura WHERE id_factura = :id_factura';
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindValue(":id_factura", $id_factura, PDO::PARAM_INT);
            $stmt -> execute();
            $filas = $stmt -> fetchAll();
            return $filas;
        }
    }
?>