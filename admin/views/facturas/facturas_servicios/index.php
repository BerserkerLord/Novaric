<div class="ps-5 pe-5 pt-3 pb-3 my-container active-cont">
    <h3 class="display-3">Facturas de Servicios</h3>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <a href="factura_servicio.php?action=crear" class="btn btn-success mb-3"><i class="fa fa-plus p-1 icons"></i>
                    Agregar
                </a>
            </div>
            <div class="col-md-4 offset-md-4">
                <form action="factura_servicio.php" method="GET">
                    <input class="input-group-text pe-1" style="display:inline-block;" type="text" name="busqueda">
                    <button class="btn btn-outline-secondary" type="submit">
                        Buscar
                        <i class="fa fa-search p-1 icons"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th scope="col">No.</th>
            <th scope="col">Fecha</th>
            <th scope="col">Cliente</th>
            <th scope="col">Estatús</th>
            <th scope="col">Total</th>
            <th scope="col">Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($datos as $key => $factura_servicio): ?>
            <tr>
                <td>
                    <img src="<?php echo (isset($factura_servicio['fotografia']))? '../archivos/'.$factura_servicio['fotografia']: '../archivos/default.jpg'; ?>" alt="foto factura_servicio" class="rounded img-fluid" height="75px" width="75px">
                </td>
                <td><?=$factura_servicio['id_factura']?></td>
                <td><?=$factura_servicio['fecha']?></td>
                <td><?=$factura_servicio['nombre']?></td>
                <td><?=$factura_servicio['estatus_factura']?></td>
                <td><?='$' . $factura_servicio['total']?></td>
                <td>
                    <a href="factura_servicio.php?action=ver&id_factura=<?=$factura_servicio['codigo_producto']?>" class="btn btn-primary">
                        <i class="fa fa-arrow-up p-1 icons"></i>
                    </a>
                    <a href="factura_servicios.php?action=eliminar&codigo_producto=<?=$factura_servicio['codigo_producto']?>" class="btn btn-danger">
                        <i class="fa fa-trash p-1 icons"></i>
                    </a>
                </td>
            </tr>
            <tr>
                <td colspan="10"><?="<b>" . "Descripción: " . "</b>" . $factura_servicio['descripcion']?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <h3 class="display-6 pt-4">Ficha Técnica</h3>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th scope="col">Código</th>
            <th scope="col">Máximo de estaciones</th>
            <th scope="col">Entradas de sensores</th>
            <th scope="col">Entrada de transformador</th>
            <th scope="col">Salida del transformador(24 VCA)</th>
            <th scope="col">Salida de la estación(24 VCA)</th>
            <th scope="col">Salida P/MV(24 VCA)</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($datos as $key => $factura_servicio): ?>
            <tr>
                <td><?=$factura_servicio['codigo_producto']?></td>
                <td><?=$factura_servicio['maximo_estaciones']?></td>
                <td><?=$factura_servicio['entradas_sensores']?></td>
                <td><?=$factura_servicio['entrada_transformador']?></td>
                <td><?=$factura_servicio['salida_transformador'] . ' A'?></td>
                <td><?=$factura_servicio['salida_estacion'] . ' A'?></td>
                <td><?=$factura_servicio['salida_p_mv'] . ' A'?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <nav>
        <ul class="pagination">
            <?php for($i = 0, $k = 1; $i < $factura_servicios -> total('codigo_producto', 'factura_servicio'); $i+=10, $k++): ?>
                <li class="page-item"><a class="page-link" href="factura_servicios.php?<?php echo(isset($_GET['busqueda']))?'busqueda='.$_GET['busqueda'].'&':''; ?>&desde=<?php echo($i); ?>&limite=10"><?php echo ($k); ?></a></li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php
        echo "Filtrando " . count($datos) . " de un total del " . $factura_servicios -> total('codigo_producto', 'factura_servicio') . " facturas"
    ?>
</div>