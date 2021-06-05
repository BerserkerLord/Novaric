<?php
    include('controllers/productos/programadores.controller.php');
    include('controllers/marcas.controller.php');
    include('controllers/productos/caracteristicas/unidades.controller.php');
    $programadores = new Programador;
    $marca = new Marca;
    $unidad = new Unidad;
    $accion = (isset($_GET['action']))?$_GET['action']:'leer';
    $marcas = $marca -> read();
    $unidades = $unidad -> read();
    include('views/sidebar_navigation.php');
    
    switch($accion)
    {
        case 'crear':
            include('views/productos/programadores/form.php');
            break;
        case 'guardar':
            $programador = $_POST['programador'];
            $resultado = $programadores -> createProducto($programador['codigo_producto'], $programador['producto'], $programador['costo'],
                $programador['descripcion'], $programador['existencias'], $programador['id_marca'], $programador['id_unidad']);
            $resultado2 = $programadores -> createProgramador($programador['codigo_producto'], $programador['maximo_estaciones'], $programador['entradas_sensores'],
                $programador['entrada_transformador'], $programador['salida_transformador'], $programador['salida_estacion'], $programador['salida_p_mv']);
            $datos = $programadores -> readProgramador();
            include('views/productos/programadores/index.php');
            break;
        case 'eliminar':
            $id_programador = $_GET['codigo_producto'];
            $resultado = $programadores -> delete($id_programador, 'programador');
            $datos = $programadores -> readProgramador();
            include('views/productos/programadores/index.php');
            break;
        case 'ver':
            $id_programador = $_GET['codigo_producto'];
            $datos = $programadores -> readOneProgramador($id_programador);
            include('views/productos/programadores/form.php');
            break;
        case 'actualizar':
            $programador = $_POST['programador'];
            $resultado = $programadores -> updateProducto($programador['codigo_producto'], $programador['producto'], $programador['costo'],
                $programador['descripcion'], $programador['id_marca'], $programador['id_unidad']);
            $resultado2 = $programadores -> updateProgramador($programador['codigo_producto'], $programador['maximo_estaciones'], $programador['entradas_sensores'],
                $programador['entrada_transformador'], $programador['salida_transformador'], $programador['salida_estacion'], $programador['salida_p_mv']);
            $datos = $programadores -> readProgramador();
            include('views/productos/programadores/index.php');
            break;
        default:
            $datos = $programadores -> readProgramador();
            include('views/productos/programadores/index.php');
    }
?>