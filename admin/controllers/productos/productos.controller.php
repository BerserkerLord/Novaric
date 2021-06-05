<?php
    require_once('controllers/sistema.controller.php');
    class Producto extends Sistema
    {

        //Borrar
        function createProducto($cod_pro, $pro, $cos, $desc, $exis, $id_mar, $id_uni)
        {
            $pre = $this -> calcularPrecio($cos);
            $pre_pub = $this -> calcularPrecioPublico($pre);
            $dbh = $this -> connect();
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
            $resultado = $stmt -> execute();
            return $resultado;
        }

        function read($sentencia, $ordenamiento)
        {
            $dbh = $this -> connect();
            $busqueda = (isset($_GET['busqueda']))?$_GET['busqueda']:'';
            $ordenamiento = (isset($_GET['ordenamiento']))?$_GET['ordenamiento']:$ordenamiento;
            $limite = (isset($_GET['limite']))?$_GET['limite']:'10';
            $desde = (isset($_GET['desde']))?$_GET['desde']:'0';
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindValue(":busqueda", '%' . $busqueda . '%', PDO::PARAM_STR);
            $stmt -> bindValue(":ordenamiento", $ordenamiento, PDO::PARAM_STR);
            $stmt -> bindValue(":limite", $limite, PDO::PARAM_INT);
            $stmt -> bindValue(":desde", $desde, PDO::PARAM_INT);
            $stmt -> execute();
            $filas = $stmt -> fetchAll();
            return $filas;
        }

        function readOne($sentencia, $c_d)
        {
            $dbh = $this -> connect();
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindParam(':codigo_producto', $c_d, PDO::PARAM_STR);
            $stmt -> execute();
            $filas = $stmt -> fetchAll();
            return $filas;
        }

        //Borrar
        function updateProducto($cod_pro, $pro, $cos, $desc, $id_mar, $id_uni)
        {
            $pre = $this -> calcularPrecio($cos);
            $pre_pub = $this -> calcularPrecioPublico($pre);
            $dbh = $this -> connect();
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
            return $resultado;
        }

        function delete($c_d, $tabla)
        {
            $dbh = $this -> connect();
            $dbh -> beginTransaction();
            try{
                $sentencia = 'DELETE FROM ' . $tabla . ' WHERE codigo_producto = :codigo_producto';
                $stmt = $dbh -> prepare($sentencia);
                $stmt -> bindParam(':codigo_producto', $c_d, PDO::PARAM_STR);
                $resultado = $stmt -> execute();
                $sentencia = 'DELETE FROM producto WHERE codigo_producto = :codigo_producto';
                $stmt = $dbh -> prepare($sentencia);
                $stmt -> bindParam(':codigo_producto', $c_d, PDO::PARAM_STR);
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

        function guardarFotografia()
        {
            $archivo = $_FILES['fotografia'];
            $tipos = array('image/jpeg', 'image/png', 'image/gif');
            if ($archivo['error'] == 0) {
                if ($archivo['size'] <= 2097152) {
                    $a = explode('/', $archivo['type']);
                    $nueva_imagen = MD5(time()) . '.' . $a[1];
                    if (move_uploaded_file($archivo['tmp_name'], '../archivos/' . $nueva_imagen)) {
                        return $nueva_imagen;
                    }
                }
            }
        }

        //Borrar
        function calcularPrecio($cos){ return $cos * 1.7; }
        function calcularPrecioPublico($pre){ return $pre; }

        function total($columna, $tabla){
            $dbh = $this -> Connect();
            $sentencia = "SELECT COUNT(" . $columna . ") AS total FROM " . $tabla;
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> execute();
            $rows = $stmt -> fetchAll();
            return $rows[0]['total'];
        }
    }
?>