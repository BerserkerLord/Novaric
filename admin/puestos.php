<?php
    include('controllers/puestos.controller.php');
    include('controllers/departamentos.controller.php');
    $puestos = new  Puesto;
    $departamentos = new Departamento;
    $accion = (isset($_GET['action']))?$_GET['action']:'leer';
    include('views/sidebar_navigation.php');
    $departamento = $departamentos -> read();

    switch($accion)
    {
        case 'guardar':
            $puesto = $_POST['puesto'];
            $resultado = $puestos -> create($puesto['puesto'], $puesto['id_departamento']);
            $datos = $puestos -> read();
            break;
        case 'eliminar':
            $id_puesto = $_GET['id_puesto'];
            $resultado = $puestos -> delete($id_puesto);
            $datos = $puestos -> read();
            break;
        case 'ver':
            $id_puesto = $_GET['id_puesto'];
            $datos = $puestos -> readOne($id_puesto);
            break;
        case 'actualizar':
            $puesto = $_POST['puesto'];
            $resultado = $puestos -> update($puesto['id_puesto'], $puesto['puesto'], $puesto['id_departamento']);
            $datos = $puestos -> read();
            break;
        default:
            $_GET['action'] = 'leer';
            $datos = $puestos -> read();
    }
    include('views/puestos/index.php');
    include('views/puestos/form.php');
?>