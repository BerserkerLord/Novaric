<?php
    include('controllers/empleados.controller.php');
    include('controllers/puestos.controller.php');
    $empleados = new Empleado;
    $puestos = new Puesto;
    $accion = (isset($_GET['action']))?$_GET['action']:'leer';
    include('views/sidebar_navigation.php');
    $puesto = $puestos -> read();

    switch($accion)
    {
        case 'guardar':
            $empleado = $_POST['empleado'];
            $resultado = $empleados -> create($empleado['rfc'], $empleado['nombre'], $empleado['apaterno'], $empleado['amaterno'],
                                              $empleado['direccion'], $empleado['usuario'], $empleado['correo'],
                                              $empleado['contrasenia'], $empleado['id_puesto']);
            $datos = $empleados -> read();
            break;
        case 'eliminar':
            $rfc = $_GET['rfc'];
            $resultado = $empleados -> delete($rfc);
            $datos = $empleados -> read();
            break;
        case 'ver':
            $rfc = $_GET['rfc'];
            $datos = $empleados -> readOne($rfc);
            break;
        case 'actualizar':
            $empleado = $_POST['empleado'];
            $resultado = $empleados -> update($empleado['rfc'], $empleado['nombre'], $empleado['apaterno'], $empleado['amaterno'],
                                              $empleado['direccion'], $empleado['usuario'], $empleado['correo'],
                                              $empleado['contrasenia'],$empleado['id_puesto']);
            $datos = $empleados -> read();
            break;
        default:
            $_GET['action'] = 'leer';
            $datos = $empleados -> read();
    }
    include('views/empleados/index.php');
    include('views/empleados/form.php');
?>