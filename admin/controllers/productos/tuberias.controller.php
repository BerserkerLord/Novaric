<?php
    include("productos.controller.php");
    use Upload\File;
    use Upload\Storage\FileSystem;
    use Upload\Validation\Size;
    use Upload\Validation\Mimetype;
    use Upload\Exception\UploadException;

    /*
     * Clase principal para tuberias
     */
    class Tuberia extends Producto{
        /*
         * Método para insertar un registro de una tuberia a la base de datos Novaric
         * Params String  @cod_pro recibe el codigo de la tuberia
         *        String  @pro recibe el producto
         *        Double  @cos recibe el costo del producto
         *        String  @desc recibe la descripcion del producto
         *        Double  @exis recibe las existencias iniciales del producto
         *        Integer @id_mar recibe el id de la marca del producto
         *        Integer @id_uni recibe el id de la unidad del producto
         *        Double  @d recibe el diametro de la tuberia
         *        Double  @l recibe la longitud de la tuberia
         *        Integer @id_ext1 recibe la extremidad 1 de la tuberia
         *        Integer @id_ext2 recibe la extremidad 2 de la tuberia
         * Return Arreglo con informacion de exito al momento de hacer la operación
         */
        function createTuberia($cod_pro, $pro, $cos, $desc, $exis, $id_mar, $id_uni, $d, $l, $id_ext1, $id_ext2)
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
                $sentencia = "INSERT INTO tuberia(codigo_producto, diametro, longitud, id_extremidad1, id_extremidad2)
                                        VALUES(:codigo_producto, :diametro, :longitud, :id_extremidad1, :id_extremidad2)";
                $stmt = $dbh -> prepare($sentencia);
                $stmt -> bindParam(':codigo_producto', $cod_pro, PDO::PARAM_STR);
                $stmt -> bindParam(':diametro', $d, PDO::PARAM_STR);
                $stmt -> bindParam(':longitud', $l, PDO::PARAM_STR);
                $stmt -> bindParam(':id_extremidad1', $id_ext1, PDO::PARAM_INT);
                $stmt -> bindParam(':id_extremidad2', $id_ext2, PDO::PARAM_INT);
                $stmt -> execute();
                $dbh -> commit();
                $msg['msg'] = 'Producto registrado correctamente.';
                $msg['status'] = 'success';
                return $msg;
            } catch (Exception $e) {
                $msg['msg'] = 'Error al registrar, el código de producto ya existe.';
                $msg['status'] = 'danger';
                return $msg;
            }
        }

        /*
         * Método para obtener todos las tuberias
         * Return Array con todas las tuberias
         */
        function readTuberia(){
            switch($_SESSION['engine']){
                case 'mariadb':
                    $sentencia = 'SELECT codigo_producto, producto, costo, precio, precio_publico, descripcion, existencias, p.fotografia,
                                 id_marca, marca, id_unidad, unidad, diametro, longitud, extremidad1.extremidad AS extremidad1, extremidad2.extremidad AS extremidad2 FROM producto p
                                    INNER JOIN tuberia t USING(codigo_producto)
                                    INNER JOIN marca m USING(id_marca)
                                    INNER JOIN unidad USING(id_unidad)
                                    INNER JOIN extremidad AS extremidad1 ON t.id_extremidad1 = extremidad1.id_extremidad
                                    INNER JOIN extremidad AS extremidad2 ON t.id_extremidad2 = extremidad2.id_extremidad
                                 WHERE p.producto LIKE :busqueda ORDER BY :ordenamiento ASC LIMIT :limite OFFSET :desde';
                    break;
                case 'postgresql':
                    $sentencia = 'SELECT codigo_producto, producto, costo, precio, precio_publico, descripcion, existencias, p.fotografia,
                                 id_marca, marca, id_unidad, unidad, diametro, longitud, extremidad1.extremidad AS extremidad1, extremidad2.extremidad AS extremidad2 FROM producto p
                                    INNER JOIN tuberia t USING(codigo_producto)
                                    INNER JOIN marca USING(id_marca)
                                    INNER JOIN unidad USING(id_unidad)
                                    INNER JOIN extremidad AS extremidad1 ON t.id_extremidad1 = extremidad1.id_extremidad
                                    INNER JOIN extremidad AS extremidad2 ON t.id_extremidad2 = extremidad2.id_extremidad
                                 WHERE p.producto ILIKE :busqueda ORDER BY :ordenamiento ASC LIMIT :limite OFFSET :desde';
                    break;
            }
            /*$sentencia = 'SELECT codigo_producto, producto, costo, precio, precio_publico, descripcion, existencias, p.fotografia,
                                 id_marca, marca, id_unidad, unidad, diametro, longitud, extremidad1.extremidad AS extremidad1, extremidad2.extremidad AS extremidad2 FROM producto p 
                              INNER JOIN tuberia t USING(codigo_producto) 
                              INNER JOIN marca USING(id_marca)
                              INNER JOIN unidad USING(id_unidad)
                              INNER JOIN extremidad AS extremidad1 ON t.id_extremidad1 = extremidad1.id_extremidad
                              INNER JOIN extremidad AS extremidad2 ON t.id_extremidad2 = extremidad2.id_extremidad
                          WHERE p.producto LIKE :busqueda ORDER BY :ordenamiento ASC LIMIT :limite OFFSET :desde';*/
            return $this -> read($sentencia, 'p.codigo_producto');
        }

        /*
         * Metodo para obtener la informacion de una tuberia
         * Params Integer @id_mar recibe el id de una tuberia
         * Return Array con la información de la tuberia
         */
        function readOneTuberia($c_d){
            $sentencia = 'SELECT codigo_producto, producto, costo, precio, precio_publico, descripcion, existencias, p.fotografia,
                                 id_marca, marca, id_unidad, unidad, diametro, longitud, extremidad1.extremidad AS extremidad1, extremidad2.extremidad AS extremidad2,
                                 id_extremidad1, id_extremidad2 FROM producto p 
                              INNER JOIN tuberia t USING(codigo_producto) 
                              INNER JOIN marca USING(id_marca)
                              INNER JOIN unidad USING(id_unidad)
                              INNER JOIN extremidad AS extremidad1 ON t.id_extremidad1 = extremidad1.id_extremidad
                              INNER JOIN extremidad AS extremidad2 ON t.id_extremidad2 = extremidad2.id_extremidad 
                           WHERE codigo_producto = :codigo_producto';
            return $this -> readOne($sentencia, $c_d);
        }

        /*
         * Método para actualizar un registro de una tuberia a la base de datos Novaric
         * Params String  @cod_pro recibe el codigo de la tuberia
         *        String  @pro recibe el producto
         *        Double  @cos recibe el costo del producto
         *        String  @desc recibe la descripcion del producto
         *        Integer @id_mar recibe el id de la marca del producto
         *        Integer @id_uni recibe el id de la unidad del producto
         *        Double  @d recibe el diametro de la tuberia
         *        Double  @l recibe la longitud de la tuberia
         *        Integer @id_ext1 recibe la extremidad 1 de la tuberia
         *        Integer @id_ext2 recibe la extremidad 2 de la tuberia
         * Return Arreglo con informacion de exito al momento de hacer la operación
         */
        function updateTuberia($cod_pro, $pro, $cos, $desc, $id_mar, $id_uni, $d, $l, $id_ext1, $id_ext2)
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
                $sentencia = 'UPDATE tuberia SET diametro = :diametro, longitud = :longitud, id_extremidad1 = :id_extremidad1, id_extremidad2 = :id_extremidad2  
                           WHERE codigo_producto = :codigo_producto';
                $stmt = $dbh->prepare($sentencia);
                $stmt -> bindParam(':diametro', $d, PDO::PARAM_STR);
                $stmt -> bindParam(':longitud', $l, PDO::PARAM_STR);
                $stmt -> bindParam(':id_extremidad1', $id_ext1, PDO::PARAM_INT);
                $stmt -> bindParam(':id_extremidad2', $id_ext2, PDO::PARAM_INT);
                $stmt -> bindParam(':codigo_producto', $cod_pro, PDO::PARAM_STR);
                $stmt -> execute();
                $dbh -> commit();
                $msg['msg'] = 'Producto actualizado correctamente.';
                $msg['status'] = 'success';
                return $msg;
            } catch (Exception $e) {
                $msg['msg'] = 'Error al actualizar, el código de producto ya existe.';
                $msg['status'] = 'danger';
                return $msg;
            }
        }
    }
?>