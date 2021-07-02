<?php
    include('controllers/productos/caracteristicas/tipos_boquilla.controller.php');
    $tipos_boquilla = new TipoBoquilla;
    $accion = (isset($_GET['action']))?$_GET['action']:'leer';
    include('views/sidebar_navigation.php');

    switch($accion)
    {
        case 'guardar':
            $tipo_boquilla = $_POST['tipo_boquilla'];
            $resultado = $tipos_boquilla -> create($tipo_boquilla['tipo_boquilla']);
            $datos = $tipos_boquilla -> read();
            break;
        case 'eliminar':
            $id_tipo_boquilla = $_GET['id_tipo_boquilla'];
            $resultado = $tipos_boquilla -> delete($id_tipo_boquilla);
            $datos = $tipos_boquilla -> read();
            break;
        case 'ver':
            $id_tipo_boquilla = $_GET['id_tipo_boquilla'];
            $datos = $tipos_boquilla -> readOne($id_tipo_boquilla);
            break;
        case 'actualizar':
            $tipo_boquilla = $_POST['tipo_boquilla'];
            $resultado = $tipos_boquilla -> update($tipo_boquilla['id_tipo_boquilla'], $tipo_boquilla['tipo_boquilla']);
            $datos = $tipos_boquilla -> read();
            break;
        default:
            $_GET['action'] = 'leer';
            $datos = $tipos_boquilla -> read();
    }
    include('views/productos/caracteristicas/tipos_boquilla/index.php');
    include('views/productos/caracteristicas/tipos_boquilla/form.php');
    include('views/footer.php');
?>