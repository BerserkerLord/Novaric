<?php
    include("productos.controller.php");
    class Miscelaneo extends Producto{

        function createMiscelaneo($cod_pro)
        {
            $dbh = $this -> connect();
            $sentencia2 = "INSERT INTO miscelaneo(codigo_producto) VALUES(:codigo_producto)";
            $stmt2 = $dbh->prepare($sentencia2);
            $stmt2 -> bindParam(':codigo_producto', $cod_pro, PDO::PARAM_STR);
            $resultado = $stmt2 -> execute();
            return $resultado;
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
    }
?>