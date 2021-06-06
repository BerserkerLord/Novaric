<?php
    include('controllers/facturas/factura_servicio.controller.php');
    include('controllers/servicios.controller.php');
    include('controllers/clientes_servicio.controller.php');
    $factura_servicios = new FacturaServicio;
    $servicio = new Servicio;
    $cliente = new ClienteServicio;
    $clientes = $cliente -> read();
    $estatuses = $factura_servicios -> readEstatuses();
    $servicios = $servicio -> read();
    $accion = (isset($_GET['action']))?$_GET['action']:'leer';
    include('views/sidebar_navigation.php');

    switch($accion)
    {
        /*case 'guardar':
            $aspersor = $_POST['aspersor'];
            $resultado = $aspersores -> createProducto($aspersor['codigo_producto'], $aspersor['producto'], $aspersor['costo'],
                $aspersor['descripcion'], $aspersor['existencias'], $aspersor['id_marca'], $aspersor['id_unidad']);
            $resultado2 = $aspersores -> createAspersor($aspersor['codigo_producto'], $aspersor['caudal_minimo'], $aspersor['caudal_maximo'],
                $aspersor['presion_minima'], $aspersor['presion_maxima'],
                $aspersor['alcance_minimo'], $aspersor['alcance_maximo']);
            $datos = $aspersores -> readAspersor();
            include('views/productos/aspersores/index.php');
            break;
        case 'eliminar':
            $id_aspersor = $_GET['codigo_producto'];
            $resultado = $aspersores -> delete($id_aspersor, 'aspersor');
            $datos = $aspersores -> readAspersor();
            include('views/productos/aspersores/index.php');
            break;
        case 'ver':
            $id_aspersor = $_GET['codigo_producto'];
            $datos = $aspersores -> readOneAspersor($id_aspersor);
            include('views/productos/aspersores/form.php');
            break;
        case 'actualizar':
            $aspersor = $_POST['aspersor'];
            $resultado = $aspersores -> updateProducto($aspersor['codigo_producto'], $aspersor['producto'], $aspersor['costo'],
                $aspersor['descripcion'], $aspersor['id_marca'], $aspersor['id_unidad']);
            $resultado2 = $aspersores -> updateAspersor($aspersor['codigo_producto'], $aspersor['caudal_minimo'], $aspersor['caudal_maximo'],
                $aspersor['presion_minima'], $aspersor['presion_maxima'],
                $aspersor['alcance_minimo'], $aspersor['alcance_maximo']);
            $datos = $aspersores -> readAspersor();
            include('views/productos/aspersores/index.php');
            break;*/
        case 'guardar_factura':
            $id_servicios = $_POST['id_servicios'];
            $montos = $_POST['montos'];
            $factura_servicio = $_POST['factura_servicio'];
            $resultado = $factura_servicios -> createFacturaServicio($id_servicios, $montos, $factura_servicio['rfc'], $factura_servicio['descripcion'], $factura_servicio['domicilio']);
            $datos = $factura_servicios -> readFactura();
            break;
        case 'ver_estatus':
            $id_factura = $_GET['id_factura'];
            $datos = $factura_servicios -> readOneFactura($id_factura);
            break;
        case 'actuallizar_estatus':
            $estatus = $_POST['factura'];
            $resultado = $factura_servicios -> changeStatus($estatus['id_factura'], $estatus['id_estatus_factura']);
            $datos = $factura_servicios -> readFactura();
            break;
        default:
            $_GET['action'] = 'leer';
            $datos = $factura_servicios -> readFactura();
    }
    include('views/facturas/facturas_servicios/index.php');
    include('views/facturas/cambiar_estatus.php');
    include('views/facturas/facturas_servicios/form.php');
?>