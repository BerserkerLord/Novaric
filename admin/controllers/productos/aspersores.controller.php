<?php
    include("productos.controller.php");
    class Aspersor extends Producto
    {
        function createAspersor($cod_pro, $cmin, $cmax, $pmin, $pmax, $amin, $amax, $pro, $cos, $desc, $exis, $id_mar, $id_uni)
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
                $stmt = $dbh->prepare($sentencia);
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
                $sentencia = "INSERT INTO aspersor(codigo_producto, caudal_minimo, caudal_maximo, presion_minima, presion_maxima, alcance_minimo, alcance_maximo)
                                            VALUES(:codigo_producto, :caudal_minimo, :caudal_maximo, :presion_minima, :presion_maxima, :alcance_minimo, :alcance_maximo)";
                $stmt = $dbh->prepare($sentencia);
                $stmt -> bindParam(':codigo_producto', $cod_pro, PDO::PARAM_STR);
                $stmt -> bindParam(':caudal_minimo', $cmin, PDO::PARAM_STR);
                $stmt -> bindParam(':caudal_maximo', $cmax, PDO::PARAM_STR);
                $stmt -> bindParam(':presion_minima', $pmin, PDO::PARAM_STR);
                $stmt -> bindParam(':presion_maxima', $pmax, PDO::PARAM_STR);
                $stmt -> bindParam(':alcance_minimo', $amin, PDO::PARAM_STR);
                $stmt -> bindParam(':alcance_maximo', $amax, PDO::PARAM_STR);
                $resultado = $stmt -> execute();
                $dbh -> commit();
                return $resultado;
            }
            catch(Exception $e){
                echo 'Excepción capturada: ',  $e->getMessage(), "\n";
                $dbh -> rollBack();
            }
            $dbh -> rollBack();2
        }

        function readAspersor(){
            $sentencia = 'SELECT id_unidad, id_marca, codigo_producto, producto, costo, precio, precio_publico, descripcion, existencias, p.fotografia,
                                 marca, unidad, caudal_minimo, caudal_maximo, presion_minima, presion_maxima, alcance_minimo, alcance_maximo FROM producto p 
                                  INNER JOIN aspersor USING(codigo_producto) 
                                  INNER JOIN marca USING(id_marca)
                                  INNER JOIN unidad USING(id_unidad)
                              WHERE p.producto LIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
            return $this -> read($sentencia, 'p.productos');
        }

        function readOneAspersor($c_d){
            $sentencia = 'SELECT id_unidad, id_marca, codigo_producto, producto, costo, precio, precio_publico, descripcion, existencias, p.fotografia,
                                 marca, unidad, caudal_minimo, caudal_maximo, presion_minima, presion_maxima, alcance_minimo, alcance_maximo FROM producto p
                                  INNER JOIN aspersor USING(codigo_producto) 
                                  INNER JOIN marca USING(id_marca)
                                  INNER JOIN unidad USING(id_unidad)
                              WHERE codigo_producto = :codigo_producto';
            return $this -> readOne($sentencia, $c_d);
        }

        function updateAspersor($cod_pro, $cmin, $cmax, $pmin, $pmax, $amin, $amax, $pro, $cos, $desc, $id_mar, $id_uni)
        {
            $dbh = $this -> connect();
            $dbh -> beginTransaction();
            try{
                $sentencia = 'UPDATE aspersor SET caudal_minimo = :caudal_minimo, caudal_maximo = :caudal_maximo, presion_minima = :presion_minima, 
                                        presion_maxima = :presion_maxima, alcance_minimo = :alcance_minimo, alcance_maximo = :alcance_maximo  
                              WHERE codigo_producto = :codigo_producto';
                $stmt = $dbh->prepare($sentencia);
                $stmt -> bindParam(':caudal_minimo', $cmin, PDO::PARAM_STR);
                $stmt -> bindParam(':caudal_maximo', $cmax, PDO::PARAM_STR);
                $stmt -> bindParam(':presion_minima', $pmin, PDO::PARAM_STR);
                $stmt -> bindParam(':presion_maxima', $pmax, PDO::PARAM_STR);
                $stmt -> bindParam(':alcance_minimo', $amin, PDO::PARAM_STR);
                $stmt -> bindParam(':alcance_maximo', $amax, PDO::PARAM_STR);
                $stmt -> bindParam(':codigo_producto', $cod_pro, PDO::PARAM_STR);
                $resultado = $stmt -> execute();
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
                $dbh -> commit();
                return $resultado;
            }
            catch(Exception $e){
                echo 'Excepción capturada: ',  $e -> getMessage(), "\n";
                $dbh -> rollBack();
            }
            $dbh -> rollBack();
        }

        function calcularPrecio($cos){ return $cos * 1.7; }
        function calcularPrecioPublico($pre){ return $pre; }
    }
?>