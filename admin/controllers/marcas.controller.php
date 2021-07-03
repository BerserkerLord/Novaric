<?php
    require_once('sistema.controller.php');

    /*
     * Clase principal para marcas
     */
    class Marca extends Sistema
    {
       /*
        * Método para insertar un registro de marca a la base de datos Novaric
        * Params String @mar recibe la marca
        * Return Arreglo con informacion de exito al momento de hacer la operación
        */
        function create($mar)
        {
            $dbh = $this -> connect();
            try {
                $foto = $this -> guardarFotografia();
                $sentencia = "INSERT INTO marca(marca, fotografia) VALUES(:marca, :fotografia)";
                $stmt = $dbh -> prepare($sentencia);
                $stmt -> bindParam(':marca', $mar, PDO::PARAM_STR);
                $stmt -> bindParam(':fotografia', $foto, PDO::PARAM_STR);
                $stmt -> execute();
                $msg['msg'] = 'Marca registrada correctamente.';
                $msg['status'] = 'success';
                return $msg;
            } catch (Exception $e) {
                $msg['msg'] = 'Error al registrar, la marca ya existe.';
                $msg['status'] = 'danger';
                return $msg;
            }
        }

       /*
        * Método para obtener todos las marcas por cantidades
        * Return Array con todas las marcas
        */
        function read()
        {
            $dbh = $this -> Connect();
            $busqueda = (isset($_GET['busqueda']))?$_GET['busqueda']:'';
            $ordenamiento = (isset($_GET['ordenamiento']))?$_GET['ordenamiento']:'m.marca';
            $limite = (isset($_GET['limite']))?$_GET['limite']:'3';
            $desde = (isset($_GET['desde']))?$_GET['desde']:'0';
            /*switch($_SESSION['engine']){
                case 'mariadb':
                    $sentencia = 'SELECT * FROM marca AS m WHERE m.marca LIKE :busqueda ORDER BY :ordenamiento ASC LIMIT :limite OFFSET :desde';
                    break;
                case 'postgresql':
                    $sentencia = 'SELECT * FROM marca AS m WHERE m.marca ILIKE :busqueda ORDER BY :ordenamiento ASC LIMIT :limite OFFSET :desde';
                    break;
            }*/
            $sentencia = 'SELECT * FROM marca AS m WHERE m.marca LIKE :busqueda ORDER BY :ordenamiento ASC LIMIT :limite OFFSET :desde';
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
        * Método para obtener todos las marcas
        * Return Array con todas las marcas
        */
        function readAll()
        {
            $dbh = $this -> Connect();
            $sentencia = 'SELECT * FROM marca AS m';
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> execute();
            $filas = $stmt -> fetchAll();
            return $filas;
        }

        /*
         * Metodo para obtener la informacion de una marca
         * Params Integer @id_mar recibe el id de una marca
         * Return Array con la información de la marca
         */
        function readOne($id_mar)
        {
            $dbh = $this->connect();
            $sentencia ='SELECT * FROM marca WHERE id_marca = :id_marca';
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindParam(':id_marca', $id_mar, PDO::PARAM_INT);
            $stmt -> execute();
            $filas = $stmt -> fetchAll();
            return $filas;
        }

        /*
         * Metodo para actualizar el registro de una marca
         * Params Integer @id_mar recibe el id de una marca
         *        String  @mar recibe la marca
         * Return Arreglo con informacion de exito al momento de hacer la operación
         */
        function update($id_mar, $mar)
        {
            $dbh = $this -> connect();
            try {
                $foto = $this -> guardarFotografia();
                if($foto){
                    $sentencia = "UPDATE marca SET marca = :marca, fotografia = :fotografia WHERE id_marca = :id_marca";
                    $stmt = $dbh -> prepare($sentencia);
                    $stmt -> bindParam(":fotografia", $foto, PDO::PARAM_STR);
                }
                else{
                    $sentencia = "UPDATE marca SET marca = :marca WHERE id_marca = :id_marca";
                    $stmt = $dbh -> prepare($sentencia);
                }
                $stmt -> bindParam(':id_marca', $id_mar, PDO::PARAM_INT);
                $stmt -> bindParam(':marca', $mar, PDO::PARAM_STR);
                $stmt -> execute();
                $msg['msg'] = 'Marca actualizada correctamente.';
                $msg['status'] = 'success';
                return $msg;
            } catch (Exception $e) {
                $msg['msg'] = 'Error al actualizar, la marca ya existe.';
                $msg['status'] = 'danger';
                return $msg;
            }
        }

        /*
         * Metodo para elimina el registro de una marca
         * Params Integer @id_mar recibe el id de una marca
         * Return Arreglo con informacion de exito al momento de hacer la operación
         */
        function delete($id_mar)
        {
            $dbh = $this -> connect();
            try {
                $sentencia = 'DELETE FROM marca WHERE id_marca = :id_marca';
                $stmt= $dbh -> prepare($sentencia);
                $stmt -> bindParam(':id_marca', $id_mar, PDO::PARAM_INT);
                $stmt -> execute();
                $msg['msg'] = 'Marca eliminada correctamente.';
                $msg['status'] = 'success';
                return $msg;
            } catch (Exception $e) {
                $msg['msg'] = 'Error al eliminar, la marca tiene productos asignados.';
                $msg['status'] = 'danger';
                return $msg;
            }
        }

      /*
       * Método para subir una imagen de una marca
       * Return Booleano señalando si la imagen es valida de acuerdo al formato o no
       */
        function guardarFotografia()
        {
            $archivo = $_FILES['fotografia'];
            $tipos = array('image/jpeg', 'image/png', 'image/gif');
            if ($archivo['error'] == 0) {
                if ($archivo['size'] <= 2097152) {
                    $a = explode('/', $archivo['type']);
                    $nueva_imagen = MD5(time()) . '.' . $a[1];
                    if (move_uploaded_file($archivo['tmp_name'], '../archivos/' . $nueva_imagen)) {
                        return $nueva_imagen;
                    }
                }
            }
        }

      /*
       * Método para extrater total de marcas
       * Return un entero que es la cantidad de marcas
       */
        function total(){
            $dbh = $this -> Connect();
            $sentencia = "SELECT COUNT(id_marca) AS total FROM marca";
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> execute();
            $rows = $stmt -> fetchAll();
            return $rows[0]['total'];
        }
    }
?>