<?php
    include("productos.controller.php");
    class Programador extends Producto{
        function createProgramador($cod_pro, $pro, $cos, $desc, $exis, $id_mar, $id_uni, $me, $es, $et, $st, $se, $spmv)
        {
            $dbh = $this -> connect();
            $dbh -> beginTransaction();
            try {
                $this -> createProducto($cod_pro, $pro, $cos, $desc, $exis, $id_mar, $id_uni) -> execute();
                $sentencia = "INSERT INTO programador(codigo_producto, maximo_estaciones, entradas_sensores, entrada_transformador, salida_transformador,
                                                   salida_estacion, salida_p_mv)
                                            VALUES(:codigo_producto, :maximo_estaciones, :entradas_sensores, :entrada_transformador, :salida_transformador,
                                                   :salida_estacion, :salida_p_mv)";
                $stmt = $dbh->prepare($sentencia);
                $stmt -> bindParam(':codigo_producto', $cod_pro, PDO::PARAM_STR);
                $stmt -> bindParam(':maximo_estaciones', $me, PDO::PARAM_STR);
                $stmt -> bindParam(':entradas_sensores', $es, PDO::PARAM_STR);
                $stmt -> bindParam(':entrada_transformador', $et, PDO::PARAM_STR);
                $stmt -> bindParam(':salida_transformador', $st, PDO::PARAM_STR);
                $stmt -> bindParam(':salida_estacion', $se, PDO::PARAM_STR);
                $stmt -> bindParam(':salida_p_mv', $spmv, PDO::PARAM_STR);
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

        function readProgramador(){
            $sentencia = 'SELECT id_unidad, id_marca, codigo_producto, producto, costo, precio, precio_publico, descripcion, existencias, p.fotografia,
                                 marca, unidad, maximo_estaciones, entradas_sensores, entrada_transformador, salida_transformador, salida_estacion, salida_p_mv FROM producto p  
                                      INNER JOIN programador USING(codigo_producto) 
                                      INNER JOIN marca USING(id_marca)
                                      INNER JOIN unidad USING(id_unidad)
                              WHERE p.producto LIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
            return $this -> read($sentencia, 'p.productos');
        }

        function readOneProgramador($c_d){
            $sentencia = 'SELECT * FROM producto p 
                                      INNER JOIN programador USING(codigo_producto) 
                                      INNER JOIN marca USING(id_marca)
                                      INNER JOIN unidad USING(id_unidad)
                              WHERE codigo_producto = :codigo_producto';
            return $this -> readOne($sentencia, $c_d);
        }

        function updateProgramador($cod_pro, $pro, $cos, $desc, $id_mar, $id_uni, $me, $es, $et, $st, $se, $spmv)
        {
            $dbh = $this -> connect();
            $dbh -> beginTransaction();
            try{
                $this -> updateProducto($cod_pro, $pro, $cos, $desc, $id_mar, $id_uni) -> execute();
                $sentencia = 'UPDATE programador SET maximo_estaciones = :maximo_estaciones, entradas_sensores = :entradas_sensores, entrada_transformador = :entrada_transformador, 
                                                  salida_transformador = :salida_transformador, salida_estacion = :salida_estacion, salida_p_mv = :salida_p_mv 
                               WHERE codigo_producto = :codigo_producto';
                $stmt = $dbh -> prepare($sentencia);
                $stmt -> bindParam(':maximo_estaciones', $me, PDO::PARAM_STR);
                $stmt -> bindParam(':entradas_sensores', $es, PDO::PARAM_STR);
                $stmt -> bindParam(':entrada_transformador', $et, PDO::PARAM_STR);
                $stmt -> bindParam(':salida_transformador', $st, PDO::PARAM_STR);
                $stmt -> bindParam(':salida_estacion', $se, PDO::PARAM_STR);
                $stmt -> bindParam(':salida_p_mv', $spmv, PDO::PARAM_STR);
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