<!doctype html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Dario Zarate">
        <meta name="description" content="Hospital San Juan">
        <meta name="keywords" content="hospital san juan doctores especialidad">
        <title>Novaric</title>
        <link href="../css/bootstrap/css/bootstrap.css" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">
        <link href="../css/main.css" rel="stylesheet">
        <link href="../css/fontawesome/css/all.css" rel="stylesheet">
        <link href="../css/features.css" rel="stylesheet">
        <script src="../css/bootstrap/js/bootstrap.js"></script>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-success">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarScroll">
                    <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Inicio</a></li>
                        <?php
                            if($sistema -> validarPuesto('Administrador')){
                                include('menus/menu.administrador.php');
                            }
                            if($sistema -> validarPuesto('Contador')){
                                include('menus/menu.contador.php');
                            }
                            if($sistema -> validarPuesto('RH')){
                                include('menus/menu.rh.php');
                            }
                            if($sistema -> validarPuesto('Encrgado de Inventario')){
                                include('menus/menu.inventario.php');
                            }
                            if($sistema -> validarPuesto('Encargado de Almacen')){
                                include('menus/menu.almacen.php');
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>






