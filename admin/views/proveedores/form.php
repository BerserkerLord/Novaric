<div class="ps-5 pe-5 pt-5 pb-5">
    <h3 class="display-6">Agregar/Actualizar proveedor</h3>
    <form action="proveedores.php?action=<?php echo($_GET['action'] == 'ver')?'actualizar':'guardar'; ?>" method="POST" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
        <div class="col-md-6">
            <label class="form-label">RFC</label>
            <input type="text" maxlength="12" minlength="12" name="proveedor[rfc]" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['rfc']:''; ?>' class="form-control" id="txtRFC" <?php echo($_GET['action'] == 'ver')?'readonly':''?> pattern="([A-ZÑ&]{3})?(?:-?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01]))?(?:-?)?([A-Z\d]{2})([A\d])" required>
            <div class="invalid-feedback">
                Llenar este campo por favor o coloque el formato adecuado.
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label">Razón Social</label>
            <input type="text" name="proveedor[razon_social]" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['razon_social']:''; ?>' class="form-control" id="txtRazonSocial" required>
            <div class="invalid-feedback">
                Llenar este campo por favor.
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label">Domicilio</label>
            <textarea name="proveedor[domicilio]" class="form-control" id="txtDomicilio" rows="3" required><?php echo($_GET['action'] == 'ver')?$datos[0]['domicilio']:'';?></textarea>
            <div class="invalid-feedback">
                Llenar este campo por favor.
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label">Teléfono</label>
            <input type="tel" name="proveedor[telefono]" minlength="12" maxlength="12" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['telefono']:''; ?>' class="form-control" id="txtTelefono" pattern="[0-9]{1,3}-[0-9]{3}-[0-9]{4}" required>
            <div class="invalid-feedback">
                Llenar este campo por favor o en el formato adecuado
            </div>
            <small>Formato: 123-456-7890</small><br><br>
        </div>

        <div class="col-12">
            <button type="submit" name="enviar" class="btn btn-outline-success">
                <i class="fa fa-save p-1 icons"></i>
                Guardar
            </button>
        </div>
    </form>
</div>