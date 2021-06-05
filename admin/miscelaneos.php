<?php
    include('controllers/productos/miscelaneos.controller.php');
    include('controllers/marcas.controller.php');
    include('controllers/productos/caracteristicas/unidades.controller.php');
    $miscelaneos = new Miscelaneo;
    $marca = new Marca;
    $unidad = new Unidad;
    $accion = (isset($_GET['action']))?$_GET['action']:'leer';
    $marcas = $marca -> read();
    $unidades = $unidad -> read();
    include('views/sidebar_navigation.php');

    switch($accion)
    {
        case 'crear':
            include('views/productos/miscelaneos/form.php');
            break;
        case 'guardar':
            $miscelaneo = $_POST['miscelaneo'];
            $resultado = $miscelaneos -> createMiscelaneo($miscelaneo['codigo_producto'], $miscelaneo['producto'], $miscelaneo['costo'],
                $miscelaneo['descripcion'], $miscelaneo['existencias'], $miscelaneo['id_marca'],
                $miscelaneo['id_unidad']);
            $datos = $miscelaneos -> readMiscelaneo();
            include('views/productos/miscelaneos/index.php');
            break;
        case 'eliminar':
            $id_miscelaneo = $_GET['codigo_producto'];
            $resultado = $miscelaneos -> delete($id_miscelaneo, 'miscelaneo');
            $datos = $miscelaneos -> readMiscelaneo();
            include('views/productos/miscelaneos/index.php');
            break;
        case 'ver':
            $id_miscelaneo = $_GET['codigo_producto'];
            $datos = $miscelaneos -> readOneMiscelaneo($id_miscelaneo);
            include('views/productos/miscelaneos/form.php');
            break;
        case 'actualizar':
            $miscelaneo = $_POST['miscelaneo'];
            $resultado = $miscelaneos -> updateMiscelaneo($miscelaneo['codigo_producto'], $miscelaneo['producto'], $miscelaneo['costo'],
                $miscelaneo['descripcion'], $miscelaneo['id_marca'], $miscelaneo['id_unidad']);
            $datos = $miscelaneos -> readMiscelaneo();
            include('views/productos/miscelaneos/index.php');
            break;
        default:
            $datos = $miscelaneos -> readMiscelaneo();
            include('views/productos/miscelaneos/index.php');
    }
    include('views/footer.php');
?>