<?php
    include("productos.controller.php");
    class Conexion extends Producto{
        function createConexion($cod_pro, $pro, $cos, $desc, $exis, $id_mar, $id_uni, $d, $id_f, $id_ext1, $id_ext2)
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
                return $resultado;
            }
            catch(Exception $e){
                echo 'Excepción capturada: ',  $e->getMessage(), "\n";
                $dbh -> rollBack();
            }
            $dbh -> rollBack();
        }

        function readConexion(){
            $sentencia = 'SELECT codigo_producto, producto, costo, precio, precio_publico, descripcion, existencias, p.fotografia,
                                     id_marca, marca, unidad, id_unidad, diametro, forma_conexion, id_forma_conexion, extremidad1.extremidad AS extremidad1, extremidad2.extremidad AS extremidad2 FROM producto p 
                                  INNER JOIN conexion c USING(codigo_producto) 
                                  INNER JOIN marca USING(id_marca)
                                  INNER JOIN unidad USING(id_unidad)
                                  INNER JOIN extremidad AS extremidad1 ON c.id_extremidad1 = extremidad1.id_extremidad
                                  INNER JOIN extremidad AS extremidad2 ON c.id_extremidad2 = extremidad2.id_extremidad
                                  INNER JOIN forma_conexion USING(id_forma_conexion)
                              WHERE p.producto LIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
            return $this -> read($sentencia, 'p.productos');
        }

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

        function updateConexion($cod_pro, $pro, $cos, $desc, $id_mar, $id_uni, $d, $id_f, $id_ext1, $id_ext2)
        {
            $dbh = $this -> connect();
            $dbh -> beginTransaction();
            try{
                $this -> updateProducto($cod_pro, $pro, $cos, $desc, $id_mar, $id_uni) -> execute();
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