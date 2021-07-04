<div class="ps-5 pe-5 pt-3 pb-5 my-container active-cont">
    <h3 class="display-3">Facturas de Servicios</h3>
    <div class="d-flex flex-row-reverse pt-3 pb-3">
        <form action="facturas_servicio.php" method="GET">
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
                <th scope="col">RFC de cliente</th>
                <th scope="col">Estatús</th>
                <th scope="col">Total</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($datos as $key => $factura_servicio): ?>
            <tr>
                <td><?=$factura_servicio['id_factura']?></td>
                <td><?=$factura_servicio['fecha']?></td>
                <td><?=$factura_servicio['rfc']?></td>
                <td><?=$factura_servicio['estatus_factura']?></td>
                <td><?='$' . $factura_servicio['total']?></td>
                <td>
                    <a href="factura_serviciopdf.php?id_factura=<?=$factura_servicio['id_factura']?>" target="_blank" class="btn btn-outline-secondary">
                        <i class="fa fa-eye p-1 icons"></i>
                    </a>
                    <a href="facturas_servicio.php?action=ver_estatus&id_factura=<?=$factura_servicio['id_factura']?>&tipo=servicio" class="btn btn-outline-primary">
                        <i class="fa fa-check p-1 icons"></i>
                    </a>
                    <a href="facturas_servicio.php?action=agregar_servicio&id_factura=<?=$factura_servicio['id_factura']?>" class="btn btn-outline-dark">
                        <i class="fa fa-cogs p-1 icons"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>