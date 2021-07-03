<div class="ps-5 pe-5 pt-5 pb-5">
    <h3 class="display-6">Agregar/Actualizar servicio</h3>
    <form action="servicios.php?action=<?php echo($_GET['action'] == 'ver')?'actualizar':'guardar'; ?>" method="POST" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
        <div class="col-md-6">
            <label class="form-label">Servicio</label>
            <input type="text" name="servicio[servicio]" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['servicio']:''; ?>' class="form-control" id="txtServicio" required>
            <div class="invalid-feedback">
                Llenar este campo por favor.
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label">Fotografia</label>
            <input type="file" name="fotografia" class="form-control" <?php echo($_GET['action'] == 'ver')?'':'required'; ?>>
            <div class="invalid-feedback">
                Seleccionar un archivo por favor.
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label">Descripción</label>
            <textarea name="servicio[descripcion]" class="form-control" id="txtDescripcion" rows="3" required><?php echo($_GET['action'] == 'ver')?$datos[0]['descripcion']:'';?></textarea>
        </div>

        <div class="col-12">
            <input type="hidden" name='servicio[id_servicio]' value='<?php echo($_GET['action'] == 'ver')?$datos[0]['id_servicio']:''; ?>' />
            <button type="submit" name="enviar" class="btn btn-outline-success">
                <i class="fa fa-save p-1 icons"></i>
                Guardar
            </button>
        </div>
    </form>
</div>