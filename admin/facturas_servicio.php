<?php
    include('controllers/facturas/factura_servicio.controller.php');
    include('controllers/servicios.controller.php');
    include('controllers/clientes.controller.php');
    $ptos = array();
    array_push($ptos, 'Administrador');
    array_push($ptos, 'Contador');
    $sistema = New Sistema;
    $sistema -> verificarPuesto($ptos);
    $factura_servicios = new FacturaServicio;
    $servicio = new Servicio;
    $cliente = new Cliente;
    $clientes = $cliente -> readAll();
    $estatuses = $factura_servicios -> readEstatuses();
    $servicios = $servicio -> readAll();
    $accion = (isset($_GET['action']))?$_GET['action']:'leer';
    include('views/sidebar_navigation.php');

    switch($accion)
    {
        case 'guardar_factura':
            $factura_servicio = $_POST['factura_servicio'];
            $resultado = $factura_servicios -> createFacturaServicio($factura_servicio['rfc'], $factura_servicio['descripcion'], $factura_servicio['domicilio'],
                                                        $factura_servicio['id_servicio'], $factura_servicio['monto']);
            $datos = $factura_servicios -> readFactura();
            include('views/alert.php');
            break;
        case 'ver_estatus':
            $id_factura = $_GET['id_factura'];
            $datos = $factura_servicios -> readOneFactura($id_factura);
            break;
        case 'agregar_servicio':
            $id_factura = $_GET['id_factura'];
            $servicios = $servicio -> readServiciosDisponibles($id_factura);
            include('views/facturas/facturas_servicios/agregar_servicio.php');
            break;
        case 'guardar_servicio':
            $info = $_POST['factura_servicio'];
            $resultado = $factura_servicios -> insertServicio($info['id_factura_servicio'], $info['id_servicio'], $info['monto']);
            $datos = $factura_servicios -> readFactura();
            include('views/alert.php');
            break;
        case 'actualizar_estatus':
            $estatus = $_POST['factura'];
            $resultado = $factura_servicios -> changeStatusServicio($estatus['id_factura'], $estatus['id_estatus_factura']);
            $datos = $factura_servicios -> readFactura();
            include('views/alert.php');
            break;
        default:
            $_GET['action'] = 'leer';
            $datos = $factura_servicios -> readFactura();
    }
    if($_GET['action'] != 'agregar_servicio'){
        include('views/facturas/facturas_servicios/index.php');
        include('views/facturas/cambiar_estatus.php');
        include('views/facturas/facturas_servicios/form.php');
    }
    include('views/footer.php');
?>