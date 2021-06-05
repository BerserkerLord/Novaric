<div class="ps-5 pe-5 pt-5 my-container active-cont">
    <h3 class="display-6">Agregar/Actualizar proveedor</h3>
    <form action="proveedores.php?action=<?php echo($_GET['action'] == 'ver')?'actualizar':'guardar'; ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">RFC</label>
            <input type="text" name="proveedor[rfc]" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['rfc']:''; ?>' class="form-control" id="txtRFC" <?php echo($_GET['action'] == 'ver')?'readonly':''?>>
        </div>

        <div class="mb-3">
            <label class="form-label">Razón Social</label>
            <input type="text" name="proveedor[razon_social]" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['razon_social']:''; ?>' class="form-control" id="txtRazonSocial">
        </div>

        <div class="mb-3">
            <label class="form-label">Domicilio</label>
            <textarea name="proveedor[domicilio]" class="form-control" id="txaDomicilio" rows="3"><?php echo($_GET['action'] == 'ver')?$datos[0]['domicilio']:'';?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Teléfono</label>
            <input type="text" name="proveedor[telefono]" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['telefono']:''; ?>' class="form-control" id="txtTelefono">
        </div>

        <button type="submit" name="enviar" class="btn btn-success">
            <i class="fa fa-save p-1 icons"></i>
            Guardar
        </button>
    </form>
</div>