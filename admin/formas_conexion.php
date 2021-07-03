<?php
    include('controllers/productos/caracteristicas/formas_conexion.controller.php');
    $formas_conexion = new FormaConexion();
    $accion = (isset($_GET['action']))?$_GET['action']:'leer';
    include('views/sidebar_navigation.php');

    switch($accion)
    {
        case 'guardar':
            $forma_conexion = $_POST['forma_conexion'];
            $resultado = $formas_conexion -> create($forma_conexion['forma_conexion']);
            $datos = $formas_conexion -> read();
            include('views/alert.php');
            break;
        case 'eliminar':
            $id_forma_conexion = $_GET['id_forma_conexion'];
            $resultado = $formas_conexion -> delete($id_forma_conexion);
            $datos = $formas_conexion -> read();
            include('views/alert.php');
            break;
        case 'ver':
            $id_forma_conexion = $_GET['id_forma_conexion'];
            $datos = $formas_conexion -> readOne($id_forma_conexion);
            break;
        case 'actualizar':
            $forma_conexion = $_POST['forma_conexion'];
            $resultado = $formas_conexion -> update($forma_conexion['id_forma_conexion'], $forma_conexion['forma_conexion']);
            $datos = $formas_conexion -> read();
            include('views/alert.php');
            break;
        default:
            $_GET['action'] = 'leer';
            $datos = $formas_conexion -> read();
    }
    include('views/productos/caracteristicas/forma_conexion/index.php');
    include('views/productos/caracteristicas/forma_conexion/form.php');
    include('views/footer.php');
?>