<?php
    include('controllers/clientes_servicio.controller.php');
    include('controllers/sistema.controller.php');
    $ptos = array();
    array_push($ptos, 'Administrador');
    array_push($ptos, 'Contador');
    $sistema = New Sistema;
    $sistema -> verificarPuesto($ptos);
    $clientes_servicio = new ClienteServicio;
    $accion = (isset($_GET['action']))?$_GET['action']:'leer';
    include('views/sidebar_navigation.php');
    
    switch($accion)
    {
        case 'crear':
            include('views/clientes_servicio/form.php');
            break;
        case 'guardar':
            $cliente_servicio = $_POST['cliente_servicio'];
            $resultado = $clientes_servicio -> create($cliente_servicio['rfc'], $cliente_servicio['nombre'], $cliente_servicio['apaterno'],
                $cliente_servicio['amaterno'], $cliente_servicio['email'], $cliente_servicio['telefono'],
                $cliente_servicio['domicilio']);
            $datos = $clientes_servicio -> read();
            include('views/clientes_servicio/index.php');
            break;
        case 'eliminar':
            $rfc = $_GET['rfc'];
            $resultado = $clientes_servicio -> delete($rfc);
            $datos = $clientes_servicio -> read();
            include('views/clientes_servicio/index.php');
            break;
        case 'ver':
            $rfc = $_GET['rfc'];
            $datos = $clientes_servicio -> readOne($rfc);
            include('views/clientes_servicio/form.php');
            break;
        case 'actualizar':
            $cliente_servicio = $_POST['cliente_servicio'];
            $resultado = $clientes_servicio -> update($cliente_servicio['rfc'], $cliente_servicio['nombre'], $cliente_servicio['apaterno'],
                $cliente_servicio['amaterno'], $cliente_servicio['email'], $cliente_servicio['telefono'],
                $cliente_servicio['domicilio']);
            $datos = $clientes_servicio -> read();
            include('views/clientes_servicio/index.php');
            break;
        default:
            $datos = $clientes_servicio -> read();
            include('views/clientes_servicio/index.php');
    }
    include('views/footer.php');
?>