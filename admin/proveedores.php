<?php
    include('controllers/proveedores.controller.php');
    $ptos = array();
    array_push($ptos, 'Administrador');
    array_push($ptos, 'Encargado de Inventario');
    $sistema = New Sistema;
    $sistema -> verificarPuesto($ptos);
    $proveedores = new Proveedor;
    $accion = (isset($_GET['action']))?$_GET['action']:'leer';
    include('views/sidebar_navigation.php');
    
    switch($accion)
    {
        case 'guardar':
            $proveedor = $_POST['proveedor'];
            $resultado = $proveedores -> create($proveedor['rfc'], $proveedor['razon_social'], $proveedor['domicilio'], $proveedor['telefono']);
            $datos = $proveedores -> read();
            include('views/alert.php');
            break;
        case 'eliminar':
            $rfc = $_GET['rfc'];
            $resultado = $proveedores -> delete($rfc);
            $datos = $proveedores -> read();
            include('views/alert.php');
            break;
        case 'ver':
            $rfc = $_GET['rfc'];
            $datos = $proveedores -> readOne($rfc);
            break;
        case 'actualizar':
            $proveedor = $_POST['proveedor'];
            $resultado = $proveedores -> update($proveedor['rfc'], $proveedor['razon_social'], $proveedor['domicilio'], $proveedor['telefono']);
            $datos = $proveedores -> read();
            include('views/alert.php');
            break;
        default:
            $_GET['action'] = 'leer';
            $datos = $proveedores -> read();
    }
    include('views/proveedores/index.php');
    include('views/proveedores/form.php');
    include('views/footer.php');
?>