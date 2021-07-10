<div class="ps-5 pe-5 pt-3 pb-3 my-container active-cont">
    <h3 class="display-3">Salidas</h3>
    <table class="table table-danger table-striped table-hover">
        <thead>
        <tr>
            <th scope="col">No. factura</th>
            <th scope="col">Fecha</th>
            <th scope="col">Codigo del producto</th>
            <th scope="col">Producto</th>
            <th scope="col">Cantidad</th>
            <th scope="col">Estatus</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($salidas as $key => $salida): ?>
            <tr>
                <td><?=$salida['id_factura']?></td>
                <td><?=$salida['fecha']?></td>
                <td><?=$salida['codigo_producto']?></td>
                <td><?=$salida['producto']?></td>
                <td><?=$salida['cantidad']?></td>
                <td><?=$salida['estatus_factura']?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <nav>
        <ul class="pagination">
            <?php for($i = 0, $k = 1; $i < $productos -> total('id_factura', 'detalle_factura_producto_venta'); $i+=15, $k++): ?>
                <li class="page-item"><a class="page-link" href="salidas.php?<?php echo(isset($_GET['busqueda']))?'busqueda='.$_GET['busqueda'].'&':''; ?>&desde=<?php echo($i); ?>&limite=15"><?php echo ($k); ?></a></li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php
        echo "Filtrando " . count($salidas) . " de un total del " . $productos -> total('id_factura', 'detalle_factura_producto_venta') . " salidas"
    ?>
</div>