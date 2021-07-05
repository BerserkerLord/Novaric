<div class="ps-5 pe-5 pt-5 pb-5 my-container active-cont">
    <h3 class="display-6">Actualizar estatús de venta</h3>
    <form action="facturas_venta.php?action=actualizar_estatus_venta" method="POST" enctype="multipart/form-data" class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Estatus de Venta</label>
            <select name="factura[id_estatus_venta]" class="form-control" id="slctEstatusFactura">
                <?php
                    $acc = $_GET['action'];
                    echo "<option disabled value> -- Selecciona una opción --</option>";
                    echo($acc == 'ver_estatus')?"":"";
                    foreach($estatuses_ventas as $key => $estatus):
                        $selected = '';
                        if($estatus['id_estatus_venta'] == $datos[0]['id_estatus_venta']){ $selected = ' selected'; }
                ?>
                    <option value="<?php echo($estatus['id_estatus_venta']); ?>"<?php echo $selected; ?>><?php echo($estatus['estatus_venta']) ?></option>
                <?php endforeach;?>
            </select>
        </div>

        <input type="hidden" name='factura[id_factura]' value='<?=$_GET['id_factura'];?>' />
        <div class="col-12">
            <button type="submit" name="enviar" class="btn btn-outline-success">
                <i class="fa fa-save p-1 icons"></i>
                Guardar
            </button>
        </div>
    </form>
</div>