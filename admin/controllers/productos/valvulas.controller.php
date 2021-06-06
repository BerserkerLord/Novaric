<?php
    include("productos.controller.php");
    class Valvula extends Producto
    {
        function createValvula($cod_pro, $pro, $cos, $desc, $exis, $id_mar, $id_uni, $tn, $camin, $camax, $pminr, $pmaxr, $es)
        {
            $dbh = $this -> connect();
            $dbh -> beginTransaction();
            try {
                $this -> createProducto($cod_pro, $pro, $cos, $desc, $exis, $id_mar, $id_uni) -> execute();
                $sentencia = "INSERT INTO valvula(codigo_producto, temperatura_nominal, caudal_minimo, caudal_maximo, presion_minima_recomendada,
                                               presion_maxima_recomendada, especificacion_solenoide)
                                        VALUES(:codigo_producto, :temperatura_nominal, :caudal_minimo, :caudal_maximo, :presion_minima_recomendada,
                                               :presion_maxima_recomendada, :especificacion_solenoide)";
                $stmt = $dbh->prepare($sentencia);
                $stmt -> bindParam(':codigo_producto', $cod_pro, PDO::PARAM_STR);
                $stmt -> bindParam(':temperatura_nominal', $tn, PDO::PARAM_STR);
                $stmt -> bindParam(':caudal_minimo', $camin, PDO::PARAM_STR);
                $stmt -> bindParam(':caudal_maximo', $camax, PDO::PARAM_STR);
                $stmt -> bindParam(':presion_minima_recomendada', $pminr, PDO::PARAM_STR);
                $stmt -> bindParam(':presion_maxima_recomendada', $pmaxr, PDO::PARAM_STR);
                $stmt -> bindParam(':especificacion_solenoide', $es, PDO::PARAM_STR);
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

        function readValvula(){
            $sentencia = 'SELECT codigo_producto, producto, costo, precio, precio_publico, descripcion, existencias, p.fotografia,
                                     marca, unidad, codigo_producto, temperatura_nominal, caudal_minimo, caudal_maximo, presion_minima_recomendada,
                                     presion_maxima_recomendada, especificacion_solenoide FROM producto p 
                                  INNER JOIN valvula USING(codigo_producto) 
                                  INNER JOIN marca USING(id_marca)
                                  INNER JOIN unidad USING(id_unidad)
                          WHERE p.producto LIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
            return $this -> read($sentencia, 'p.productos');
        }

        function readOneValvula($c_d){
            $sentencia = 'SELECT codigo_producto, producto, costo, precio, precio_publico, descripcion, existencias, p.fotografia,
                                     marca, unidad, codigo_producto, temperatura_nominal, caudal_minimo, caudal_maximo, presion_minima_recomendada,
                                     presion_maxima_recomendada, especificacion_solenoide FROM producto p 
                                  INNER JOIN valvula USING(codigo_producto) 
                                  INNER JOIN marca USING(id_marca)
                                  INNER JOIN unidad USING(id_unidad)
                          WHERE codigo_producto = :codigo_producto';
            return $this -> readOne($sentencia, $c_d);
        }

        function updateValvula($cod_pro, $pro, $cos, $desc, $id_mar, $id_uni, $tn, $camin, $camax, $pminr, $pmaxr, $es)
        {
            $dbh = $this -> connect();
            $dbh -> beginTransaction();
            try{
                $this -> updateProducto($cod_pro, $pro, $cos, $desc, $id_mar, $id_uni) -> execute();
                $sentencia = 'UPDATE valvula SET temperatura_nominal = :temperatura_nominal, caudal_minimo = :caudal_minimo, caudal_maximo = :caudal_maximo, 
                                              presion_minima_recomendada = :presion_minima_recomendada, presion_maxima_recomendada = :presion_maxima_recomendada, especificacion_solenoide = :especificacion_solenoide 
                           WHERE codigo_producto = :codigo_producto';
                $stmt = $dbh->prepare($sentencia);
                $stmt -> bindParam(':temperatura_nominal', $tn, PDO::PARAM_STR);
                $stmt -> bindParam(':caudal_minimo', $camin, PDO::PARAM_STR);
                $stmt -> bindParam(':caudal_maximo', $camax, PDO::PARAM_STR);
                $stmt -> bindParam(':presion_minima_recomendada', $pminr, PDO::PARAM_STR);
                $stmt -> bindParam(':presion_maxima_recomendada', $pmaxr, PDO::PARAM_STR);
                $stmt -> bindParam(':especificacion_solenoide', $es, PDO::PARAM_STR);
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