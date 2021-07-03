<?php
    /*
     * Pagina de bienvenida al hacer login
     */
    include('controllers/sistema.controller.php');
    $sistema = new Sistema;
    $sistema -> verificarSesion();
    include('views/sidebar_navigation.php');
?>
    <h1>Bienvenido al sistema</h1>
<?php
    include('views/footer.php');
?>