<?php
    include('controllers/productos/caracteristicas/formas_aspersion.controller.php');
    $formas_aspersion = new FormaAspersion;
    $accion = (isset($_GET['action']))?$_GET['action']:'leer';
    include('views/sidebar_navigation.php');
    
    switch($accion)
    {
        case 'guardar':
            $forma_aspersion = $_POST['forma_aspersion'];
            $resultado = $formas_aspersion -> create($forma_aspersion['forma_aspersion']);
            $datos = $formas_aspersion -> read();
            break;
        case 'eliminar':
            $id_forma_aspersion = $_GET['id_forma_aspersion'];
            $resultado = $formas_aspersion -> delete($id_forma_aspersion);
            $datos = $formas_aspersion -> read();
            break;
        case 'ver':
            $id_forma_aspersion = $_GET['id_forma_aspersion'];
            $datos = $formas_aspersion -> readOne($id_forma_aspersion);
            break;
        case 'actualizar':
            $forma_aspersion = $_POST['forma_aspersion'];
            $resultado = $formas_aspersion -> update($forma_aspersion['id_forma_aspersion'], $forma_aspersion['forma_aspersion']);
            $datos = $formas_aspersion -> read();
            break;
        default:
            $_GET['action'] = 'leer';
            $datos = $formas_aspersion -> read();
    }
    include('views/productos/caracteristicas/formas_aspersion/index.php');
    include('views/productos/caracteristicas/formas_aspersion/form.php');
?>