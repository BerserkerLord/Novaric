<div class="ps-5 pe-5 pt-3 pb-3 my-container active-cont">
    <h3 class="display-3">Entradas</h3>
    <table class="table table-success table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">No. factura</th>
                <th scope="col">Fecha</th>
                <th scope="col">Codigo del producto</th>
                <th scope="col">Producto</th>
                <th scope="col">Cantidad</th>
                <th scope="col">Estatús</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($entradas as $key => $entrada): ?>
            <tr>
                <td><?=$entrada['id_factura']?></td>
                <td><?=$entrada['fecha']?></td>
                <td><?=$entrada['codigo_producto']?></td>
                <td><?=$entrada['producto']?></td>
                <td><?=$entrada['cantidad']?></td>
                <td><?=$entrada['estatus_factura']?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <nav>
        <ul class="pagination">
            <?php for($i = 0, $k = 1; $i < $productos -> total('id_factura', 'detalle_factura_producto_compra'); $i+=15, $k++): ?>
                <li class="page-item"><a class="page-link" href="entradas.php?<?php echo(isset($_GET['busqueda']))?'busqueda='.$_GET['busqueda'].'&':''; ?>&desde=<?php echo($i); ?>&limite=15"><?php echo ($k); ?></a></li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php
        echo "Filtrando " . count($entradas) . " de un total del " . $productos -> total('id_factura', 'detalle_factura_producto_compra') . " entradas"
    ?>
</div>