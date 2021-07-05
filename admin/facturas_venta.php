<?php
    include('controllers/facturas/factura_venta.controller.php');
    include('controllers/productos/productos.controller.php');
    include('controllers/clientes.controller.php');
    $ptos = array();
    array_push($ptos, 'Administrador');
    array_push($ptos, 'Contador');
    $sistema = New Sistema;
    $sistema -> verificarPuesto($ptos);
    $factura_ventas = new FacturaVenta;
    $producto = new Producto;
    $cliente = new Cliente();
    $clientes = $cliente -> readAll();
    $estatuses = $factura_ventas -> readEstatuses();
    $estatuses_ventas = $factura_ventas -> readEstatusesVenta();
    $productos = $producto -> readAll('SELECT codigo_producto, producto, precio_publico FROM producto AS p');
    $accion = (isset($_GET['action']))?$_GET['action']:'leer';
    include('views/sidebar_navigation.php');

    switch($accion)
    {
        case 'guardar_factura':
            $factura_venta = $_POST['factura_venta'];
            $resultado = $factura_ventas -> createFacturaVenta($factura_venta['rfc'], $factura_venta['codigo_producto'], $factura_venta['cantidad']);
            $datos = $factura_ventas -> readFactura();
            include('views/alert.php');
            break;
        case 'ver_estatus':
            $id_factura = $_GET['id_factura'];
            $datos = $factura_ventas -> readOneFactura($id_factura);
            break;
        case 'ver_estatus_venta':
            $id_factura = $_GET['id_factura'];
            $datos = $factura_ventas -> readOneFactura($id_factura);

            include('views/facturas/facturas_ventas/cambiar_estatus_venta.php');
            break;
        case 'agregar_producto_venta';
            $id_factura = $_GET['id_factura'];
            $productos = $producto -> readProductosDisponiblesVenta($id_factura);
            include('views/facturas/agregar_producto.php');
            break;
        case 'guardar_producto':
            $info = $_POST['factura_venta'];
            $resultado = $factura_ventas -> insertProducto($info['id_factura'], $info['codigo_producto'], $info['cantidad']);
            $datos = $factura_ventas -> readFactura();
            include('views/alert.php');
            break;
        case 'actualizar_estatus':
            $estatus = $_POST['factura'];
            $resultado = $factura_ventas -> changeStatusVenta($estatus['id_factura'], $estatus['id_estatus_factura']);
            $datos = $factura_ventas -> readFactura();
            include('views/alert.php');
            break;
        case 'actualizar_estatus_venta':
            $estatus = $_POST['factura'];
            $resultado = $factura_ventas -> changeStatusVentaEnvio($estatus['id_factura'], $estatus['id_estatus_venta']);
            $datos = $factura_ventas -> readFactura();
            include('views/alert.php');
            break;
        default:
            $_GET['action'] = 'leer';
            $datos = $factura_ventas -> readFactura();
    }
    if($_GET['action'] != 'agregar_producto_venta' && $_GET['action'] != 'ver_estatus_venta'){
        include('views/facturas/facturas_ventas/index.php');
        include('views/facturas/cambiar_estatus.php');
        include('views/facturas/facturas_ventas/form.php');
    }
    include('views/footer.php');
?>