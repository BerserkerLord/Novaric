<?php
    include('controllers/departamentos.controller.php');
    $departamentos = new Departamento;
    $accion = (isset($_GET['action']))?$_GET['action']:'leer';
    include('views/sidebar_navigation.php');

    switch($accion)
    {
        case 'guardar':
            $departamento = $_POST['departamento'];
            $resultado = $departamentos -> create($departamento['departamento']);
            $datos = $departamentos -> read();
            include('views/alert.php');
            break;
        case 'eliminar':
            $id_departamento = $_GET['id_departamento'];
            $resultado = $departamentos -> delete($id_departamento);
            $datos = $departamentos -> read();
            include('views/alert.php');
            break;
        case 'ver':
            $id_departamento = $_GET['id_departamento'];
            $datos = $departamentos -> readOne($id_departamento);
            break;
        case 'actualizar':
            $departamento = $_POST['departamento'];
            $resultado = $departamentos -> update($departamento['id_departamento'], $departamento['departamento']);
            $datos = $departamentos -> read();
            include('views/alert.php');
            break;
        default:
            $_GET['action'] = 'leer';
            $datos = $departamentos -> read();
    }
    include('views/departamentos/index.php');
    include('views/departamentos/form.php');
    include('views/footer.php');
?>