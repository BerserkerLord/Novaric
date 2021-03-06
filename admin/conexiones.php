<?php
    include('controllers/productos/conexiones.controller.php');
    include('controllers/marcas.controller.php');
    include('controllers/productos/caracteristicas/unidades.controller.php');
    include('controllers/productos/caracteristicas/extremidades.controller.php');
    include('controllers/productos/caracteristicas/formas_conexion.controller.php');
    $ptos = array();
    array_push($ptos, 'Administrador');
    array_push($ptos, 'Encargado de Almacen');
    $sistema = New Sistema;
    $sistema -> verificarPuesto($_SESSION['puestos']);
    $conexiones = new Conexion;
    $marca = new Marca;
    $unidad = new Unidad;
    $extremidad = new Extremidad;
    $forma_conexion = new FormaConexion;
    $accion = (isset($_GET['action']))?$_GET['action']:'leer';
    $marcas = $marca -> readAll();
    $unidades = $unidad -> readAll();
    $extremidades = $extremidad -> readAll();
    $formas_conexion = $forma_conexion -> readAll();
    include('views/sidebar_navigation.php');

    switch($accion)
    {
        case 'crear':
            include('views/productos/conexiones/form.php');
            break;
        case 'guardar':
            $conexion = $_POST['conexion'];
            $resultado = $conexiones -> createConexion($conexion['codigo_producto'], $conexion['producto'], $conexion['costo'],
                                                        $conexion['descripcion'], $conexion['existencias'],
                                                        $conexion['id_marca'], $conexion['id_unidad'], $conexion['diametro'],
                                                        $conexion['id_forma_conexion'], $conexion['id_extremidad1'], $conexion['id_extremidad2']);
            $datos = $conexiones -> readConexion();
            include('views/alert.php');
            include('views/productos/conexiones/index.php');
            break;
        case 'eliminar':
            $id_conexion = $_GET['codigo_producto'];
            $resultado = $conexiones -> delete($id_conexion, 'conexion');
            $datos = $conexiones -> readConexion();
            include('views/alert.php');
            include('views/productos/conexiones/index.php');
            break;
        case 'ver':
            $id_conexion = $_GET['codigo_producto'];
            $datos = $conexiones -> readOneConexion($id_conexion);
            include('views/productos/conexiones/form.php');
            break;
        case 'actualizar':
            $conexion = $_POST['conexion'];
            $resultado = $conexiones -> updateConexion($conexion['codigo_producto'], $conexion['producto'], $conexion['costo'],
                                                        $conexion['descripcion'], $conexion['id_marca'], $conexion['id_unidad'],
                                                        $conexion['diametro'], $conexion['id_forma_conexion'], $conexion['id_extremidad1'], $conexion['id_extremidad2']);
            $datos = $conexiones -> readConexion();
            include('views/alert.php');
            include('views/productos/conexiones/index.php');
            break;
        default:
            $datos = $conexiones -> readConexion();
            include('views/productos/conexiones/index.php');
    }
    include('views/footer.php');
?>