<?php
    include('controllers/puestos.controller.php');
    include('controllers/departamentos.controller.php');
$ptos = array();
array_push($ptos, 'Administrador');
array_push($ptos, 'RH');
$sistema = New Sistema;
$sistema -> verificarPuesto($ptos);
    $puestos = new  Puesto;
    $departamentos = new Departamento;
    $accion = (isset($_GET['action']))?$_GET['action']:'leer';
    include('views/sidebar_navigation.php');
    $departamento = $departamentos -> readAll();

    switch($accion)
    {
        case 'guardar':
            $puesto = $_POST['puesto'];
            $resultado = $puestos -> create($puesto['puesto'], $puesto['id_departamento']);
            $datos = $puestos -> read();
            include('views/alert.php');
            break;
        case 'eliminar':
            $id_puesto = $_GET['id_puesto'];
            $resultado = $puestos -> delete($id_puesto);
            $datos = $puestos -> read();
            include('views/alert.php');
            break;
        case 'ver':
            $id_puesto = $_GET['id_puesto'];
            $datos = $puestos -> readOne($id_puesto);
            break;
        case 'actualizar':
            $puesto = $_POST['puesto'];
            $resultado = $puestos -> update($puesto['id_puesto'], $puesto['puesto'], $puesto['id_departamento']);
            $datos = $puestos -> read();
            include('views/alert.php');
            break;
        default:
            $_GET['action'] = 'leer';
            $datos = $puestos -> read();
    }
    include('views/puestos/index.php');
    include('views/puestos/form.php');
    include('views/footer.php');
?>