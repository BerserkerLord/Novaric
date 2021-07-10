<?php
    include('controllers/empleados.controller.php');
    include('controllers/puestos.controller.php');
    $ptos = array();
    array_push($ptos, 'Administrador');
    array_push($ptos, 'Director de Recursos Humanos');
    $sistema = New Sistema;
    $sistema -> verificarPuesto($ptos);
    $empleados = new Empleado;
    $puestos = new Puesto;
    $accion = (isset($_GET['action']))?$_GET['action']:'leer';
    include('views/sidebar_navigation.php');
    $puesto = $puestos -> readAll();

    switch($accion)
    {
        case 'guardar':
            $empleado = $_POST['empleado'];
            $resultado = $empleados -> create($empleado['rfc'], $empleado['nombre'], $empleado['apaterno'], $empleado['amaterno'],
                                              $empleado['direccion'], null, $empleado['correo'],
                                              $empleado['contrasenia'], $empleado['id_puesto']);
            $datos = $empleados -> read();
            include('views/alert.php');
            break;
        case 'eliminar':
            $rfc = $_GET['rfc'];
            $resultado = $empleados -> delete($rfc);
            $datos = $empleados -> read();
            include('views/alert.php');
            break;
        case 'ver':
            $rfc = $_GET['rfc'];
            $datos = $empleados -> readOne($rfc);
            break;
        case 'actualizar':
            $empleado = $_POST['empleado'];
            $resultado = $empleados -> update($empleado['rfc'], $empleado['nombre'], $empleado['apaterno'], $empleado['amaterno'],
                                              $empleado['direccion'], null, $empleado['correo'],
                                              $empleado['id_puesto']);
            $datos = $empleados -> read();
            include('views/alert.php');
            break;
        default:
            $_GET['action'] = 'leer';
            $datos = $empleados -> read();
    }
    include('views/empleados/index.php');
    include('views/empleados/form.php');
    include('views/footer.php');
?>