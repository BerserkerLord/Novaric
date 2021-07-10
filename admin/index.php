<?php
    /*
     * Pagina de bienvenida al hacer login
     */
    include('controllers/sistema.controller.php');
    $sistema = new Sistema;
    $sistema -> verificarSesion();
    include('views/sidebar_navigation.php');
    echo '<h1>Bienvenido al sistema</h1>';
    include('views/footer.php');
?>