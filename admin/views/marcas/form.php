<div class="ps-5 pe-5 pt-5 pb-5">
    <h3 class="display-6">Agregar/Actualizar marca</h3>
    <form action="marcas.php?action=<?php echo($_GET['action'] == 'ver')?'actualizar':'guardar'; ?>" method="POST" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
        <div class="col-md-6">
            <label class="form-label">Marca</label>
            <input type="text" name="marca[marca]" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['marca']:''; ?>' class="form-control" id="txtMarca" required>
            <div class="invalid-feedback">
                Llenar este campo por favor.
            </div>
        </div>

        <div class="col-md-4">
            <label class="form-label">Fotografia</label>
            <input type="file" name="fotografia" class="form-control" <?php echo($_GET['action'] == 'ver')?'':'required'; ?>>
            <div class="invalid-feedback">
                Archivo no seleccionado.
            </div>
        </div>

        <div class="col-12">
            <input type="hidden" name='marca[id_marca]' value='<?php echo($_GET['action'] == 'ver')?$datos[0]['id_marca']:''; ?>' />
            <button type="submit" name="enviar" class="btn btn-outline-success">
                <i class="fa fa-save p-1 icons"></i>
                Guardar
            </button>
        </div>
    </form>
</div>
