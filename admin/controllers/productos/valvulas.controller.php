<?php
    include("productos.controller.php");
    class Valvula extends Producto{
        var $temperatura_nominal;
        var $caudal_mimimo;
        var $caudal_maximo;
        var $presion_minima_recomendada;
        var $presion_maxima_recomendada;
        var $especificacion_solenoide;

        function getTemperaturaNominal(){ return $this -> temperatura_nominal; }
        function getCaudalMinimo(){ return $this -> caudal_mimimo; }
        function getCaudalMaximo(){ return $this -> caudal_maximo; }
        function getPresionMinimaRecomendada(){ return $this -> presion_minima_recomendada; }
        function getPresionMaximaRecomendada(){ return $this -> presion_maxima_recomendada; }
        function getEspecificacionSolenoide(){ return $this -> especificacion_solenoide; }

        function setTemperaturaNominal($tn){ $this -> temperatura_nominal = $tn; }
        function setCaudalMinimo($camin){ $this -> caudal_mimimo = $camin; }
        function setCaudalMaximo($camax){ $this -> caudal_maximo = $camax; }
        function setPresionMinimaRecomendada($pminr){ $this -> presion_minima_recomendada = $pminr; }
        function setPresionMaximaRecomendada($pmaxr){ $this -> presion_maxima_recomendada = $pmaxr; }
        function setEspecificacionSolenoide($es){ $this -> especificacion_solenoide = $es; }

        function createValvula($cod_pro, $tn, $camin, $camax, $pminr, $pmaxr, $es)
        {
            $dbh = $this -> connect();
            $sentencia2 = "INSERT INTO valvula(codigo_producto, temperatura_nominal, caudal_minimo, caudal_maximo, presion_minima_recomendada,
                                               presion_maxima_recomendada, especificacion_solenoide)
                                        VALUES(:codigo_producto, :temperatura_nominal, :caudal_minimo, :caudal_maximo, :presion_minima_recomendada,
                                               :presion_maxima_recomendada, :especificacion_solenoide)";
            $stmt2 = $dbh->prepare($sentencia2);
            $stmt2 -> bindParam(':codigo_producto', $cod_pro, PDO::PARAM_STR);
            $stmt2 -> bindParam(':temperatura_nominal', $tn, PDO::PARAM_STR);
            $stmt2 -> bindParam(':caudal_minimo', $camin, PDO::PARAM_STR);
            $stmt2 -> bindParam(':caudal_maximo', $camax, PDO::PARAM_STR);
            $stmt2 -> bindParam(':presion_minima_recomendada', $pminr, PDO::PARAM_STR);
            $stmt2 -> bindParam(':presion_maxima_recomendada', $pmaxr, PDO::PARAM_STR);
            $stmt2 -> bindParam(':especificacion_solenoide', $es, PDO::PARAM_STR);
            $resultado = $stmt2 -> execute();
            return $resultado;
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

        function updateValvula($cod_pro, $tn, $camin, $camax, $pminr, $pmaxr, $es)
        {
            $dbh = $this->connect();
            $sentencia2 = 'UPDATE valvula SET temperatura_nominal = :temperatura_nominal, caudal_minimo = :caudal_minimo, caudal_maximo = :caudal_maximo, 
                                              presion_minima_recomendada = :presion_minima_recomendada, presion_maxima_recomendada = :presion_maxima_recomendada, especificacion_solenoide = :especificacion_solenoide 
                           WHERE codigo_producto = :codigo_producto';
            $stmt2 = $dbh->prepare($sentencia2);
            $stmt2 -> bindParam(':temperatura_nominal', $tn, PDO::PARAM_STR);
            $stmt2 -> bindParam(':caudal_minimo', $camin, PDO::PARAM_STR);
            $stmt2 -> bindParam(':caudal_maximo', $camax, PDO::PARAM_STR);
            $stmt2 -> bindParam(':presion_minima_recomendada', $pminr, PDO::PARAM_STR);
            $stmt2 -> bindParam(':presion_maxima_recomendada', $pmaxr, PDO::PARAM_STR);
            $stmt2 -> bindParam(':especificacion_solenoide', $es, PDO::PARAM_STR);
            $stmt2->bindParam(':codigo_producto', $cod_pro, PDO::PARAM_STR);
            $resultado = $stmt2->execute();
            return $resultado;
        }
    }
?>