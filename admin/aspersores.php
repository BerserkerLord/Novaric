<?php
    include('controllers/productos/aspersores.controller.php');
    include('controllers/marcas.controller.php');
    include('controllers/productos/caracteristicas/unidades.controller.php');
    $aspersores = new Aspersor;
    $marca = new Marca;
    $unidad = new Unidad;
    $accion = (isset($_GET['action']))?$_GET['action']:'leer';
    $marcas = $marca -> read();
    $unidades = $unidad -> read();
    include('views/sidebar_navigation.php');

    switch($accion)
    {
        case 'crear':
            include('views/productos/aspersores/form.php');
            break;
        case 'guardar':
            $aspersor = $_POST['aspersor'];
            $resultado = $aspersores -> createAspersor($aspersor['codigo_producto'], $aspersor['producto'], $aspersor['costo'],
                $aspersor['descripcion'], $aspersor['existencias'], $aspersor['id_marca'], $aspersor['id_unidad'], $aspersor['caudal_minimo'], $aspersor['caudal_maximo'],
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
            $resultado = $aspersores -> updateAspersor($aspersor['codigo_producto'], $aspersor['caudal_minimo'], $aspersor['caudal_maximo'],
                $aspersor['presion_minima'], $aspersor['presion_maxima'], $aspersor['alcance_minimo'], $aspersor['alcance_maximo'], $aspersor['producto'],
                $aspersor['costo'], $aspersor['descripcion'], $aspersor['id_marca'], $aspersor['id_unidad']);
            $datos = $aspersores -> readAspersor();
            include('views/productos/aspersores/index.php');
            break;
        default:
            $datos = $aspersores -> readAspersor();
            include('views/productos/aspersores/index.php');
    }
?>