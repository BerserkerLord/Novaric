<?php
    include('controllers/facturas/factura_compra.controller.php');
    include('controllers/productos/productos.controller.php');
    include('controllers/proveedores.controller.php');
    include('controllers/sistema.controller.php');
    $ptos = array();
    array_push($ptos, 'Administrador');
    array_push($ptos, 'Contador');
    $sistema = New Sistema;
    $sistema -> verificarPuesto($ptos);
    $factura_compras = new FacturaCompra;
    $producto = new Producto;
    $proveedor = new Proveedor();
    $proveedores = $proveedor -> read();
    $estatuses = $factura_compras -> readEstatuses();
    $productos = $producto -> read('SELECT codigo_producto, producto, precio_publico FROM producto AS p WHERE p.producto LIKE :busqueda ORDER BY :ordenamiento LIMIT :limite OFFSET :desde', 'p.producto');
    $accion = (isset($_GET['action']))?$_GET['action']:'leer';
    include('views/sidebar_navigation.php');

    switch($accion)
    {
        case 'guardar_factura':
            $factura_compra = $_POST['factura_compra'];
            $factura_compras -> createFacturaCompra($factura_compra['rfc'], $factura_compra['codigo_producto'], $factura_compra['cantidad']);
            $datos = $factura_compras -> readFactura();
            break;
        case 'ver_estatus':
            $id_factura = $_GET['id_factura'];
            $datos = $factura_compras -> readOneFactura($id_factura);
            break;
        case 'agregar_producto':
            $id_factura = $_GET['id_factura'];
            $productos = $producto -> readProductosDisponibles($id_factura);
            include('views/facturas/facturas_compras/agregar_producto.php');
            break;
        case 'guardar_producto':
            $info = $_POST['factura_compra'];
            $factura_compras -> insertProducto($info['id_factura'], $info['codigo_producto'], $info['cantidad']);
            $datos = $factura_compras -> readFactura();
            break;
        case 'actualizar_estatus':
            $estatus = $_POST['factura'];
            $resultado = $factura_compras -> changeStatus($estatus['id_factura'], $estatus['id_estatus_factura']);
            $datos = $factura_compras -> readFactura();
            break;
        case 'generar_pdf':
            $id_factura = $_GET['id_factura'];
            $servicio = $factura_compras -> readProductosFactura($id_factura);
            $cliente = $factura_compras -> readProveedorCompra($id_factura);
            $factura = $factura_compras -> readFacturaCompra($id_factura);
            break;
        default:
            $_GET['action'] = 'leer';
            $datos = $factura_compras -> readFactura();
    }
    if($_GET['action'] != 'agregar_producto'){
        include('views/facturas/facturas_compras/index.php');
        include('views/facturas/cambiar_estatus.php');
        include('views/facturas/facturas_compras/form.php');
    }
    include('views/footer.php');
?>