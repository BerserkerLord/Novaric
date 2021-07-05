<?php
    require_once('factura.controller.php');

   /*
    * Clase principal para facturas de servicios
    */
    class FacturaServicio extends Factura
    {

       /*
        * Método para insertar de una factura de un servicio
        * Params String   @rfc recibe el rfc del cliente
        *        String   @descripcion recibe la descripcion de la factura
        *        Double   @domicilio recibe el domicilio donde se hará el servicio
        *        Integer  @id_servicio recibe el id del servicio que se birndará
        *        Double   @monto recibe el monto por el cual se hará el servicio
        * Return Arreglo con informacion de exito al momento de hacer la operación
        */
        function createFacturaServicio($rfc, $descripcion, $domicilio, $id_servicio, $monto)
        {
            $dbh = $this->Connect();
            $dbh->beginTransaction();
            try {
                $sentencia = "INSERT INTO factura(fecha, id_estatus_factura) VALUES(CURDATE(), 1)";
                $stmt = $dbh->prepare($sentencia);
                $stmt->execute();
                $id_last_servicio = $dbh->lastInsertId();
                $sentencia = 'INSERT INTO factura_servicio(id_factura, rfc, descripcion, domicilio) VALUES(:id_factura, :rfc, :descripcion, :domicilio)';
                $stmt = $dbh->prepare($sentencia);
                $stmt->bindValue(":id_factura", $id_last_servicio, PDO::PARAM_INT);
                $stmt->bindValue(":rfc", $rfc, PDO::PARAM_STR);
                $stmt->bindValue(":descripcion", $descripcion, PDO::PARAM_STR);
                $stmt->bindValue(":domicilio", $domicilio, PDO::PARAM_STR);
                $stmt->execute();
                $sentencia = 'INSERT INTO factura_servicio_servicio(id_factura_servicio, id_servicio, monto) VALUES(:id_factura_servicio, :id_servicio, :monto)';
                $stmt = $dbh->prepare($sentencia);
                $stmt->bindValue(":id_factura_servicio", $id_last_servicio, PDO::PARAM_INT);
                $stmt->bindValue(":id_servicio", $id_servicio, PDO::PARAM_INT);
                $stmt->bindValue(":monto", $monto, PDO::PARAM_STR);
                $stmt->execute();
                $dbh->commit();
                $msg['msg'] = 'Factura registrada correctamente.';
                $msg['status'] = 'success';
                return $msg;
            } catch (Exception $e) {
                $dbh->rollBack();
                $msg['msg'] = $e -> getMessage();
                $msg['status'] = 'danger';
                return $msg;
            }
        }

        /*
         * Metodo para agregar un servicio a una factura
         * Params Integer @id_factura recibe el id de la factura
         *        Integer @id_servicio recibe el id del servicio
         *        Double  @monto recibe el monto por el que se hizo el servicio
         * Return Arreglo con informacion de exito al momento de hacer la operación
         */
        function insertServicio($id_factura, $id_servicio, $monto){
            $dbh = $this -> Connect();
            try {
                $sentencia = 'INSERT INTO factura_servicio_servicio(id_factura_servicio, id_servicio, monto) VALUES(:id_factura_servicio, :id_servicio, :monto)';
                $stmt = $dbh -> prepare($sentencia);
                $stmt -> bindValue(":id_factura_servicio", $id_factura, PDO::PARAM_INT);
                $stmt -> bindValue(":id_servicio", $id_servicio, PDO::PARAM_INT);
                $stmt -> bindValue(":monto", $monto, PDO::PARAM_STR);
                $stmt -> execute();
                $msg['msg'] = 'Servicio asignado correctamente.';
                $msg['status'] = 'success';
                return $msg;
            } catch (Exception $e) {
                $dbh->rollBack();
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
            $ordenamiento = (isset($_GET['ordenamiento']))?$_GET['ordenamiento']:'fa.id_factura_servicio';
            $limite = (isset($_GET['limite']))?$_GET['limite']:'5';
            $desde = (isset($_GET['desde']))?$_GET['desde']:'0';
            /*switch($_SESSION['engine']){
                case 'mariadb':
                    $sentencia = 'SELECT f.id_factura AS id_factura, f.fecha AS fecha, c.rfc AS rfc, es.estatus_factura AS estatus_factura, SUM(fss.monto) AS total FROM factura f
                                    INNER JOIN estatus_factura AS es USING(id_estatus_factura)
                                    INNER JOIN factura_servicio AS fs USING(id_Factura)
                                    INNER JOIN cliente AS c USING(rfc)
                                    INNER JOIN factura_servicio_servicio AS fss ON fs.id_factura = fss.id_factura_servicio
                                 WHERE c.rfc LIKE :busqueda
                                 GROUP BY f.id_factura
                                 ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
                    break;
                case 'postgresql':
                    $sentencia = 'SELECT f.id_factura AS id_factura, f.fecha AS fecha, c.rfc AS rfc, es.estatus_factura AS estatus_factura, SUM(fss.monto) AS total FROM factura f
                                    INNER JOIN estatus_factura AS es USING(id_estatus_factura)
                                    INNER JOIN factura_servicio AS fs USING(id_Factura)
                                    INNER JOIN cliente AS c USING(rfc)
                                    INNER JOIN factura_servicio_servicio AS fss ON fs.id_factura = fss.id_factura_servicio
                                 WHERE c.rfc ILIKE :busqueda
                                 GROUP BY f.id_factura
                                 ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
                    break;
            }*/
            $sentencia = 'SELECT f.id_factura AS id_factura, f.fecha AS fecha, c.rfc AS rfc, es.estatus_factura AS estatus_factura, SUM(fss.monto) AS total FROM factura f
                                INNER JOIN estatus_factura AS es USING(id_estatus_factura)
                                INNER JOIN factura_servicio AS fs USING(id_Factura)
                                INNER JOIN cliente AS c USING(rfc)
                                INNER JOIN factura_servicio_servicio AS fss ON fs.id_factura = fss.id_factura_servicio
                          WHERE c.rfc LIKE :busqueda
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
            $sentencia = 'SELECT *, SUM(fss.monto) AS total FROM factura f
                                INNER JOIN estatus_factura USING(id_estatus_factura)
                                INNER JOIN factura_servicio USING(id_Factura)
                                INNER JOIN cliente USING(rfc)
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

       /*
        * Metodo para leer los servicios que hay en una factura
        * Params Integer @id_factura recibe el id de la factura
        * Return Arreglo con la informacion de los servicios de la factura
        */
        function readServiciosFactura($id_factura){
            $dbh = $this -> Connect();
            $sentencia = 'SELECT s.servicio, fss.monto FROM factura f
                                INNER JOIN factura_servicio_servicio AS fss ON f.id_factura = fss.id_factura_servicio
                                INNER JOIN servicio AS s ON fss.id_servicio = s.id_servicio
                                WHERE f.id_factura = :id_factura';
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindValue(":id_factura", $id_factura, PDO::PARAM_INT);
            $stmt -> execute();
            $filas = $stmt -> fetchAll();
            return $filas;
        }

       /*
        * Metodo para leer el cliente que hay en una factura
        * Params Integer @id_factura recibe el id de la factura
        * Return Arreglo con la informacion del cliente de la factura
        */
        function readClienteServicio($id_factura){
            $dbh = $this -> Connect();
            $sentencia = 'SELECT c.rfc AS rfc, CONCAT(c.nombre, " ", c.apaterno, " ", c.amaterno), c.email AS email, c.telefono AS telefono, c.domicilio AS domicilio FROM factura AS f
	                          INNER JOIN factura_servicio AS fs USING(id_factura)
                              INNER JOIN cliente AS c USING(rfc)
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
        function readFacturaServicio($id_factura){
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