<?php
    require_once('controllers/sistema.controller.php');
    class Producto extends Sistema
    {

       /*
        * Método para obtener todos los productos en funcion al tipo por cantidades
        * Params String @sentencia recibe la consulta que ejecutará en la BD ne función al tipo de producto
        *        String @orden recibe orden que se mostrarán los productos
        * Return Arreglo con los productos
        */
        function read($sentencia, $orden)
        {
            $dbh = $this -> connect();
            $busqueda = (isset($_GET['busqueda']))?$_GET['busqueda']:'';
            $ordenamiento = (isset($_GET['ordenamiento']))?$_GET['ordenamiento']:$orden;
            $limite = (isset($_GET['limite']))?$_GET['limite']:'5';
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

       /*
        * Método para obtener un producto en funcion al tipo
        * Params String @sentencia recibe la consulta que ejecutará en la BD ne función al tipo de producto
        *        String @c_d recibe el código del producto
        * Return Arreglo con la información del producto
        */
        function readOne($sentencia, $c_d)
        {
            $dbh = $this -> connect();
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindParam(':codigo_producto', $c_d, PDO::PARAM_STR);
            $stmt -> execute();
            $filas = $stmt -> fetchAll();
            return $filas;
        }

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
            return $stmt;
        }

       /*
        * Metodo para elimina el registro de un producto
        * Params Integer @id_un recibe el id de una unidad
        *        String @table recibe tipo de producto que se eliminará
        * Return Arreglo con informacion de exito al momento de hacer la operación
        */
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
                $stmt -> execute();
                $dbh -> commit();
                $msg['msg'] = 'Producto eliminado correctamente.';
                $msg['status'] = 'success';
                return $msg;
            } catch (Exception $e) {
                $msg['msg'] = 'Error al eliminar, el producto esta asociado a una o mas facturas.';
                $msg['status'] = 'danger';
                return $msg;
            }
        }

      /*
       * Método para subir una imagen de un producto
       * Return Booleano señalando si la imagen es valida de acuerdo al formato
       */
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

      /*
       * Método para extrater total de productos de un tipo
       * Params Integer @columna recibe la columna de la tabla de la que extraerá el total
       *        String  @table recibe tipo de producto que se contará
       * Return un entero que es la cantidad de productos
       */
        function total($columna, $tabla){
            $dbh = $this -> Connect();
            $sentencia = "SELECT COUNT(" . $columna . ") AS total FROM " . $tabla;
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> execute();
            $rows = $stmt -> fetchAll();
            return $rows[0]['total'];
        }

      /*
       * Método para extrater los productos a los cuales una factura puede seleccionar
       * Params Integer @id_factura el id de la factura seleccionada
       * Return Array con los productos disponibles para esa factura
       */
        function readProductosDisponibles($id_factura){
            $dbh = $this -> Connect();
            $query = "SELECT codigo_producto, producto FROM producto 
                      WHERE codigo_producto NOT IN(SELECT p.codigo_producto FROM factura f 
                                                       INNER JOIN detalle_factura_producto AS dpf ON f.id_factura = dpf.id_factura
                                                       INNER JOIN producto p ON p.codigo_producto = dpf.codigo_producto 
                                                   WHERE f.id_factura = :id_factura)";
            $stmt = $dbh -> prepare($query);
            $stmt -> bindParam(":id_factura", $id_factura, PDO::PARAM_INT);
            $stmt -> execute();
            $fila = $stmt -> fetchAll();
            return $fila;
        }

       /*
        * Metodo que extrae todas las entradas de producto de la base de datos
        * Return Array con todas las entradas
        */
        function readEntradas(){
            $dbh = $this -> connect();
            $busqueda = (isset($_GET['busqueda']))?$_GET['busqueda']:'';
            $ordenamiento = (isset($_GET['ordenamiento']))?$_GET['ordenamiento']:'f.fecha';
            $limite = (isset($_GET['limite']))?$_GET['limite']:'15';
            $desde = (isset($_GET['desde']))?$_GET['desde']:'0';
            /*switch($_SESSION['engine']){
                case 'mariadb':
                    $sentencia = 'SELECT f.id_factura AS id_factura, f.fecha AS fecha, p.codigo_producto AS codigo_producto, p.producto AS producto, dfp.cantidad AS cantidad FROM factura AS f
                                      INNER JOIN detalle_factura_producto AS dfp ON dfp.id_factura = f.id_factura
                                      INNER JOIN producto AS p USING(codigo_producto)
                                  WHERE p.codigo_producto LIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
                    break;
                case 'postgresql':
                    $sentencia = 'SELECT f.id_factura AS id_factura, f.fecha AS fecha, p.codigo_producto AS codigo_producto, p.producto AS producto, dfp.cantidad AS cantidad FROM factura AS f
                                      INNER JOIN detalle_factura_producto AS dfp ON dfp.id_factura = f.id_factura
                                      INNER JOIN producto AS p USING(codigo_producto)
                                  WHERE p.codigo_producto ILIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
                    break;
            }*/
            $sentencia = 'SELECT f.id_factura AS id_factura, f.fecha AS fecha, p.codigo_producto AS codigo_producto, p.producto AS producto, dfp.cantidad AS cantidad FROM factura AS f
                                INNER JOIN detalle_factura_producto AS dfp ON dfp.id_factura = f.id_factura
                                INNER JOIN producto AS p USING(codigo_producto)
                          WHERE p.codigo_producto LIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde';
            $stmt = $dbh -> prepare($sentencia);
            $stmt -> bindValue(":desde", $desde, PDO::PARAM_INT);
            $stmt -> bindValue(":busqueda", '%' . $busqueda . '%', PDO::PARAM_STR);
            $stmt -> bindValue(":ordenamiento", $ordenamiento, PDO::PARAM_STR);
            $stmt -> bindValue(":limite", $limite, PDO::PARAM_INT);
            $stmt -> bindValue(":desde", $desde, PDO::PARAM_INT);
            $stmt -> execute();
            $filas = $stmt -> fetchAll();
            return $filas;
        }

       /*
        * Metodo para calcular el precio de un producto
        * Params Double @cos recible el costo de un producto
        * Return Double con el precio del producto
        */
        function calcularPrecio($cos){ return $cos * 1.7; }

       /*
        * Metodo para calcular el precio al publico de un producto
        * Params Double @pre recible el precio de un producto
        * Return Double con el precio al público del producto
        */
        function calcularPrecioPublico($pre){ return $pre; }
    }
?>