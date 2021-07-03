<?php
    include('controllers/productos/caracteristicas/unidades.controller.php');
    include('controllers/sistema.controller.php');
    $ptos = array();
    array_push($ptos, 'Administrador');
    array_push($ptos, 'Encargado de Almacen');
    $sistema = New Sistema;
    $sistema -> verificarPuesto($ptos);
    $unidades = new Unidad;
    $accion = (isset($_GET['action']))?$_GET['action']:'leer';
    include('views/sidebar_navigation.php');

    switch($accion)
    {
        case 'guardar':
            $unidad = $_POST['unidad'];
            $resultado = $unidades -> create($unidad['unidad']);
            $datos = $unidades -> read();
            include('views/alert.php');
            break;
        case 'eliminar':
            $id_unidad = $_GET['id_unidad'];
            $resultado = $unidades -> delete($id_unidad);
            $datos = $unidades -> read();
            include('views/alert.php');
            break;
        case 'ver':
            $id_unidad = $_GET['id_unidad'];
            $datos = $unidades -> readOne($id_unidad);
            break;
        case 'actualizar':
            $unidad = $_POST['unidad'];
            $resultado = $unidades -> update($unidad['id_unidad'], $unidad['unidad']);
            $datos = $unidades -> read();
            include('views/alert.php');
            break;
        default:
            $_GET['action'] = 'leer';
            $datos = $unidades -> read();
    }
    include('views/productos/caracteristicas/unidades/index.php');
    include('views/productos/caracteristicas/unidades/form.php');
    include('views/footer.php');
?>