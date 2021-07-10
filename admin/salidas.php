<?php
    include('controllers/productos/productos.controller.php');
    $ptos = array();
    array_push($ptos, 'Administrador');
    array_push($ptos, 'Encargado de Inventario');
    $sistema = New Sistema;
    $sistema -> verificarPuesto($ptos);
    $productos = new Producto;
    $salidas = $productos -> readSalidas();
    include('views/sidebar_navigation.php');
    include('views/inventario/salidas.php');
    include('views/footer.php');
?>