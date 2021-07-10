<?php
    require_once('sistema.controller.php');
    use Upload\File;
    use Upload\Storage\FileSystem;
    use Upload\Validation\Size;
    use Upload\Validation\Mimetype;
    use Upload\Exception\UploadException;

    /*
    * Clase principal para servicios
    */
    class Servicio extends Sistema{

       /*
        * Método para insertar un registro de servicio a la base de datos Novaric
        * Params String @servicio recibe el servicio a registrar
        *        String @descripcion recibe la descripcion de un servicio
        * Return Arreglo con informacion de exito al momento de hacer la operación
        */
        function create($servicio, $descripcion){
            $dbh = $this -> Connect();
            try {
                $foto = $this -> guardarFotografia();
                $sentencia = "INSERT INTO servicio(servicio, descripcion, fotografia)
                                        VALUES(:servicio, :descripcion, :fotografia)";
                $stmt = $dbh -> prepare($sentencia);
                $stmt -> bindParam(":servicio", $servicio, PDO::PARAM_STR);
                $stmt -> bindParam(":descripcion", $descripcion, PDO::PARAM_STR);
                $stmt -> bindParam(":fotografia", $foto, PDO::PARAM_STR);
                $stmt -> execute();
                $msg['msg'] = 'Servicio registrado correctamente.';
                $msg['status'] = 'success';
                return $msg;
            } catch (Exception $e) {
                $msg['msg'] = 'Error desconocido al registrar, favor de contactar con el desarrollador.';
                $msg['status'] = 'danger';
                return $msg;
            }
        }

       /*
        * Método para actualizar un registro de servicio a la base de datos Novaric
        * Params Integer @id_servicio recibe el id del servicio a actualizar
        *        String  @servicio recibe el servicio a actualizar
        *        String  @descripcion recibe la descripcion de un servicio
        * Return Arreglo con informacion de exito al momento de hacer la operación
        */
        function update($id_servicio, $servicio, $descripcion){
            $dbh = $this -> Connect();
            try {
                $foto = $this -> guardarFotografia();
                if($foto){
                    $sentencia = "UPDATE servicio SET servicio = :servicio, descripcion = :descripcion, 
                              fotografia = :fotografia WHERE id_servicio = :id_servicio";
                    $stmt = $dbh -> prepare($sentencia);
                    $stmt -> bindParam(":fotografia", $foto, PDO::PARAM_STR);
                }
                else{
                    $sentencia = "UPDATE servicio SET servicio = :servicio, descripcion = :descripcion
                              WHERE id_servicio = :id_servicio";
                    $stmt = $dbh -> prepare($sentencia);
                }
                $stmt -> bindParam(":servicio", $servicio, PDO::PARAM_STR);
                $stmt -> bindParam(":descripcion", $descripcion, PDO::PARAM_STR);
                $stmt -> bindParam(":id_servicio", $id_servicio, PDO::PARAM_INT);
                $stmt -> execute();
                $msg['msg'] = 'Servicio actualizado correctamente.';
                $msg['status'] = 'success';
                return $msg;
            } catch (Exception $e) {
                $msg['msg'] = 'Error desconocido al actualizar, favor de contactar con el desarrollador.';
                $msg['status'] = 'danger';
                return $msg;
            }
        }

        /*
         * Metodo para elimina el registro de un servicio
         * Params Integer @id_servicio recibe el id de un servicio
         * Return Arreglo con informacion de exito al momento de hacer la operación
         */
        function delete($id_servicio){
            $dbh = $this -> Connect();
            try {
                $stmt = $dbh -> prepare('DELETE FROM servicio WHERE id_servicio = :id_servicio');
                $stmt -> bindParam(":id_servicio", $id_servicio, PDO::PARAM_INT);
                $stmt -> execute();
                $msg['msg'] = 'Servicio eliminado correctamente.';
                $msg['status'] = 'success';
                return $msg;
            } catch (Exception $e) {
                $msg['msg'] = 'Error al eliminar, el servicio tiene facturas asignadas.';
                $msg['status'] = 'danger';
                return $msg;
            }
        }

       /*
        * Método para obtener todos los servicios por cantidades
        * Return Array con todos los servicios
        */
        function read(){
            $dbh = $this -> Connect();
            $busqueda = (isset($_GET['busqueda']))?$_GET['busqueda']:'';
            $ordenamiento = (isset($_GET['ordenamiento']))?$_GET['ordenamiento']:'s.servicio';
            $limite = (isset($_GET['limite']))?$_GET['limite']:'3';
            $desde = (isset($_GET['desde']))?$_GET['desde']:'0';
            switch($_SESSION['engine']){
                case 'mariadb':
                    $sentencia = 'SELECT * FROM servicio s WHERE s.servicio LIKE :busqueda ORDER BY :ordenamiento ASC LIMIT :limite OFFSET :desde';
                    break;
                case 'postgresql':
                    $sentencia = 'SELECT * FROM servicio s WHERE s.servicio ILIKE :busqueda ORDER BY :ordenamiento ASC LIMIT :limite OFFSET :desde';
                    break;
            }
            if(!isset($_SESSION['engine'])){

            }
            //$sentencia = 'SELECT * FROM servicio s WHERE s.servicio LIKE :busqueda ORDER BY :ordenamiento ASC LIMIT :limite OFFSET :desde';
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindValue(":busqueda", '%' . $busqueda . '%', PDO::PARAM_STR);
            $stmt -> bindValue(":ordenamiento", $ordenamiento, PDO::PARAM_STR);
            $stmt -> bindValue(":limite", $limite, PDO::PARAM_INT);
            $stmt -> bindValue(":desde", $desde, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt -> fetchAll();
            return $rows;
        }

        /*
         * Metodo para obtener la informacion de una marca
         * Params Integer @id_servicio recibe el id de un servicio
         * Return Array con la información de un servicio
         */
        function readOne($id_servicio){
            $dbh = $this -> Connect();
            $sentencia = 'SELECT * FROM servicio WHERE id_servicio = :id_servicio';
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindParam(':id_servicio', $id_servicio, PDO::PARAM_INT);
            $stmt -> execute();
            $rows = $stmt -> fetchAll();
            return $rows;
        }

       /*
        * Método para obtener todos los servicio
        * Return Array con todos los servicios
        */
        function readAll()
        {
            $dbh = $this -> Connect();
            $sentencia = 'SELECT * FROM servicio AS s';
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> execute();
            $filas = $stmt -> fetchAll();
            return $filas;
        }

      /*
       * Método para subir una imagen de una marca
       * Return Booleano señalando si la imagen es valida de acuerdo al formato o no
       */
        function guardarFotografia()
        {
            $storage = new FileSystem('../archivos');
            $file = new File('fotografia', $storage);

            $new_filename = MD5(uniqid());
            $file -> setName($new_filename);

            $file -> addValidations(array(
                new Size('5M'),
                new Mimetype(array('image/png', 'image/jpeg', 'image/jpg'))
            ));
            if($_FILES['fotografia']['error'] == 0)
            {
                try {
                    $file -> upload();
                    $filename = $new_filename . '.' . $file->getExtension();
                    return $filename;
                } catch (UploadException $e) {
                    $errors = $file->getErrors();
                    //print_r($errors);
                    return false;
                }
            }
            return false;
        }

      /*
       * Método para extrater total de servicios
       * Return un entero que es la cantidad de servicios
       */
        function total(){
            $dbh = $this -> Connect();
            $sentencia = "SELECT COUNT(id_servicio) AS total FROM servicio";
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> execute();
            $rows = $stmt -> fetchAll();
            return $rows[0]['total'];
        }

       /*
        * Metodo para obtener los servicios para asignar una factura
        * Params Integer @id_factura recibe el id de una factura
        * Return Array con las facturas disponibles para una factura
        */
        function readServiciosDisponibles($id_factura){
            $dbh = $this -> Connect();
            $query = "SELECT id_servicio, servicio FROM servicio 
                      WHERE id_servicio NOT IN(SELECT s.id_servicio FROM factura f 
                                                    INNER JOIN factura_servicio_servicio AS fss ON f.id_factura = fss.id_factura_servicio
                                                    INNER JOIN servicio s ON s.id_servicio = fss.id_servicio 
                                               WHERE f.id_factura = :id_factura)";
            $stmt = $dbh -> prepare($query);
            $stmt -> bindParam(":id_factura", $id_factura, PDO::PARAM_INT);
            $stmt -> execute();
            $fila = $stmt -> fetchAll();
            return $fila;
        }
    }
?>