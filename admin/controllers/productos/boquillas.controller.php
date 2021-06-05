<?php
    include("productos.controller.php");
    class Boquilla extends Producto{
        function createBoquilla($cod_pro, $pro, $cos, $desc, $exis, $id_mar, $id_uni, $cmin, $cmax, $pmin, $pmax, $rmin, $rmax, $tra, $ajus, $id_t_b, $id_f_a)
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
                $stmt -> bindParam(':id_marca', $id_mar, PDO::PARAM_INT);
                $stmt -> bindParam(':id_unidad', $id_uni, PDO::PARAM_INT);
                $resultado = $stmt -> execute();
                $sentencia = "INSERT INTO boquilla(codigo_producto, caudal_minimo, caudal_maximo, presion_minima, presion_maxima, 
                                                radio_minimo, radio_maximo, trayectoria, ajuste, id_tipo_boquilla, id_forma_aspersion)
                                         VALUES(:codigo_producto, :caudal_minimo, :caudal_maximo, :presion_minima, :presion_maxima, 
                                                :radio_minimo, :radio_maximo, :trayectoria, :ajuste, :id_tipo_boquilla, :id_forma_aspersion)";
                $stmt = $dbh -> prepare($sentencia);
                $stmt -> bindParam(':codigo_producto', $cod_pro, PDO::PARAM_STR);
                $stmt -> bindParam(':caudal_minimo', $cmin, PDO::PARAM_STR);
                $stmt -> bindParam(':caudal_maximo', $cmax, PDO::PARAM_STR);
                $stmt -> bindParam(':presion_minima', $pmin, PDO::PARAM_STR);
                $stmt -> bindParam(':presion_maxima', $pmax, PDO::PARAM_STR);
                $stmt -> bindParam(':radio_minimo', $rmin, PDO::PARAM_STR);
                $stmt -> bindParam(':radio_maximo', $rmax, PDO::PARAM_STR);
                $stmt -> bindParam(':trayectoria', $tra, PDO::PARAM_INT);
                $stmt -> bindParam(':ajuste', $ajus, PDO::PARAM_STR);
                $stmt -> bindParam(':id_tipo_boquilla', $id_t_b, PDO::PARAM_INT);
                $stmt -> bindParam(':id_forma_aspersion', $id_f_a, PDO::PARAM_INT);
                $resultado = $stmt -> execute();
                $dbh -> commit();
                return $resultado;
            }
            catch(Exception $e){
                echo 'Excepción capturada: ',  $e->getMessage(), "\n";
                $dbh -> rollBack();
            }
            $dbh -> rollBack();
        }

        function readBoquilla(){
            $sentencia = 'SELECT id_unidad, id_marca, codigo_producto, producto, costo, precio, precio_publico, descripcion, existencias, p.fotografia,
                                 marca, unidad, id_tipo_boquilla, id_forma_aspersion, caudal_minimo, caudal_maximo, presion_minima, presion_maxima, radio_minimo, radio_maximo,
                                 trayectoria, ajuste, forma_aspersion, tipo_boquilla FROM producto p  
                                      INNER JOIN boquilla USING(codigo_producto) 
                                      INNER JOIN marca USING(id_marca)
                                      INNER JOIN unidad USING(id_unidad)
                                      INNER JOIN forma_aspersion USING(id_forma_aspersion)
                                      INNER JOIN tipo_boquilla USING(id_tipo_boquilla)
                                  WHERE p.producto LIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
            return $this -> read($sentencia, 'p.productos');
        }

        function readOneBoquilla($c_d){
            $sentencia = 'SELECT id_unidad, id_marca, codigo_producto, producto, costo, precio, precio_publico, descripcion, existencias, p.fotografia,
                                 marca, unidad, id_tipo_boquilla, id_forma_aspersion, caudal_minimo, caudal_maximo, presion_minima, presion_maxima, radio_minimo, radio_maximo,
                                 trayectoria, ajuste, forma_aspersion, tipo_boquilla FROM producto p
                                      INNER JOIN boquilla USING(codigo_producto) 
                                      INNER JOIN marca USING(id_marca)
                                      INNER JOIN unidad USING(id_unidad)
                                      INNER JOIN forma_aspersion USING(id_forma_aspersion)
                                      INNER JOIN tipo_boquilla USING(id_tipo_boquilla)
                                  WHERE codigo_producto = :codigo_producto';
            return $this -> readOne($sentencia, $c_d);
        }

        function updateBoquilla($cod_pro, $pro, $cos, $desc, $exis, $id_mar, $id_uni, $cmin, $cmax, $pmin, $pmax, $rmin, $rmax, $tra, $ajus, $id_t_b, $id_f_a)
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
                $sentencia = 'UPDATE boquilla SET caudal_minimo = :caudal_minimo, caudal_maximo = :caudal_maximo, 
                                               presion_minima = :presion_minima,presion_maxima = :presion_maxima, 
                                               radio_minimo = :radio_minimo, radio_maximo = :radio_maximo,
                                               trayectoria = :trayectoria, ajuste = :ajuste, 
                                               id_tipo_boquilla = :id_tipo_boquilla, id_forma_aspersion = :id_forma_aspersion 
                           WHERE codigo_producto = :codigo_producto';
                $stmt = $dbh->prepare($sentencia);
                $stmt -> bindParam(':caudal_minimo', $cmin, PDO::PARAM_STR);
                $stmt -> bindParam(':caudal_maximo', $cmax, PDO::PARAM_STR);
                $stmt -> bindParam(':presion_minima', $pmin, PDO::PARAM_STR);
                $stmt -> bindParam(':presion_maxima', $pmax, PDO::PARAM_STR);
                $stmt -> bindParam(':radio_minimo', $rmin, PDO::PARAM_STR);
                $stmt -> bindParam(':radio_maximo', $rmax, PDO::PARAM_STR);
                $stmt -> bindParam(':trayectoria', $tra, PDO::PARAM_INT);
                $stmt -> bindParam(':ajuste', $ajus, PDO::PARAM_STR);
                $stmt -> bindParam(':id_tipo_boquilla', $id_t_b, PDO::PARAM_INT);
                $stmt -> bindParam(':id_forma_aspersion', $id_f_a, PDO::PARAM_INT);
                $stmt -> bindParam(':codigo_producto', $cod_pro, PDO::PARAM_STR);
                $resultado = $stmt -> execute();
                $dbh -> commit();
                return $resultado;
            }
            catch(Exception $e){
                echo 'Excepción capturada: ',  $e -> getMessage(), "\n";
                $dbh -> rollBack();
            }
            $dbh -> rollBack();
        }
    }
?>