<?php
    include("productos.controller.php");
    class Tuberia extends Producto{
        var $diametro;
        var $longitud;
        var $extremidad1;
        var $extremidad2;

        function getDiametro(){ return $this -> diametro; }
        function getLongitud(){ return $this -> longitud; }
        function getExtremidad1(){ return $this -> extremidad1; }
        function getExtremidad2(){ return $this -> extremidad2; }

        function setMedida($d){ $this -> medida = $d; }
        function setLongitud($lon){ $this -> longitud = $lon; }
        function setExtremidad1($ext1){ $this -> extremidad1 = $ext1; }
        function setExtremidad2($ext2){ $this -> extremidad2 = $ext2; }

        function createTuberia($cod_pro, $d, $l, $id_ext1, $id_ext2)
        {
            $dbh = $this -> connect();
            $sentencia2 = "INSERT INTO tuberia(codigo_producto, diametro, longitud, id_extremidad1, id_extremidad2)
                                        VALUES(:codigo_producto, :diametro, :longitud, :id_extremidad1, :id_extremidad2)";
            $stmt2 = $dbh->prepare($sentencia2);
            $stmt2 -> bindParam(':codigo_producto', $cod_pro, PDO::PARAM_STR);
            $stmt2 -> bindParam(':diametro', $d, PDO::PARAM_STR);
            $stmt2 -> bindParam(':longitud', $l, PDO::PARAM_STR);
            $stmt2 -> bindParam(':id_extremidad1', $id_ext1, PDO::PARAM_INT);
            $stmt2 -> bindParam(':id_extremidad2', $id_ext2, PDO::PARAM_INT);
            $resultado = $stmt2 -> execute();
            return $resultado;
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

        function updateTuberia($cod_pro, $d, $l, $id_ext1, $id_ext2)
        {
            $dbh = $this->connect();
            $sentencia2 = 'UPDATE tuberia SET diametro = :diametro, longitud = :longitud, id_extremidad1 = :id_extremidad1, id_extremidad2 = :id_extremidad2  
                           WHERE codigo_producto = :codigo_producto';
            $stmt2 = $dbh->prepare($sentencia2);
            $stmt2->bindParam(':diametro', $d, PDO::PARAM_STR);
            $stmt2->bindParam(':longitud', $l, PDO::PARAM_STR);
            $stmt2->bindParam(':id_extremidad1', $id_ext1, PDO::PARAM_INT);
            $stmt2->bindParam(':id_extremidad2', $id_ext2, PDO::PARAM_INT);
            $stmt2->bindParam(':codigo_producto', $cod_pro, PDO::PARAM_STR);
            $resultado = $stmt2->execute();
            return $resultado;
        }
    }
?>