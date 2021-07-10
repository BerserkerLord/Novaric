<?php
    include("productos.controller.php");


    /*
     * Clase principal para conexiones
     */
    class Conexion extends Producto{

       /*
        * Método para insertar un registro de una conexión a la base de datos Novaric
        * Params String  @cod_pro recibe el codigo de la conexión
        *        String  @pro recibe el producto
        *        Double  @cos recibe el costo del producto
        *        String  @desc recibe la descripcion del producto
        *        Double  @exis recibe las existencias iniciales del producto
        *        Integer @id_mar recibe el id de la marca del producto
        *        Integer @id_uni recibe el id de la unidad del producto
        *        Double  @d recibe el diametro de la conexion
        *        Double  @id_f el id de la forma
        *        Integer @id_ext1 recibe la extremidad 1 de la conexion
        *        Integer @id_ext2 recibe la extremidad 2 de la conexion
        * Return Arreglo con informacion de exito al momento de hacer la operación
        */
        function createConexion($cod_pro, $pro, $cos, $desc, $exis, $id_mar, $id_uni, $d, $id_f, $id_ext1, $id_ext2){
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
                $sentencia = "INSERT INTO conexion(codigo_producto, diametro, id_forma_conexion, id_extremidad1, id_extremidad2)
                                            VALUES(:codigo_producto, :diametro, :id_forma_conexion, :id_extremidad1, :id_extremidad2)";
                $stmt = $dbh->prepare($sentencia);
                $stmt -> bindParam(':codigo_producto', $cod_pro, PDO::PARAM_STR);
                $stmt -> bindParam(':diametro', $d, PDO::PARAM_STR);
                $stmt -> bindParam(':id_forma_conexion', $id_f, PDO::PARAM_STR);
                $stmt -> bindParam(':id_extremidad1', $id_ext1, PDO::PARAM_INT);
                $stmt -> bindParam(':id_extremidad2', $id_ext2, PDO::PARAM_INT);
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
         * Metodo para obtener la informacion de una conexion
         * Params Integer @id_mar recibe el id de una conexion
         * Return Array con la información de la conexion
         */
        function readConexion(){
            switch($_SESSION['engine']){
                case 'mariadb':
                    $sentencia = 'SELECT codigo_producto, producto, costo, precio, precio_publico, descripcion, existencias, p.fotografia,
                                     id_marca, marca, unidad, id_unidad, diametro, forma_conexion, id_forma_conexion, extremidad1.extremidad AS extremidad1, extremidad2.extremidad AS extremidad2 FROM producto p
                                  INNER JOIN conexion c USING(codigo_producto)
                                  INNER JOIN marca USING(id_marca)
                                  INNER JOIN unidad USING(id_unidad)
                                  INNER JOIN extremidad AS extremidad1 ON c.id_extremidad1 = extremidad1.id_extremidad
                                  INNER JOIN extremidad AS extremidad2 ON c.id_extremidad2 = extremidad2.id_extremidad
                                  INNER JOIN forma_conexion USING(id_forma_conexion)
                              WHERE p.producto LIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
                    break;
                case 'postgresql':
                    $sentencia = 'SELECT codigo_producto, producto, costo, precio, precio_publico, descripcion, existencias, p.fotografia,
                                     id_marca, marca, unidad, id_unidad, diametro, forma_conexion, id_forma_conexion, extremidad1.extremidad AS extremidad1, extremidad2.extremidad AS extremidad2 FROM producto p
                                  INNER JOIN conexion c USING(codigo_producto)
                                  INNER JOIN marca USING(id_marca)
                                  INNER JOIN unidad USING(id_unidad)
                                  INNER JOIN extremidad AS extremidad1 ON c.id_extremidad1 = extremidad1.id_extremidad
                                  INNER JOIN extremidad AS extremidad2 ON c.id_extremidad2 = extremidad2.id_extremidad
                                  INNER JOIN forma_conexion USING(id_forma_conexion)
                              WHERE p.producto ILIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
                    break;
            }
            /*$sentencia = 'SELECT codigo_producto, producto, costo, precio, precio_publico, descripcion, existencias, p.fotografia,
                                     id_marca, marca, unidad, id_unidad, diametro, forma_conexion, id_forma_conexion, extremidad1.extremidad AS extremidad1, extremidad2.extremidad AS extremidad2 FROM producto p 
                                  INNER JOIN conexion c USING(codigo_producto) 
                                  INNER JOIN marca USING(id_marca)
                                  INNER JOIN unidad USING(id_unidad)
                                  INNER JOIN extremidad AS extremidad1 ON c.id_extremidad1 = extremidad1.id_extremidad
                                  INNER JOIN extremidad AS extremidad2 ON c.id_extremidad2 = extremidad2.id_extremidad
                                  INNER JOIN forma_conexion USING(id_forma_conexion)
                              WHERE p.producto LIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';*/
            return $this -> read($sentencia, 'p.productos');
        }

        /*
         * Metodo para obtener la informacion de una conexion
         * Params Integer @id_mar recibe el id de una conexion
         * Return Array con la información de la conexion
         */
        function readOneConexion($c_d){
            $sentencia = 'SELECT codigo_producto, producto, costo, precio, precio_publico, descripcion, existencias, p.fotografia,
                                     id_marca, marca, unidad, id_unidad, diametro, forma_conexion, id_forma_conexion, 
                                     extremidad1.extremidad AS extremidad1, extremidad2.extremidad AS extremidad2,
                                     id_extremidad1, id_extremidad2 FROM producto p 
                                  INNER JOIN conexion c USING(codigo_producto) 
                                  INNER JOIN marca USING(id_marca)
                                  INNER JOIN unidad USING(id_unidad)
                                  INNER JOIN extremidad AS extremidad1 ON c.id_extremidad1 = extremidad1.id_extremidad
                                  INNER JOIN extremidad AS extremidad2 ON c.id_extremidad2 = extremidad2.id_extremidad 
                                  INNER JOIN forma_conexion USING(id_forma_conexion)
                               WHERE codigo_producto = :codigo_producto';
            return $this -> readOne($sentencia, $c_d);
        }

        /*
         * Método para actualizar un registro de una conexion a la base de datos Novaric
         * Params String  @cod_pro recibe el codigo de la conexion
         *        String  @pro recibe el producto
         *        Double  @cos recibe el costo del producto
         *        String  @desc recibe la descripcion del producto
         *        Integer @id_mar recibe el id de la marca del producto
         *        Integer @id_uni recibe el id de la unidad del producto
         *        Double  @d recibe el diametro de la conexion
         *        Double  @id_f recibe el tipo de forma de la conexion
         *        Integer @id_ext1 recibe la extremidad 1 de la conexion
         *        Integer @id_ext2 recibe la extremidad 2 de la conexion
         * Return Arreglo con informacion de exito al momento de hacer la operación
         */
        function updateConexion($cod_pro, $pro, $cos, $desc, $id_mar, $id_uni, $d, $id_f, $id_ext1, $id_ext2)
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
                $sentencia = 'UPDATE conexion SET diametro = :diametro, id_forma_conexion = :id_forma_conexion, 
                                               id_extremidad1 = :id_extremidad1, id_extremidad2 = :id_extremidad2  
                               WHERE codigo_producto = :codigo_producto';
                $stmt = $dbh->prepare($sentencia);
                $stmt->bindParam(':diametro', $d, PDO::PARAM_STR);
                $stmt->bindParam(':id_forma_conexion', $id_f, PDO::PARAM_STR);
                $stmt->bindParam(':id_extremidad1', $id_ext1, PDO::PARAM_INT);
                $stmt->bindParam(':id_extremidad2', $id_ext2, PDO::PARAM_INT);
                $stmt->bindParam(':codigo_producto', $cod_pro, PDO::PARAM_STR);
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