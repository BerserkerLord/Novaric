<?php
    require_once('controllers/sistema.controller.php');
    class Factura extends Sistema
    {

       /*
        * Metodo para cambiar el estatus de una factura
        * Params String @id_factura recibe el id de la factura
        *        String @id_status_factura recibe el id del estatus de la factura
        * Return Arreglo con informacion de exito al momento de hacer la operación
        */
        function changeStatus($id_factura, $id_estatus_factura)
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
    }
?>