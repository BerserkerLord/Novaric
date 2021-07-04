<div class="ps-5 pe-5 pb-5 my-container active-cont">
    <h3 class="display-6">Agregar factura</h3>
    <form action="facturas_servicio.php?action=guardar_factura" method="POST" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
        <div class="col-md-4">
            <label class="form-label">Servicio</label>
            <select name="factura_servicio[id_servicio]" class="form-control" id="slctServicio" required>
                <?php
                echo "<option disabled selected value> -- Selecciona una opción --</option>";
                foreach($servicios as $key => $servicio):?>
                    <option value="<?php echo($servicio['id_servicio']); ?>"><?php echo($servicio['servicio']) ?></option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">
                Selecciona una opción por favor.
            </div>
        </div>

        <div class="col-md-4">
            <label class="form-label">Monto</label>
            <input type="text" name="factura_servicio[monto]" class="form-control" pattern="(0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*)" required>
            <div class="invalid-feedback">
                Llenar este campo por favor o poner el formato adecuado.
            </div>
        </div>

        <div class="col-md-4">
            <label class="form-label">RFC Cliente</label>
            <select name="factura_servicio[rfc]" class="form-control" id="slctRFC" required>
                <?php
                    echo "<option disabled selected value> -- Selecciona una opción --</option>";
                    foreach($clientes as $key => $cliente):?>
                    <option value="<?php echo($cliente['rfc']); ?>"><?php echo($cliente['rfc']) ?></option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">
                Llenar este campo por favor.
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label">Descripción</label>
            <textarea name="factura_servicio[descripcion]" class="form-control" rows="3" required></textarea>
            <div class="invalid-feedback">
                Llenar este campo por favor.
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label">Ubicación</label>
            <textarea name="factura_servicio[domicilio]" class="form-control" rows="3" required></textarea>
            <div class="invalid-feedback">
                Llenar este campo por favor.
            </div>
        </div>

        <div class="col-12">
            <button type="submit" name="enviar" class="btn btn-outline-success">
                <i class="fa fa-save p-1 icons"></i>
                Guardar
            </button>
        </div>
    </form>
</div>
