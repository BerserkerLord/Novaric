<div class="ps-5 pe-5 pt-3 pb-5 my-container active-cont">
    <h3 class="display-3">Facturas de Compras</h3>
    <div class="d-flex flex-row-reverse pt-3 pb-3">
        <form action="facturas_compra.php" method="GET">
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
            <th scope="col">Razón social del proveedor</th>
            <th scope="col">Estatús</th>
            <th scope="col">Total</th>
            <th scope="col">Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($datos as $key => $factura_compra): ?>
            <tr>
                <td><?=$factura_compra['id_factura']?></td>
                <td><?=$factura_compra['fecha']?></td>
                <td><?=$factura_compra['rfc']?></td>
                <td><?=$factura_compra['estatus_factura']?></td>
                <td><?='$' . $factura_compra['total']?></td>
                <td>
                    <a href="facturas_compra.php?action=generar_pdf&id_factura=<?=$factura_compra['id_factura']?>" class="btn btn-outline-secondary">
                        <i class="fa fa-eye p-1 icons"></i>
                    </a>
                    <a href="facturas_compra.php?action=ver_estatus&id_factura=<?=$factura_compra['id_factura']?>&tipo=compra" class="btn btn-outline-primary">
                        <i class="fa fa-check p-1 icons"></i>
                    </a>
                    <a href="facturas_compra.php?action=agregar_producto&id_factura=<?=$factura_compra['id_factura']?>" class="btn btn-outline-dark">
                        <i class="fa fa-cogs p-1 icons"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>