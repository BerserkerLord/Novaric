<?php
    include('controllers/clientes.controller.php');
    $ptos = array();
    array_push($ptos, 'Administrador');
    array_push($ptos, 'Contador');
    $sistema = New Sistema;
    $sistema -> verificarPuesto($_SESSION['puestos']);
    $clientes = new Cliente;
    $accion = (isset($_GET['action']))?$_GET['action']:'leer';
    include('views/sidebar_navigation.php');
    
    switch($accion)
    {
        case 'crear':
            include('views/clientes/form.php');
            break;
        case 'guardar':
            $cliente = $_POST['cliente'];
            $resultado = $clientes -> create($cliente['rfc'], $cliente['nombre'], $cliente['apaterno'],
                $cliente['amaterno'], $cliente['email'], $cliente['telefono'],
                $cliente['domicilio']);
            $datos = $clientes -> read();
            include('views/alert.php');
            include('views/clientes/index.php');
            break;
        case 'eliminar':
            $rfc = $_GET['rfc'];
            $resultado = $clientes -> delete($rfc);
            $datos = $clientes -> read();
            include('views/alert.php');
            include('views/clientes/index.php');
            break;
        case 'ver':
            $rfc = $_GET['rfc'];
            $datos = $clientes -> readOne($rfc);
            include('views/clientes/form.php');
            break;
        case 'actualizar':
            $cliente = $_POST['cliente'];
            $resultado = $clientes -> update($cliente['rfc'], $cliente['nombre'], $cliente['apaterno'],
                $cliente['amaterno'], $cliente['email'], $cliente['telefono'],
                $cliente['domicilio']);
            $datos = $clientes -> read();
            include('views/alert.php');
            include('views/clientes/index.php');
            break;
        default:
            $datos = $clientes -> read();
            include('views/clientes/index.php');
    }
    include('views/footer.php');
?>