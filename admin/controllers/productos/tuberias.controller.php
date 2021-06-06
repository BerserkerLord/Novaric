<?php
    include("productos.controller.php");
    class Tuberia extends Producto{
        function createTuberia($cod_pro, $pro, $cos, $desc, $exis, $id_mar, $id_uni, $d, $l, $id_ext1, $id_ext2)
        {
            $dbh = $this -> connect();
            $dbh -> beginTransaction();
            try {
                $this -> createProducto($cod_pro, $pro, $cos, $desc, $exis, $id_mar, $id_uni) -> execute();
                $sentencia = "INSERT INTO tuberia(codigo_producto, diametro, longitud, id_extremidad1, id_extremidad2)
                                        VALUES(:codigo_producto, :diametro, :longitud, :id_extremidad1, :id_extremidad2)";
                $stmt = $dbh->prepare($sentencia);
                $stmt -> bindParam(':codigo_producto', $cod_pro, PDO::PARAM_STR);
                $stmt -> bindParam(':diametro', $d, PDO::PARAM_STR);
                $stmt -> bindParam(':longitud', $l, PDO::PARAM_STR);
                $stmt -> bindParam(':id_extremidad1', $id_ext1, PDO::PARAM_INT);
                $stmt -> bindParam(':id_extremidad2', $id_ext2, PDO::PARAM_INT);
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

        function readTuberia(){
            $sentencia = 'SELECT codigo_producto, producto, costo, precio, precio_publico, descripcion, existencias, p.fotografia,
                                 id_marca, marca, id_unidad, unidad, diametro, longitud, extremidad1.extremidad AS extremidad1, extremidad2.extremidad AS extremidad2 FROM producto p 
                              INNER JOIN tuberia t USING(codigo_producto) 
                              INNER JOIN marca USING(id_marca)
                              INNER JOIN unidad USING(id_unidad)
                              INNER JOIN extremidad AS extremidad1 ON t.id_extremidad1 = extremidad1.id_extremidad
                              INNER JOIN extremidad AS extremidad2 ON t.id_extremidad2 = extremidad2.id_extremidad
                          WHERE p.producto LIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
            return $this -> read($sentencia, 'p.productos');
        }

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
                $stmt->bindParam(':diametro', $d, PDO::PARAM_STR);
                $stmt->bindParam(':longitud', $l, PDO::PARAM_STR);
                $stmt->bindParam(':id_extremidad1', $id_ext1, PDO::PARAM_INT);
                $stmt->bindParam(':id_extremidad2', $id_ext2, PDO::PARAM_INT);
                $stmt->bindParam(':codigo_producto', $cod_pro, PDO::PARAM_STR);
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