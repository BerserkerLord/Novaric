<?php
    include("productos.controller.php");

    class Miscelaneo extends Producto
    {
        /*
         * Método para insertar un registro de un miscelaneo a la base de datos Novaric
         * Params String  @cod_pro recibe el codigo de la miscelaneo
         *        String  @pro recibe el producto
         *        Double  @cos recibe el costo del producto
         *        String  @desc recibe la descripcion del producto
         *        Double  @exis recibe las existencias iniciales del producto
         *        Integer @id_mar recibe el id de la marca del producto
         *        Integer @id_uni recibe el id de la unidad del producto
         * Return Arreglo con informacion de exito al momento de hacer la operación
         */
        function createMiscelaneo($cod_pro, $pro, $cos, $desc, $exis, $id_mar, $id_uni)
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
                $sentencia = "INSERT INTO miscelaneo(codigo_producto) VALUES(:codigo_producto)";
                $stmt = $dbh -> prepare($sentencia);
                $stmt -> bindParam(':codigo_producto', $cod_pro, PDO::PARAM_STR);
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
         * Método para obtener todos los miscelaneos por cantidad
         * Return Array con todas los miscelaneos
         */
        function readMiscelaneo(){
            switch($_SESSION['engine']){
                case 'mariadb':
                    $sentencia = 'SELECT id_unidad, id_marca, codigo_producto, producto, costo, precio, precio_publico, descripcion, existencias, p.fotografia,
                                 marca, unidad FROM producto p
                                  INNER JOIN miscelaneo m USING(codigo_producto)
                                  INNER JOIN marca USING(id_marca)
                                  INNER JOIN unidad USING(id_unidad)
                              WHERE p.producto LIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
                    break;
                case 'postgresql':
                    $sentencia = 'SELECT id_unidad, id_marca, codigo_producto, producto, costo, precio, precio_publico, descripcion, existencias, p.fotografia,
                                 marca, unidad FROM producto p
                                  INNER JOIN miscelaneo m USING(codigo_producto)
                                  INNER JOIN marca USING(id_marca)
                                  INNER JOIN unidad USING(id_unidad)
                              WHERE p.producto ILIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
                    break;
            }
            /*$sentencia = 'SELECT id_unidad, id_marca, codigo_producto, producto, costo, precio, precio_publico, descripcion, existencias, p.fotografia,
                                 marca, unidad FROM producto p 
                                  INNER JOIN miscelaneo m USING(codigo_producto) 
                                  INNER JOIN marca USING(id_marca)
                                  INNER JOIN unidad USING(id_unidad)
                              WHERE p.producto LIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';*/
            return $this -> read($sentencia, 'p.productos');
        }

        /*
         * Metodo para obtener la informacion de un miscelaneo
         * Params Integer @id_mar recibe el id de un miscelaneo
         * Return Array con la información del miscelaneo
         */
        function readOneMiscelaneo($c_d){
            $sentencia = 'SELECT id_unidad, id_marca, codigo_producto, producto, costo, precio, precio_publico, descripcion, existencias, p.fotografia,
                                 marca, unidad FROM producto p 
                                  INNER JOIN miscelaneo m USING(codigo_producto) 
                                  INNER JOIN marca USING(id_marca)
                                  INNER JOIN unidad USING(id_unidad)
                               WHERE codigo_producto = :codigo_producto';
            return $this -> readOne($sentencia, $c_d);
        }

        /*
         * Método para actualizar un registro de un miscelaneo a la base de datos Novaric
         * Params String  @cod_pro recibe el codigo de la miscelaneo
         *        String  @pro recibe el producto
         *        Double  @cos recibe el costo del producto
         *        String  @desc recibe la descripcion del producto
         *        Integer @id_mar recibe el id de la marca del producto
         *        Integer @id_uni recibe el id de la unidad del producto
         * Return Arreglo con informacion de exito al momento de hacer la operación
         */
        function updateMiscelaneo($cod_pro, $pro, $cos, $desc, $id_mar, $id_uni)
        {
            $dbh = $this->connect();
            try {
                $pre = $this->calcularPrecio($cos);
                $pre_pub = $this->calcularPrecioPublico($pre);
                $foto = $this->guardarFotografia();
                if ($foto) {
                    $sentencia = 'UPDATE producto SET producto = :producto, costo = :costo, precio = :precio, precio_publico = :precio_publico, 
                                              descripcion = :descripcion, fotografia = :fotografia, 
                                              id_marca = :id_marca, id_unidad = :id_unidad 
                              WHERE codigo_producto = :codigo_producto';
                    $stmt = $dbh->prepare($sentencia);
                    $stmt->bindParam(':fotografia', $foto, PDO::PARAM_STR);
                } else {
                    $sentencia = 'UPDATE producto SET producto = :producto, costo = :costo, precio = :precio, precio_publico = :precio_publico, 
                              descripcion = :descripcion, id_marca = :id_marca, id_unidad = :id_unidad 
                              WHERE codigo_producto = :codigo_producto';
                    $stmt = $dbh->prepare($sentencia);
                }
                $stmt->bindParam(':producto', $pro, PDO::PARAM_STR);
                $stmt->bindParam(':costo', $cos, PDO::PARAM_STR);
                $stmt->bindParam(':precio', $pre, PDO::PARAM_STR);
                $stmt->bindParam(':precio_publico', $pre_pub, PDO::PARAM_STR);
                $stmt->bindParam(':descripcion', $desc, PDO::PARAM_STR);
                $stmt->bindParam(':id_unidad', $id_uni, PDO::PARAM_INT);
                $stmt->bindParam(':id_marca', $id_mar, PDO::PARAM_INT);
                $stmt->bindParam(':codigo_producto', $cod_pro, PDO::PARAM_STR);
                $stmt->execute();
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