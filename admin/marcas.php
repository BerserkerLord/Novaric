<?php
    include('controllers/marcas.controller.php');
    $marcas = new marca;
    $accion = (isset($_GET['action']))?$_GET['action']:'leer';
    include('views/sidebar_navigation.php');

    switch($accion)
    {
        case 'guardar':
            $marca = $_POST['marca'];
            $resultado = $marcas -> create($marca['marca']);
            $datos = $marcas -> read();
            break;
        case 'eliminar':
            $id_marca = $_GET['id_marca'];
            $resultado = $marcas -> delete($id_marca);
            $datos = $marcas -> read();
            break;
        case 'ver':
            $id_marca = $_GET['id_marca'];
            $datos = $marcas -> readOne($id_marca);
            break;
        case 'actualizar':
            $marca = $_POST['marca'];
            $resultado = $marcas -> update($marca['id_marca'], $marca['marca']);
            $datos = $marcas -> read();
            break;
        default:
            $_GET['action'] = 'leer';
            $datos = $marcas -> read();
    }
    include('views/marcas/index.php');
    include('views/marcas/form.php');
?>