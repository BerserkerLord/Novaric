<?php
    include('controllers/productos/tuberias.controller.php');
    include('controllers/marcas.controller.php');
    include('controllers/productos/caracteristicas/unidades.controller.php');
    include('controllers/productos/caracteristicas/extremidades.controller.php');
    $tuberias = new Tuberia;
    $marca = new Marca;
    $unidad = new Unidad;
    $extremidad = new Extremidad;
    $accion = (isset($_GET['action']))?$_GET['action']:'leer';
    $marcas = $marca -> read();
    $unidades = $unidad -> read();
    $extremidades = $extremidad -> read();
    include('views/sidebar_navigation.php');

    switch($accion)
    {
        case 'crear':
            include('views/productos/tuberias/form.php');
            break;
        case 'guardar':
            $tuberia = $_POST['tuberia'];
            $resultado = $tuberias -> createProducto($tuberia['codigo_producto'], $tuberia['producto'], $tuberia['costo'],
                                             $tuberia['descripcion'], $tuberia['existencias'], $tuberia['id_marca'],
                                             $tuberia['id_unidad']);
            $resultado2 = $tuberias -> createTuberia($tuberia['codigo_producto'], $tuberia['diametro'], $tuberia['longitud'],
                                                     $tuberia['id_extremidad1'], $tuberia['id_extremidad2']);
            $datos = $tuberias -> readTuberia();
            include('views/productos/tuberias/index.php');
            break;
        case 'eliminar':
            $id_tuberia = $_GET['codigo_producto'];
            $resultado = $tuberias -> delete($id_tuberia, 'tuberia');
            $datos = $tuberias -> readTuberia();
            include('views/productos/tuberias/index.php');
            break;
        case 'ver':
            $id_tuberia = $_GET['codigo_producto'];
            $datos = $tuberias -> readOneTuberia($id_tuberia);
            include('views/productos/tuberias/form.php');
            break;
        case 'actualizar':
            $tuberia = $_POST['tuberia'];
            $resultado = $tuberias -> updateProducto($tuberia['codigo_producto'], $tuberia['producto'], $tuberia['costo'],
                                             $tuberia['descripcion'], $tuberia['id_marca'], $tuberia['id_unidad']);
            $resultado2 = $tuberias -> updateTuberia($tuberia['codigo_producto'], $tuberia['diametro'], $tuberia['longitud'],
                                                     $tuberia['id_extremidad1'], $tuberia['id_extremidad2']);
            $datos = $tuberias -> readTuberia();
            include('views/productos/tuberias/index.php');
            break;
        default:
            $datos = $tuberias -> readTuberia();
            include('views/productos/tuberias/index.php');
    }
?>