<!doctype html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Dario Zarate">
        <meta name="description" content="Hospital San Juan">
        <meta name="keywords" content="hospital san juan doctores especialidad">
        <title>Dashboard</title>
        <link href="../css/bootstrap/css/bootstrap.css" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">
        <link href="../css/main.css" rel="stylesheet">
        <link href="../css/fontawesome/css/all.css" rel="stylesheet">
        <link href="../css/features.css" rel="stylesheet">
        <script src="../css/bootstrap/js/bootstrap.js"></script>
    </head>
    <body>
        <div class="side-navbar active-nav d-flex justify-content-between flex-wrap flex-column">
            <ul class="nav flex-column w-100">
                <a href="dashboard.php" id="dashboard_title" class="h3 my-3 mx-3 mb-4"><span class="mx-2"><i class="fa fa-bars p-1 icons"></i>Board</span></a>
                <a href="metricas.php" class="nav-link"><span class="mx-2"><i class="fa fa-chart-area p-1 icons"></i>Métricas</span></a>
                <a href="marcas.php" class="nav-link"><span class="mx-2"><i class="fa fa-trademark p-1 icons"></i>Marcas</span></a>
                <a href="proveedores.php" class="nav-link"><span class="mx-2"><i class="fa fa-truck p-1 icons"></i>Proveedores</span></a>
                <li>
                    <a href="" data-bs-toggle="collapse" data-target=".navbar-collapse" data-bs-target="#atrib-collapse" aria-expanded="false" class="nav-link collapsed"><span class="mx-2"><i class="fa fa-gears p-1 icons"></i>Atributos Produc.</span></a></a>
                    <div class="collapse" id="atrib-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="unidades.php" class="nav-link ps-5">Unidades</a></li>
                            <li><a href="extremidades.php" class="nav-link ps-5">Extremidades</a></li>
                            <li><a href="formas_conexion.php" class="nav-link ps-5">Formas de conexión</a></li>
                            <li><a href="tipos_boquilla.php" class="nav-link ps-5">Tipos de boquillas</a></li>
                            <li><a href="formas_aspersion.php" class="nav-link ps-5">Formas de aspersión</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="" data-bs-toggle="collapse" data-target=".navbar-collapse" data-bs-target="#productos-collapse" aria-expanded="false" class="nav-link collapsed"><span class="mx-2"><i class="fa fa-shopping-bag p-1 icons"></i>Productos</span></a></a>
                    <div class="collapse" id="productos-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="tuberias.php" class="nav-link ps-5">Tuberias</a></li>
                            <li><a href="conexiones.php" class="nav-link ps-5">Conexiones</a></li>
                            <li><a href="aspersores.php" class="nav-link ps-5">Aspersores</a></li>
                            <li><a href="boquillas.php" class="nav-link ps-5">Boquillas</a></li>
                            <li><a href="valvulas.php" class="nav-link ps-5">Válvulas</a></li>
                            <li><a href="programadores.php" class="nav-link ps-5">Programadores</a></li>
                            <li><a href="miscelaneos.php" class="nav-link ps-5">Miscelaneos</a></li>
                        </ul>
                    </div>
                </li>
                <a href="servicios.php" class="nav-link"><span class="mx-2"><i class="fa fa-seedling p-1 icons"></i>Servicios</span></a>
                <a href="departamentos.php" class="nav-link"><span class="mx-2"><i class="fa fa-laptop-code p-1 icons"></i>Departamentos</span></a>
                <a href="puestos.php" class="nav-link"><span class="mx-2"><i class="fa fa-user-friends p-1 icons"></i>Puesto</span></a>
                <a href="empleados.php" class="nav-link"><span class="mx-2"><i class="fa fa-user-check p-1 icons"></i>Empleados</span></a>
                <a href="inventario.php" class="nav-link"><span class="mx-2"><i class="fa fa-dolly p-1 icons"></i>Inventario</span></a>
                <li>
                    <a href="#" data-bs-toggle="collapse" data-target=".navbar-collapse" data-bs-target="#facturacion-collapse" aria-expanded="false" class="nav-link collapsed"><span class="mx-2"><i class="fa fa-shopping-bag p-1 icons"></i>Facturación</span></a></a>
                    <div class="collapse" id="facturacion-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="facturas_servicio.php" class="nav-link ps-5">Facturación servicios</a></li>
                            <li><a href="facturas_compra" class="nav-link ps-5">Facturación compras</a></li>
                            <li><a href="facturas_venta.php" class="nav-link ps-5">Facturación ventas</a></li>
                            <li><a href="clientes_servicio.php" class="nav-link ps-5">Clientes de servicios</a></li>
                        </ul>
                    </div>
                </li>
                <a href="pedidos.php" class="nav-link"><span class="mx-2"><i class="fa fa-truck-moving p-1 icons"></i>Pedidos</span></a>
            </ul>
        </div>











