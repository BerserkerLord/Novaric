<?php
    include('controllers/productos/caracteristicas/extremidades.controller.php');
    $extremidades = new Extremidad;
    $accion = (isset($_GET['action']))?$_GET['action']:'leer';
    include('views/sidebar_navigation.php');
    
    switch($accion)
    {
        case 'guardar':
            $extremidad = $_POST['extremidad'];
            $resultado = $extremidades -> create($extremidad['extremidad']);
            $datos = $extremidades -> read();
            break;
        case 'eliminar':
            $id_extremidad = $_GET['id_extremidad'];
            $resultado = $extremidades -> delete($id_extremidad);
            $datos = $extremidades -> read();
            break;
        case 'ver':
            $id_extremidad = $_GET['id_extremidad'];
            $datos = $extremidades -> readOne($id_extremidad);
            break;
        case 'actualizar':
            $extremidad = $_POST['extremidad'];
            $resultado = $extremidades -> update($extremidad['id_extremidad'], $extremidad['extremidad']);
            $datos = $extremidades -> read();
            break;
        default:
            $_GET['action'] = 'leer';
            $datos = $extremidades -> read();
    }
    include('views/productos/caracteristicas/extremidades/index.php');
    include('views/productos/caracteristicas/extremidades/form.php');
?>