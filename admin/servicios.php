<?php
    include('controllers/servicios.controller.php');
    $servicios = new Servicio;
    $accion = (isset($_GET['action']))?$_GET['action']:'leer';
    include('views/sidebar_navigation.php');

    switch($accion)
    {
        case 'guardar':
            $servicio = $_POST['servicio'];
            $resultado = $servicios -> create($servicio['servicio'], $servicio['descripcion']);
            $datos = $servicios -> read();
            include('views/alert.php');
            break;
        case 'eliminar':
            $id_servicio = $_GET['id_servicio'];
            $resultado = $servicios -> delete($id_servicio);
            $datos = $servicios -> read();
            include('views/alert.php');
            break;
        case 'ver':
            $id_servicio = $_GET['id_servicio'];
            $datos = $servicios -> readOne($id_servicio);
            break;
        case 'actualizar':
            $servicio = $_POST['servicio'];
            $resultado = $servicios -> update($servicio['id_servicio'], $servicio['servicio'], $servicio['descripcion']);
            $datos = $servicios -> read();
            include('views/alert.php');
            break;
        default:
            $_GET['action'] = 'leer';
            $datos = $servicios -> read();

    }
    include('views/servicios/index.php');
    include('views/servicios/form.php');
    include('views/footer.php');
?>