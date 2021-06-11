<?php
    include('controllers/productos/productos.controller.php');
    $productos = new Producto;
    $entradas = $productos -> readEntradas();
    include('views/sidebar_navigation.php');
    include('views/inventario/entradas.php');
    include('views/footer.php');
?>