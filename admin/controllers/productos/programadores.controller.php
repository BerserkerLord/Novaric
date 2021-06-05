<?php
    include("productos.controller.php");
    class Programador extends Producto{
        var $maximo_estaciones;
        var $entradas_sensores;
        var $entrada_transformador;
        var $salida_transformador;
        var $salida_estacion;
        var $salida_p_mv;

        function getMaximoEstaciones(){ return $this -> maximo_estaciones; }
        function getEntradaSensores(){ return $this -> entradas_sensores; }
        function getEntradaTransformador(){ return $this -> entrada_transformador; }
        function getSalidaTransformador(){ return $this -> salida_transformador; }
        function getSalidaEstacion(){ return $this -> salida_estacion; }
        function getSalidaPMV(){ return $this -> salida_p_mv; }

        function setMaximoEstaciones($me){ $this -> maximo_estaciones = $me; }
        function setEntradaSensores($es){ $this -> entradas_sensores = $es; }
        function setEntradaTransformador($et){ $this -> entrada_transformador = $et; }
        function setSalidaTransformador($st){ $this -> salida_transformador = $st; }
        function setSalidaEstacion($se){ $this -> salida_estacion = $se; }
        function setSalidaPMV($spmv){ $this -> salida_p_mv = $spmv; }

        function createProgramador($cod_pro, $me, $es, $et, $st, $se, $spmv)
        {
            $dbh = $this -> connect();
            $sentencia2 = "INSERT INTO programador(codigo_producto, maximo_estaciones, entradas_sensores, entrada_transformador, salida_transformador,
                                                   salida_estacion, salida_p_mv)
                                            VALUES(:codigo_producto, :maximo_estaciones, :entradas_sensores, :entrada_transformador, :salida_transformador,
                                                   :salida_estacion, :salida_p_mv)";
            $stmt2 = $dbh->prepare($sentencia2);
            $stmt2 -> bindParam(':codigo_producto', $cod_pro, PDO::PARAM_STR);
            $stmt2 -> bindParam(':maximo_estaciones', $me, PDO::PARAM_STR);
            $stmt2 -> bindParam(':entradas_sensores', $es, PDO::PARAM_STR);
            $stmt2 -> bindParam(':entrada_transformador', $et, PDO::PARAM_STR);
            $stmt2 -> bindParam(':salida_transformador', $st, PDO::PARAM_STR);
            $stmt2 -> bindParam(':salida_estacion', $se, PDO::PARAM_STR);
            $stmt2 -> bindParam(':salida_p_mv', $spmv, PDO::PARAM_STR);
            $resultado = $stmt2 -> execute();
            return $resultado;
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

        function updateProgramador($cod_pro, $me, $es, $et, $st, $se, $spmv)
        {
            $dbh = $this->connect();
            $sentencia2 = 'UPDATE programador SET maximo_estaciones = :maximo_estaciones, entradas_sensores = :entradas_sensores, entrada_transformador = :entrada_transformador, 
                                                  salida_transformador = :salida_transformador, salida_estacion = :salida_estacion, salida_p_mv = :salida_p_mv 
                               WHERE codigo_producto = :codigo_producto';
            $stmt2 = $dbh->prepare($sentencia2);
            $stmt2 -> bindParam(':maximo_estaciones', $me, PDO::PARAM_STR);
            $stmt2 -> bindParam(':entradas_sensores', $es, PDO::PARAM_STR);
            $stmt2 -> bindParam(':entrada_transformador', $et, PDO::PARAM_STR);
            $stmt2 -> bindParam(':salida_transformador', $st, PDO::PARAM_STR);
            $stmt2 -> bindParam(':salida_estacion', $se, PDO::PARAM_STR);
            $stmt2 -> bindParam(':salida_p_mv', $spmv, PDO::PARAM_STR);
            $stmt2->bindParam(':codigo_producto', $cod_pro, PDO::PARAM_STR);
            $resultado = $stmt2 -> execute();
            return $resultado;
        }
    }
?>