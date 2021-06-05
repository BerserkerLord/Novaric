<?php
    include("productos.controller.php");
    class Conexion extends Producto{
        var $diametro;
        var $forma;
        var $extremidad1;
        var $extremidad2;

        function getDiametro(){ return $this -> diametro; }
        function getForma(){ return $this -> forma; }
        function getExtremidad1(){ return $this -> extremidad1; }
        function getExtremidad2(){ return $this -> extremidad2; }

        function setMedida($d){ $this -> medida = $d; }
        function setForma($for){ $this -> forma = $for; }
        function setExtremidad1($ext1){ $this -> extremidad1 = $ext1; }
        function setExtremidad2($ext2){ $this -> extremidad2 = $ext2; }

        function createConexion($cod_pro, $d, $id_f, $id_ext1, $id_ext2)
        {
            $dbh = $this -> connect();
            $sentencia2 = "INSERT INTO conexion(codigo_producto, diametro, id_forma_conexion, id_extremidad1, id_extremidad2)
                                            VALUES(:codigo_producto, :diametro, :id_forma_conexion, :id_extremidad1, :id_extremidad2)";
            $stmt2 = $dbh->prepare($sentencia2);
            $stmt2 -> bindParam(':codigo_producto', $cod_pro, PDO::PARAM_STR);
            $stmt2 -> bindParam(':diametro', $d, PDO::PARAM_STR);
            $stmt2 -> bindParam(':id_forma_conexion', $id_f, PDO::PARAM_STR);
            $stmt2 -> bindParam(':id_extremidad1', $id_ext1, PDO::PARAM_INT);
            $stmt2 -> bindParam(':id_extremidad2', $id_ext2, PDO::PARAM_INT);
            $resultado = $stmt2 -> execute();
            return $resultado;
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

        function updateConexion($cod_pro, $d, $id_f, $id_ext1, $id_ext2)
        {
            $dbh = $this -> connect();
            $sentencia2 = 'UPDATE conexion SET diametro = :diametro, id_forma_conexion = :id_forma_conexion, 
                                               id_extremidad1 = :id_extremidad1, id_extremidad2 = :id_extremidad2  
                               WHERE codigo_producto = :codigo_producto';
            $stmt2 = $dbh->prepare($sentencia2);
            $stmt2->bindParam(':diametro', $d, PDO::PARAM_STR);
            $stmt2->bindParam(':id_forma_conexion', $id_f, PDO::PARAM_STR);
            $stmt2->bindParam(':id_extremidad1', $id_ext1, PDO::PARAM_INT);
            $stmt2->bindParam(':id_extremidad2', $id_ext2, PDO::PARAM_INT);
            $stmt2->bindParam(':codigo_producto', $cod_pro, PDO::PARAM_STR);
            $resultado = $stmt2->execute();
            return $resultado;
        }
    }
?>