<?php
    include('controllers/productos/valvulas.controller.php');
    include('controllers/marcas.controller.php');
    include('controllers/productos/caracteristicas/unidades.controller.php');
    $ptos = array();
    array_push($ptos, 'Administrador');
    array_push($ptos, 'Encargado de Almacen');
    $sistema = New Sistema;
    $sistema -> verificarPuesto($ptos);
    $valvulas = new Valvula;
    $marca = new Marca;
    $unidad = new Unidad;
    $accion = (isset($_GET['action']))?$_GET['action']:'leer';
    $marcas = $marca -> read();
    $unidades = $unidad -> read();
    include('views/sidebar_navigation.php');
    
    switch($accion)
    {
        case 'crear':
            include('views/productos/valvulas/form.php');
            break;
        case 'guardar':
            $valvula = $_POST['valvula'];
            $resultado2 = $valvulas -> createValvula($valvula['codigo_producto'], $valvula['producto'], $valvula['costo'],
                $valvula['descripcion'], $valvula['existencias'], $valvula['id_marca'],
                $valvula['id_unidad'], $valvula['temperatura_nominal'], $valvula['caudal_minimo'],
                $valvula['caudal_maximo'], $valvula['presion_minima_recomendada'], $valvula['presion_maxima_recomendada'], $valvula['especificacion_solenoide']);
            $datos = $valvulas -> readValvula();
            include('views/productos/valvulas/index.php');
            break;
        case 'eliminar':
            $id_valvula = $_GET['codigo_producto'];
            $resultado = $valvulas -> delete($id_valvula, 'valvula');
            $datos = $valvulas -> readValvula();
            include('views/productos/valvulas/index.php');
            break;
        case 'ver':
            $id_valvula = $_GET['codigo_producto'];
            $datos = $valvulas -> readOneValvula($id_valvula);
            include('views/productos/valvulas/form.php');
            break;
        case 'actualizar':
            $valvula = $_POST['valvula'];
            $resultado2 = $valvulas -> updateValvula($valvula['codigo_producto'], $valvula['producto'], $valvula['costo'],
                $valvula['descripcion'], $valvula['id_marca'], $valvula['id_unidad'], $valvula['temperatura_nominal'], $valvula['caudal_minimo'],
                $valvula['caudal_maximo'], $valvula['presion_minima_recomendada'], $valvula['presion_maxima_recomendada'], $valvula['especificacion_solenoide']);
            $datos = $valvulas -> readValvula();
            include('views/productos/valvulas/index.php');
            break;
        default:
            $datos = $valvulas -> readvalvula();
            include('views/productos/valvulas/index.php');
    }
?>