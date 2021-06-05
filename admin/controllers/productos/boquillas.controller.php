<?php
    include("productos.controller.php");
    class Boquilla extends Producto{
        var $caudal_minimo;
        var $caudal_maximo;
        var $presion_minima;
        var $presion_maxima;
        var $radio_minimo;
        var $radio_maximo;
        var $trayectoria;
        var $ajuste;
        var $tipo_boquilla;
        var $forma_aspersion;

        function getCaudalMinimo(){ return $this -> caudal_minimo; }
        function getCaudalMaximo(){ return $this -> caudal_maximo; }
        function getPresionMinima(){ return $this -> presion_minima; }
        function getPresionMaxima(){ return $this -> presion_maxima; }
        function getRadioMinimo(){ return $this -> radio_minimo; }
        function getRadioMaximo(){ return $this -> radio_maximo; }
        function getTrayectoria(){ return $this -> trayectoria; }
        function getAjuste(){ return $this -> ajuste; }
        function getTipoBoquilla(){ return $this -> tipo_boquilla; }
        function getFormaAspersion(){ return $this -> forma_aspersion; }

        function setCaudalMinimo($cmin){ $this -> caudal_minimo = $cmin; }
        function setCaudalMaximo($cmax){ $this -> caudal_maximo = $cmax; }
        function setPresionMinima($pmin){ $this -> presion_minima = $pmin; }
        function setPresionMaxima($pmax){ $this -> presion_maxima = $pmax; }
        function setRadioMinimo($rmin){ $this -> radio_minimo = $rmin; }
        function setRadioMaximo($rmax){ $this -> radio_maximo = $rmax; }
        function setTrayectoria($tra){ $this -> trayectoria = $tra; }
        function setAjuste($ajus){ $this -> ajuste = $ajus; }
        function setTipoBoquilla($t_b){ $this -> tipo_boquilla = $t_b; }
        function setFormaAspersion($f_a){ $this -> forma_aspersion = $f_a; }

        function createBoquilla($cod_pro, $cmin, $cmax, $pmin, $pmax, $rmin, $rmax, $tra, $ajus, $id_t_b, $id_f_a)
        {
            $dbh = $this -> connect();
            $sentencia2 = "INSERT INTO boquilla(codigo_producto, caudal_minimo, caudal_maximo, presion_minima, presion_maxima, 
                                                radio_minimo, radio_maximo, trayectoria, ajuste, id_tipo_boquilla, id_forma_aspersion)
                                         VALUES(:codigo_producto, :caudal_minimo, :caudal_maximo, :presion_minima, :presion_maxima, 
                                                :radio_minimo, :radio_maximo, :trayectoria, :ajuste, :id_tipo_boquilla, :id_forma_aspersion)";
            $stmt2 = $dbh -> prepare($sentencia2);
            $stmt2 -> bindParam(':codigo_producto', $cod_pro, PDO::PARAM_STR);
            $stmt2 -> bindParam(':caudal_minimo', $cmin, PDO::PARAM_STR);
            $stmt2 -> bindParam(':caudal_maximo', $cmax, PDO::PARAM_STR);
            $stmt2 -> bindParam(':presion_minima', $pmin, PDO::PARAM_STR);
            $stmt2 -> bindParam(':presion_maxima', $pmax, PDO::PARAM_STR);
            $stmt2 -> bindParam(':radio_minimo', $rmin, PDO::PARAM_STR);
            $stmt2 -> bindParam(':radio_maximo', $rmax, PDO::PARAM_STR);
            $stmt2 -> bindParam(':trayectoria', $tra, PDO::PARAM_INT);
            $stmt2 -> bindParam(':ajuste', $ajus, PDO::PARAM_STR);
            $stmt2 -> bindParam(':id_tipo_boquilla', $id_t_b, PDO::PARAM_INT);
            $stmt2 -> bindParam(':id_forma_aspersion', $id_f_a, PDO::PARAM_INT);
            $resultado = $stmt2 -> execute();
            return $resultado;
        }

        function readBoquilla(){
            $sentencia = 'SELECT id_unidad, id_marca, codigo_producto, producto, costo, precio, precio_publico, descripcion, existencias, p.fotografia,
                                 marca, unidad, id_tipo_boquilla, id_forma_aspersion, caudal_minimo, caudal_maximo, presion_minima, presion_maxima, radio_minimo, radio_maximo,
                                 trayectoria, ajuste, forma_aspersion, tipo_boquilla FROM producto p  
                                      INNER JOIN boquilla USING(codigo_producto) 
                                      INNER JOIN marca USING(id_marca)
                                      INNER JOIN unidad USING(id_unidad)
                                      INNER JOIN forma_aspersion USING(id_forma_aspersion)
                                      INNER JOIN tipo_boquilla USING(id_tipo_boquilla)
                                  WHERE p.producto LIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
            return $this -> read($sentencia, 'p.productos');
        }

        function readOneBoquilla($c_d){
            $sentencia = 'SELECT id_unidad, id_marca, codigo_producto, producto, costo, precio, precio_publico, descripcion, existencias, p.fotografia,
                                 marca, unidad, id_tipo_boquilla, id_forma_aspersion, caudal_minimo, caudal_maximo, presion_minima, presion_maxima, radio_minimo, radio_maximo,
                                 trayectoria, ajuste, forma_aspersion, tipo_boquilla FROM producto p
                                      INNER JOIN boquilla USING(codigo_producto) 
                                      INNER JOIN marca USING(id_marca)
                                      INNER JOIN unidad USING(id_unidad)
                                      INNER JOIN forma_aspersion USING(id_forma_aspersion)
                                      INNER JOIN tipo_boquilla USING(id_tipo_boquilla)
                                  WHERE codigo_producto = :codigo_producto';
            return $this -> readOne($sentencia, $c_d);
        }

        function updateBoquilla($cod_pro, $cmin, $cmax, $pmin, $pmax, $rmin, $rmax, $tra, $ajus, $id_t_b, $id_f_a)
        {
            $dbh = $this->connect();
            $sentencia2 = 'UPDATE boquilla SET caudal_minimo = :caudal_minimo, caudal_maximo = :caudal_maximo, 
                                               presion_minima = :presion_minima,presion_maxima = :presion_maxima, 
                                               radio_minimo = :radio_minimo, radio_maximo = :radio_maximo,
                                               trayectoria = :trayectoria, ajuste = :ajuste, 
                                               id_tipo_boquilla = :id_tipo_boquilla, id_forma_aspersion = :id_forma_aspersion 
                           WHERE codigo_producto = :codigo_producto';
            $stmt2 = $dbh->prepare($sentencia2);
            $stmt2 -> bindParam(':caudal_minimo', $cmin, PDO::PARAM_STR);
            $stmt2 -> bindParam(':caudal_maximo', $cmax, PDO::PARAM_STR);
            $stmt2 -> bindParam(':presion_minima', $pmin, PDO::PARAM_STR);
            $stmt2 -> bindParam(':presion_maxima', $pmax, PDO::PARAM_STR);
            $stmt2 -> bindParam(':radio_minimo', $rmin, PDO::PARAM_STR);
            $stmt2 -> bindParam(':radio_maximo', $rmax, PDO::PARAM_STR);
            $stmt2 -> bindParam(':trayectoria', $tra, PDO::PARAM_INT);
            $stmt2 -> bindParam(':ajuste', $ajus, PDO::PARAM_STR);
            $stmt2 -> bindParam(':id_tipo_boquilla', $id_t_b, PDO::PARAM_INT);
            $stmt2 -> bindParam(':id_forma_aspersion', $id_f_a, PDO::PARAM_INT);
            $stmt2 -> bindParam(':codigo_producto', $cod_pro, PDO::PARAM_STR);
            $resultado = $stmt2 -> execute();
            return $resultado;
        }
    }
?>