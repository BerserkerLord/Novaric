<?php
    include('controllers/productos/boquillas.controller.php');
    include('controllers/marcas.controller.php');
    include('controllers/productos/caracteristicas/unidades.controller.php');
    include('controllers/productos/caracteristicas/formas_aspersion.controller.php');
    include('controllers/productos/caracteristicas/tipos_boquilla.controller.php');
    $ptos = array();
    array_push($ptos, 'Administrador');
    array_push($ptos, 'Encargado de Almacen');
    $sistema = New Sistema;
    $sistema -> verificarPuesto($ptos);
    $boquillas = new Boquilla();
    $marca = new Marca;
    $unidad = new Unidad;
    $tipo_boquilla = new TipoBoquilla;
    $forma_aspersion = new FormaAspersion;
    $accion = (isset($_GET['action']))?$_GET['action']:'leer';
    $marcas = $marca -> read();
    $unidades = $unidad -> read();
    $tipos_boquilla = $tipo_boquilla -> read();
    $formas_aspersion = $forma_aspersion -> read();
    include('views/sidebar_navigation.php');
    
    switch($accion)
    {
        case 'crear':
            include('views/productos/boquillas/form.php');
            break;
        case 'guardar':
            $boquilla = $_POST['boquilla'];
            $resultado = $boquillas -> createBoquilla($boquilla['codigo_producto'], $boquilla['producto'], $boquilla['costo'],
                $boquilla['descripcion'], $boquilla['existencias'], $boquilla['id_marca'], $boquilla['id_unidad'], $boquilla['caudal_minimo'], $boquilla['caudal_maximo'],
                $boquilla['presion_minima'], $boquilla['presion_maxima'], $boquilla['radio_minimo'],
                $boquilla['radio_maximo'], $boquilla['trayectoria'], $boquilla['ajuste'],
                $boquilla['id_tipo_boquilla'], $boquilla['id_forma_aspersion']);
            $datos = $boquillas -> readboquilla();
            include('views/productos/boquillas/index.php');
            break;
        case 'eliminar':
            $id_boquilla = $_GET['codigo_producto'];
            $resultado = $boquillas -> delete($id_boquilla, 'boquilla');
            $datos = $boquillas -> readBoquilla();
            include('views/productos/boquillas/index.php');
            break;
        case 'ver':
            $id_boquilla = $_GET['codigo_producto'];
            $datos = $boquillas -> readOneBoquilla($id_boquilla);
            include('views/productos/boquillas/form.php');
            break;
        case 'actualizar':
            $boquilla = $_POST['boquilla'];
            $resultado2 = $boquillas -> updateBoquilla($boquilla['codigo_producto'], $boquilla['producto'], $boquilla['costo'],
                $boquilla['descripcion'], $boquilla['existencias'], $boquilla['id_marca'], $boquilla['id_unidad'], $boquilla['caudal_minimo'], $boquilla['caudal_maximo'],
                $boquilla['presion_minima'], $boquilla['presion_maxima'], $boquilla['radio_minimo'],
                $boquilla['radio_maximo'], $boquilla['trayectoria'], $boquilla['ajuste'],
                $boquilla['id_tipo_boquilla'], $boquilla['id_forma_aspersion']);
            $datos = $boquillas -> readBoquilla();
            include('views/productos/boquillas/index.php');
            break;
        default:
            $datos = $boquillas -> readBoquilla();
            include('views/productos/boquillas/index.php');
    }
?>