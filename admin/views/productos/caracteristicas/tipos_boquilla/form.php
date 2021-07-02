<div class="ps-5 pe-5 pt-5 pb-5 my-container active-cont">
    <h3 class="display-6">Agregar/Actualizar tipos de boquilla</h3>
    <form action="tipos_boquilla.php?action=<?php echo($_GET['action'] == 'ver')?'actualizar':'guardar'; ?>" method="POST" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
        <div class="col-md-6">
            <label class="form-label">Marca</label>
            <input type="text" name="tipo_boquilla[tipo_boquilla]" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['tipo_boquilla']:''; ?>' class="form-control" id="txtTipoBoquilla" required>
            <div class="invalid-feedback">
                Llenar este campo por favor.
            </div>
        </div>

        <div class="col-12">
            <input type="hidden" name='tipo_boquilla[id_tipo_boquilla]' value='<?php echo($_GET['action'] == 'ver')?$datos[0]['id_tipo_boquilla']:''; ?>' />
            <button type="submit" name="enviar" class="btn btn-outline-success">
                <i class="fa fa-save p-1 icons"></i>
                Guardar
            </button>
        </div>
    </form>
</div>