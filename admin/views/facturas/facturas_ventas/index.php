<div class="ps-5 pe-5 pt-3 pb-5 my-container active-cont">
    <h3 class="display-3">Facturas de Ventas</h3>
    <div class="d-flex flex-row-reverse pt-3 pb-3">
        <form action="facturas_venta.php" method="GET">
            <input class="input-group-text pe-1" style="display:inline-block;" type="text" name="busqueda">
            <button class="btn btn-outline-secondary" type="submit">
                Buscar
                <i class="fa fa-search p-1 icons"></i>
            </button>
        </form>
    </div>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th scope="col">No.</th>
            <th scope="col">Fecha</th>
            <th scope="col">RFC</th>
            <th scope="col">Nombre del cliente</th>
            <th scope="col">Estatús</th>
            <th scope="col">Estatús de la venta</th>
            <th scope="col">Total</th>
            <th scope="col">Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($datos as $key => $factura_venta): ?>
            <tr>
                <td><?=$factura_venta['id_factura']?></td>
                <td><?=$factura_venta['fecha']?></td>
                <td><?=$factura_venta['rfc']?></td>
                <td><?=$factura_venta['nombre']?></td>
                <td><?=$factura_venta['estatus_factura']?></td>
                <td><?=$factura_venta['estatus_venta']?></td>
                <td><?='$' . $factura_venta['total']?></td>
                <td>
                    <?php
                        if ($factura_venta['estatus_factura'] != 'Cancelada') {
                            $enlace1 = "facturas_venta.php?action=ver_estatus&id_factura=" . $factura_venta['id_factura'] . "&tipo=venta";
                            $enlace2 = "facturas_venta.php?action=agregar_producto_venta&id_factura=" . $factura_venta['id_factura'];
                            $enlace3 = "facturas_venta.php?action=ver_estatus_venta&id_factura=" . $factura_venta['id_factura'];
                        } else {
                            $enlace1 = "#";
                            $enlace2 = "#";
                            $enlace3 = "#";
                        }
                    ?>
                    <a href="facturas_ventapdf.php?action=generar_pdf&id_factura=<?=$factura_venta['id_factura']?>" target="_blank" class="btn btn-outline-secondary">
                        <i class="fa fa-eye p-1 icons"></i>
                    </a>
                    <a href="<?=$enlace1?>" class="btn btn-outline-primary">
                        <i class="fa fa-check p-1 icons"></i>
                    </a>
                    <a href="<?=$enlace2?>" class="btn btn-outline-dark">
                        <i class="fa fa-cogs p-1 icons"></i>
                    </a>
                    <a href="<?=$enlace3?>" class="btn btn-outline-info">
                        <i class="fa fa-shipping-fast p-1 icons"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <nav>
        <ul class="pagination">
            <?php for($i = 0, $k = 1; $i < $factura_ventas -> total('id_factura', 'factura_venta'); $i+=5, $k++): ?>
                <li class="page-item"><a class="page-link" href="facturas_venta.php?<?php echo(isset($_GET['busqueda']))?'busqueda='.$_GET['busqueda'].'&':''; ?>&desde=<?php echo($i); ?>&limite=5"><?php echo ($k); ?></a></li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php
        echo "Filtrando " . count($datos) . " de un total del " . $factura_ventas -> total('id_factura', 'factura_venta') . " facturas"
    ?>
</div>
