<?php
    include("productos.controller.php");
    class Miscelaneo extends Producto
    {
        function createMiscelaneo($cod_pro, $pro, $cos, $desc, $exis, $id_mar, $id_uni)
        {
            $dbh = $this -> connect();
            $dbh -> beginTransaction();
            try {
                $this -> createProducto($cod_pro, $pro, $cos, $desc, $exis, $id_mar, $id_uni) -> execute();
                $sentencia = "INSERT INTO miscelaneo(codigo_producto) VALUES(:codigo_producto)";
                $stmt = $dbh -> prepare($sentencia);
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

        function readMiscelaneo(){
            $sentencia = 'SELECT id_unidad, id_marca, codigo_producto, producto, costo, precio, precio_publico, descripcion, existencias, p.fotografia,
                                 marca, unidad FROM producto p 
                                  INNER JOIN miscelaneo m USING(codigo_producto) 
                                  INNER JOIN marca USING(id_marca)
                                  INNER JOIN unidad USING(id_unidad)
                              WHERE p.producto LIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
            return $this -> read($sentencia, 'p.productos');
        }

        function readOneMiscelaneo($c_d){
            $sentencia = 'SELECT id_unidad, id_marca, codigo_producto, producto, costo, precio, precio_publico, descripcion, existencias, p.fotografia,
                                 marca, unidad FROM producto p 
                                  INNER JOIN miscelaneo m USING(codigo_producto) 
                                  INNER JOIN marca USING(id_marca)
                                  INNER JOIN unidad USING(id_unidad)
                               WHERE codigo_producto = :codigo_producto';
            return $this -> readOne($sentencia, $c_d);
        }

        function updateMiscelaneo($cod_pro, $pro, $cos, $desc, $id_mar, $id_uni)
        {
            $dbh = $this -> connect();
            $dbh -> beginTransaction();
            try{
                $resultado = $this -> updateProducto($cod_pro, $pro, $cos, $desc, $id_mar, $id_uni) -> execute();
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