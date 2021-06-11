<div class="ps-5 pe-5 pb-5 my-container active-cont">
    <h3 class="display-6">Agregar servicio a factura</h3>
    <form action="facturas_servicio.php?action=guardar_servicio" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">No. factura</label>
            <input type="text" class="form-control" name='factura_servicio[id_factura_servicio]' value='<?php echo $id_factura ?>' readonly/>
        </div>

        <div class="mb-3">
            <label class="form-label">Servicio</label>
            <select name="factura_servicio[id_servicio]" class="form-control" id="slctServicio">
                <?php
                echo "<option disabled selected value> -- Selecciona una opción --</option>";
                foreach($servicios as $key => $servicio):?>
                    <option value="<?php echo($servicio['id_servicio']); ?>"><?php echo($servicio['servicio']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Monto</label>
            <input type="text" name="factura_servicio[monto]" class="form-control">
        </div>

        <button type="submit" name="enviar" class="btn btn-outline-success">
            <i class="fa fa-save p-1 icons"></i>
            Guardar
        </button>
    </form>
</div>