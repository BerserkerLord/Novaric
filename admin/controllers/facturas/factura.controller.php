<?php
    require_once('controllers/sistema.controller.php');
    class Factura extends Sistema
    {

       /*
        * Metodo para cambiar el estatus de una factura de compra
        * Params String @id_factura recibe el id de la factura
        *        String @id_status_factura recibe el id del estatus de la factura
        * Return Arreglo con informacion de exito al momento de hacer la operación
        */
        function changeStatusCompra($id_factura, $id_estatus_factura)
        {
            $dbh = $this -> connect();
            $sentencia = 'SELECT id_estatus_factura FROM factura WHERE id_factura = :id_factura';
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindParam(':id_factura', $id_factura, PDO::PARAM_INT);
            $stmt -> execute();
            $row = $stmt -> fetchAll();
            $estatus = $row[0]['id_estatus_factura'];
            if($estatus != 3 && $id_estatus_factura == 3){
                $dbh -> beginTransaction();
            }
            try {
                $sentencia = "UPDATE factura SET id_estatus_factura = :id_estatus_factura WHERE id_factura = :id_factura";
                $stmt = $dbh -> prepare($sentencia);
                $stmt -> bindParam(':id_estatus_factura', $id_estatus_factura, PDO::PARAM_INT);
                $stmt -> bindParam(':id_factura', $id_factura, PDO::PARAM_INT);
                $stmt -> execute();
                if($estatus != 3 && $id_estatus_factura == 3){
                    $sentencia = "SELECT codigo_producto, cantidad FROM detalle_factura_producto_compra WHERE id_factura = :id_factura";
                    $stmt = $dbh -> prepare($sentencia);
                    $stmt -> bindParam(':id_factura', $id_factura, PDO::PARAM_INT);
                    $stmt -> execute();
                    $rows = $stmt -> fetchAll();
                    $faltantes = true;
                    foreach($rows as $key => $cantidad):
                        $sentencia = 'SELECT existencias FROM producto WHERE codigo_producto = :codigo_producto';
                        $stmt = $dbh -> prepare($sentencia);
                        $stmt -> bindParam(':codigo_producto', $cantidad['codigo_producto'], PDO::PARAM_STR);
                        $stmt -> execute();
                        $row = $stmt -> fetchAll();
                        $existencias = $row[0]['existencias'];
                        $existencias_nuevas = $existencias - $cantidad['cantidad'];
                        if($existencias_nuevas < 0){
                            $faltantes = false;
                        }
                        $sentencia = "UPDATE producto SET existencias = :existencias WHERE codigo_producto = :codigo_producto";
                        $stmt = $dbh -> prepare($sentencia);
                        $stmt -> bindParam(':existencias', $existencias_nuevas, PDO::PARAM_STR);
                        $stmt -> bindParam(':codigo_producto', $cantidad['codigo_producto'], PDO::PARAM_INT);
                        $stmt-> execute();
                    endforeach;
                    if($faltantes){
                        $dbh -> commit();
                        $msg['msg'] = 'Estatús cambiado correctamente.';
                        $msg['status'] = 'success';
                        return $msg;
                    } else {
                        $dbh -> commit();
                        $msg['msg'] = 'Estatús cambiado correctamente, pero hay faltantes de productos, favor de revisar el inventario.';
                        $msg['status'] = 'danger';
                        return $msg;
                    }
                }
                $msg['msg'] = 'Estatús cambiado correctamente.';
                $msg['status'] = 'success';
                return $msg;
            } catch (Exception $e) {
                if($estatus != 3 && $id_estatus_factura == 3){
                    print_r($e -> getMessage());
                    $dbh -> rollBack();
                }
                $msg['msg'] = 'Error desconocido al cambiar estatus, favor de contactar al desarrollador.';
                $msg['status'] = 'danger';
                return $msg;
            }
        }

        /*
        * Metodo para cambiar el estatus de una factura de venta
        * Params String @id_factura recibe el id de la factura
        *        String @id_status_factura recibe el id del estatus de la factura
        * Return Arreglo con informacion de exito al momento de hacer la operación
        */
        function changeStatusVenta($id_factura, $id_estatus_factura)
        {
            $dbh = $this -> connect();
            $sentencia = 'SELECT id_estatus_factura FROM factura WHERE id_factura = :id_factura';
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindParam(':id_factura', $id_factura, PDO::PARAM_INT);
            $stmt -> execute();
            $row = $stmt -> fetchAll();
            $estatus = $row[0]['id_estatus_factura'];
            if($estatus != 3 && $id_estatus_factura == 3){
                $dbh -> beginTransaction();
            }
            try {
                $sentencia = "UPDATE factura SET id_estatus_factura = :id_estatus_factura WHERE id_factura = :id_factura";
                $stmt = $dbh -> prepare($sentencia);
                $stmt -> bindParam(':id_estatus_factura', $id_estatus_factura, PDO::PARAM_INT);
                $stmt -> bindParam(':id_factura', $id_factura, PDO::PARAM_INT);
                $stmt -> execute();
                if($estatus != 3 && $id_estatus_factura == 3){
                    $sentencia = "SELECT codigo_producto, cantidad FROM detalle_factura_producto_venta WHERE id_factura = :id_factura";
                    $stmt = $dbh -> prepare($sentencia);
                    $stmt -> bindParam(':id_factura', $id_factura, PDO::PARAM_INT);
                    $stmt -> execute();
                    $rows = $stmt -> fetchAll();
                    $faltantes = true;
                    foreach($rows as $key => $cantidad):
                        $sentencia = 'SELECT existencias FROM producto WHERE codigo_producto = :codigo_producto';
                        $stmt = $dbh -> prepare($sentencia);
                        $stmt -> bindParam(':codigo_producto', $cantidad['codigo_producto'], PDO::PARAM_STR);
                        $stmt -> execute();
                        $row = $stmt -> fetchAll();
                        $existencias = $row[0]['existencias'];
                        $existencias_nuevas = $existencias + $cantidad['cantidad'];
                        if($existencias_nuevas < 0){
                            $faltantes = false;
                        }
                        $sentencia = "UPDATE producto SET existencias = :existencias WHERE codigo_producto = :codigo_producto";
                        $stmt = $dbh -> prepare($sentencia);
                        $stmt -> bindParam(':existencias', $existencias_nuevas, PDO::PARAM_STR);
                        $stmt -> bindParam(':codigo_producto', $cantidad['codigo_producto'], PDO::PARAM_INT);
                        $stmt-> execute();
                    endforeach;
                    if($faltantes){
                        $dbh -> commit();
                        $msg['msg'] = 'Estatús cambiado correctamente.';
                        $msg['status'] = 'success';
                        return $msg;
                    } else {
                        $dbh -> commit();
                        $msg['msg'] = 'Estatús cambiado correctamente, pero hay faltantes de productos, favor de revisar el inventario.';
                        $msg['status'] = 'danger';
                        return $msg;
                    }
                }
                $msg['msg'] = 'Estatús cambiado correctamente.';
                $msg['status'] = 'success';
                return $msg;
            } catch (Exception $e) {
                if($estatus != 3 && $id_estatus_factura == 3){
                    $dbh -> rollBack();
                }
                $msg['msg'] = 'Error desconocido al cambiar estatus, favor de contactar al desarrollador.';
                $msg['status'] = 'danger';
                return $msg;
            }
        }

        /*
        * Metodo para cambiar el estatus de una factura de servicio
        * Params String @id_factura recibe el id de la factura
        *        String @id_status_factura recibe el id del estatus de la factura
        * Return Arreglo con informacion de exito al momento de hacer la operación
        */
        function changeStatusServicio($id_factura, $id_estatus_factura)
        {
            $dbh = $this -> connect();
            try {
                $sentencia = "UPDATE factura SET id_estatus_factura = :id_estatus_factura WHERE id_factura = :id_factura";
                $stmt = $dbh -> prepare($sentencia);
                $stmt -> bindParam(':id_estatus_factura', $id_estatus_factura, PDO::PARAM_INT);
                $stmt -> bindParam(':id_factura', $id_factura, PDO::PARAM_INT);
                $stmt -> execute();
                $msg['msg'] = 'Estatús cambiado correctamente.';
                $msg['status'] = 'success';
                return $msg;
            } catch (Exception $e) {
                $msg['msg'] = 'Error desconocido al cambiar estatus, favor de contactar al desarrollador.';
                $msg['status'] = 'danger';
                return $msg;
            }
        }

       /*
        * Método para leer los estatus que hay de factura
        * Return Array con los estatús de facturas que hay
        */
        function readEstatuses(){
            $dbh = $this -> connect();
            $sentencia = "SELECT * FROM estatus_factura";
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> execute();
            $filas = $stmt -> fetchAll();
            return $filas;
        }

        /*
        * Método para leer los estatus que hay de venta
        * Return Array con los estatús de ventas que hay
        */
        function readEstatusesVenta(){
            $dbh = $this -> connect();
            $sentencia = "SELECT * FROM estatus_venta";
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> execute();
            $filas = $stmt -> fetchAll();
            return $filas;
        }

      /*
       * Método para extrater total de productos de un tipo
       * Params Integer @columna recibe la columna de la tabla de la que extraerá el total
       *        String  @table recibe tipo de producto que se contará
       * Return un entero que es la cantidad de productos
       */
        function total($columna, $tabla){
            $dbh = $this -> Connect();
            $sentencia = "SELECT COUNT(" . $columna . ") AS total FROM " . $tabla;
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> execute();
            $rows = $stmt -> fetchAll();
            return $rows[0]['total'];
        }
    }
?>