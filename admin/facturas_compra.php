<?php
    include('controllers/facturas/factura_compra.controller.php');
    include('controllers/productos/productos.controller.php');
    include('controllers/proveedores.controller.php');
    $ptos = array();
    array_push($ptos, 'Administrador');
    array_push($ptos, 'Contador');
    $sistema = New Sistema;
    $sistema -> verificarPuesto($ptos);
    $factura_compras = new FacturaCompra;
    $producto = new Producto;
    $proveedor = new Proveedor();
    $proveedores = $proveedor -> readAll();
    $estatuses = $factura_compras -> readEstatuses();
    $productos = $producto -> readAll('SELECT codigo_producto, producto, precio_publico FROM producto AS p');
    $accion = (isset($_GET['action']))?$_GET['action']:'leer';
    include('views/sidebar_navigation.php');

    switch($accion)
    {
        case 'guardar_factura':
            $factura_compra = $_POST['factura_compra'];
            $resultado = $factura_compras -> createFacturaCompra($factura_compra['rfc'], $factura_compra['codigo_producto'], $factura_compra['cantidad']);
            $datos = $factura_compras -> readFactura();
            include('views/alert.php');
            break;
        case 'ver_estatus':
            $id_factura = $_GET['id_factura'];
            $datos = $factura_compras -> readOneFactura($id_factura);
            break;
        case 'agregar_producto_compra':
            $id_factura = $_GET['id_factura'];
            $productos = $producto -> readProductosDisponiblesCompra($id_factura);
            include('views/facturas/agregar_producto.php');
            break;
        case 'guardar_producto':
            $info = $_POST['factura_compra'];
            $resultado = $factura_compras -> insertProducto($info['id_factura'], $info['codigo_producto'], $info['cantidad']);
            $datos = $factura_compras -> readFactura();
            include('views/alert.php');
            break;
        case 'actualizar_estatus':
            $estatus = $_POST['factura'];
            $resultado = $factura_compras -> changeStatusCompra($estatus['id_factura'], $estatus['id_estatus_factura']);
            $datos = $factura_compras -> readFactura();
            include('views/alert.php');
            break;
        default:
            $_GET['action'] = 'leer';
            $datos = $factura_compras -> readFactura();
    }
    if($_GET['action'] != 'agregar_producto_compra'){
        include('views/facturas/facturas_compras/index.php');
        include('views/facturas/cambiar_estatus.php');
        include('views/facturas/facturas_compras/form.php');
    }
    include('views/footer.php');
?>