<?php
    include("productos.controller.php");

    class Aspersor extends Producto
    {

        /*
         * Método para insertar un registro de una aspersor a la base de datos Novaric
         * Params String  @cod_pro recibe el codigo de la aspersor
         *        String  @pro recibe el producto
         *        Double  @cos recibe el costo del producto
         *        String  @desc recibe la descripcion del producto
         *        Double  @exis recibe las existencias iniciales del producto
         *        Integer @id_mar recibe el id de la marca del producto
         *        Integer @id_uni recibe el id de la unidad del producto
         *        Double  @cmin recibe el caudal minimo del aspersor
         *        Double  @cmax recibe el caudal máximi del aspersor
         *        Double  @pmin recibe la presión minima del aspersor
         *        Double  @pmax recibe la presión máxima del aspersor
         *        Double  @amin recibe el alcance mínimo del aspersor
         *        Double  @amax recibe el alcance máximo del aspersor
         * Return Arreglo con informacion de exito al momento de hacer la operación
         */
        function createAspersor($cod_pro, $pro, $cos, $desc, $exis, $id_mar, $id_uni, $cmin, $cmax, $pmin, $pmax, $amin, $amax)
        {
            $dbh = $this -> connect();
            $dbh -> beginTransaction();
            try {
                $pre = $this -> calcularPrecio($cos);
                $pre_pub = $this -> calcularPrecioPublico($pre);
                $foto = $this -> guardarFotografia();
                $sentencia = "INSERT INTO producto(codigo_producto, producto, costo, precio, precio_publico, descripcion, 
                                               existencias, fotografia, id_marca, id_unidad) 
                                        VALUES(:codigo_producto, :producto, :costo, :precio, :precio_publico, :descripcion, 
                                               :existencias, :fotografia, :id_marca, :id_unidad)";
                $stmt = $dbh -> prepare($sentencia);
                $stmt -> bindParam(':codigo_producto', $cod_pro, PDO::PARAM_STR);
                $stmt -> bindParam(':producto', $pro, PDO::PARAM_STR);
                $stmt -> bindParam(':costo', $cos, PDO::PARAM_STR);
                $stmt -> bindParam(':precio', $pre, PDO::PARAM_STR);
                $stmt -> bindParam(':precio_publico',$pre_pub, PDO::PARAM_STR);
                $stmt -> bindParam(':descripcion', $desc, PDO::PARAM_STR);
                $stmt -> bindParam(':existencias', $exis, PDO::PARAM_STR);
                $stmt -> bindParam(':fotografia', $foto, PDO::PARAM_STR);
                $stmt -> bindParam(':id_unidad', $id_uni, PDO::PARAM_INT);
                $stmt -> bindParam(':id_marca', $id_mar, PDO::PARAM_INT);
                $stmt -> execute();
                $sentencia = "INSERT INTO aspersor(codigo_producto, caudal_minimo, caudal_maximo, presion_minima, presion_maxima, alcance_minimo, alcance_maximo)
                                            VALUES(:codigo_producto, :caudal_minimo, :caudal_maximo, :presion_minima, :presion_maxima, :alcance_minimo, :alcance_maximo)";
                $stmt = $dbh -> prepare($sentencia);
                $stmt -> bindParam(':codigo_producto', $cod_pro, PDO::PARAM_STR);
                $stmt -> bindParam(':caudal_minimo', $cmin, PDO::PARAM_STR);
                $stmt -> bindParam(':caudal_maximo', $cmax, PDO::PARAM_STR);
                $stmt -> bindParam(':presion_minima', $pmin, PDO::PARAM_STR);
                $stmt -> bindParam(':presion_maxima', $pmax, PDO::PARAM_STR);
                $stmt -> bindParam(':alcance_minimo', $amin, PDO::PARAM_STR);
                $stmt -> bindParam(':alcance_maximo', $amax, PDO::PARAM_STR);
                $resultado = $stmt -> execute();
                $dbh -> commit();
                $msg['msg'] = 'Producto registrado correctamente.';
                $msg['status'] = 'success';
                return $msg;
            } catch (Exception $e) {
                $dbh -> rollBack();
                $msg['msg'] = 'Error al registrar, el código de producto ya existe.';
                $msg['status'] = 'danger';
                return $msg;
            }
        }

        /*
         * Método para obtener todos las aspersores
         * Return Array con todas las aspersores
         */
        function readAspersor(){
            switch($_SESSION['engine']){
                case 'mariadb':
                    $sentencia = 'SELECT id_unidad, id_marca, codigo_producto, producto, costo, precio, precio_publico, descripcion, existencias, p.fotografia,
                                 marca, unidad, caudal_minimo, caudal_maximo, presion_minima, presion_maxima, alcance_minimo, alcance_maximo FROM producto p
                                  INNER JOIN aspersor USING(codigo_producto)
                                  INNER JOIN marca USING(id_marca)
                                  INNER JOIN unidad USING(id_unidad)
                              WHERE p.producto LIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
                    break;
                case 'postgresql':
                    $sentencia = 'SELECT id_unidad, id_marca, codigo_producto, producto, costo, precio, precio_publico, descripcion, existencias, p.fotografia,
                                 marca, unidad, caudal_minimo, caudal_maximo, presion_minima, presion_maxima, alcance_minimo, alcance_maximo FROM producto p
                                  INNER JOIN aspersor USING(codigo_producto)
                                  INNER JOIN marca USING(id_marca)
                                  INNER JOIN unidad USING(id_unidad)
                              WHERE p.producto ILIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
                    break;
            }
            /*$sentencia = 'SELECT id_unidad, id_marca, codigo_producto, producto, costo, precio, precio_publico, descripcion, existencias, p.fotografia,
                                 marca, unidad, caudal_minimo, caudal_maximo, presion_minima, presion_maxima, alcance_minimo, alcance_maximo FROM producto p 
                                  INNER JOIN aspersor USING(codigo_producto) 
                                  INNER JOIN marca USING(id_marca)
                                  INNER JOIN unidad USING(id_unidad)
                              WHERE p.producto LIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';*/
            return $this -> read($sentencia, 'p.productos');
        }

        /*
         * Metodo para obtener la informacion de una aspersor
         * Params Integer @id_mar recibe el id de una aspersor
         * Return Array con la información de la aspersor
         */
        function readOneAspersor($c_d){
            $sentencia = 'SELECT id_unidad, id_marca, codigo_producto, producto, costo, precio, precio_publico, descripcion, existencias, p.fotografia,
                                 marca, unidad, caudal_minimo, caudal_maximo, presion_minima, presion_maxima, alcance_minimo, alcance_maximo FROM producto p
                                  INNER JOIN aspersor USING(codigo_producto) 
                                  INNER JOIN marca USING(id_marca)
                                  INNER JOIN unidad USING(id_unidad)
                              WHERE codigo_producto = :codigo_producto';
            return $this -> readOne($sentencia, $c_d);
        }

        /*
         * Método para actualizar un registro de una aspersor a la base de datos Novaric
         * Params String  @cod_pro recibe el codigo de la aspersor
         *        String  @pro recibe el producto
         *        Double  @cos recibe el costo del producto
         *        String  @desc recibe la descripcion del producto
         *        Integer @id_mar recibe el id de la marca del producto
         *        Integer @id_uni recibe el id de la unidad del producto
         *        Double  @cmin recibe el caudal minimo del aspersor
         *        Double  @cmax recibe el caudal máximi del aspersor
         *        Double  @pmin recibe la presión minima del aspersor
         *        Double  @pmax recibe la presión máxima del aspersor
         *        Double  @amin recibe el alcance mínimo del aspersor
         *        Double  @amax recibe el alcance máximo del aspersor
         * Return Arreglo con informacion de exito al momento de hacer la operación
         */
        function updateAspersor($cod_pro, $cmin, $cmax, $pmin, $pmax, $amin, $amax, $pro, $cos, $desc, $id_mar, $id_uni)
        {
            $dbh = $this -> connect();
            $dbh -> beginTransaction();
            try{
                $pre = $this -> calcularPrecio($cos);
                $pre_pub = $this -> calcularPrecioPublico($pre);
                $foto = $this -> guardarFotografia();
                if($foto){
                    $sentencia = 'UPDATE producto SET producto = :producto, costo = :costo, precio = :precio, precio_publico = :precio_publico, 
                                              descripcion = :descripcion, fotografia = :fotografia, 
                                              id_marca = :id_marca, id_unidad = :id_unidad 
                              WHERE codigo_producto = :codigo_producto';
                    $stmt = $dbh -> prepare($sentencia);
                    $stmt -> bindParam(':fotografia', $foto, PDO::PARAM_STR);
                }
                else{
                    $sentencia = 'UPDATE producto SET producto = :producto, costo = :costo, precio = :precio, precio_publico = :precio_publico, 
                              descripcion = :descripcion, id_marca = :id_marca, id_unidad = :id_unidad 
                              WHERE codigo_producto = :codigo_producto';
                    $stmt = $dbh -> prepare($sentencia);
                }
                $stmt -> bindParam(':producto', $pro, PDO::PARAM_STR);
                $stmt -> bindParam(':costo', $cos, PDO::PARAM_STR);
                $stmt -> bindParam(':precio', $pre, PDO::PARAM_STR);
                $stmt -> bindParam(':precio_publico',$pre_pub, PDO::PARAM_STR);
                $stmt -> bindParam(':descripcion', $desc, PDO::PARAM_STR);
                $stmt -> bindParam(':id_unidad', $id_uni, PDO::PARAM_INT);
                $stmt -> bindParam(':id_marca', $id_mar, PDO::PARAM_INT);
                $stmt -> bindParam(':codigo_producto', $cod_pro, PDO::PARAM_STR);
                $resultado = $stmt -> execute();
                $sentencia = 'UPDATE aspersor SET caudal_minimo = :caudal_minimo, caudal_maximo = :caudal_maximo, presion_minima = :presion_minima, 
                                        presion_maxima = :presion_maxima, alcance_minimo = :alcance_minimo, alcance_maximo = :alcance_maximo  
                              WHERE codigo_producto = :codigo_producto';
                $stmt = $dbh -> prepare($sentencia);
                $stmt -> bindParam(':caudal_minimo', $cmin, PDO::PARAM_STR);
                $stmt -> bindParam(':caudal_maximo', $cmax, PDO::PARAM_STR);
                $stmt -> bindParam(':presion_minima', $pmin, PDO::PARAM_STR);
                $stmt -> bindParam(':presion_maxima', $pmax, PDO::PARAM_STR);
                $stmt -> bindParam(':alcance_minimo', $amin, PDO::PARAM_STR);
                $stmt -> bindParam(':alcance_maximo', $amax, PDO::PARAM_STR);
                $stmt -> bindParam(':codigo_producto', $cod_pro, PDO::PARAM_STR);
                $resultado = $stmt -> execute();
                $dbh -> commit();
                $msg['msg'] = 'Producto actualizado correctamente.';
                $msg['status'] = 'success';
                return $msg;
            } catch (Exception $e) {
                $dbh -> rollBack();
                $msg['msg'] = 'Error al actualizar, el código de producto ya existe.';
                $msg['status'] = 'danger';
                return $msg;
            }
        }
    }
?>