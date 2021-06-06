<div class="ps-5 pe-5 pt-5 pb-5 my-container active-cont">
    <h3 class="display-6">Agregar/Actualizar servicio</h3>
    <form action="servicios.php?action=<?php echo($_GET['action'] == 'ver')?'actualizar':'guardar'; ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Servicio</label>
            <input type="text" name="servicio[servicio]" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['servicio']:''; ?>' class="form-control" id="txtServicio">
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="servicio[descripcion]" class="form-control" id="txtDescripcion" rows="3"><?php echo($_GET['action'] == 'ver')?$datos[0]['descripcion']:'';?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Fotografia</label>
            <input type="file" name="fotografia" class="form-control">
        </div>

        <input type="hidden" name='servicio[id_servicio]' value='<?php echo($_GET['action'] == 'ver')?$datos[0]['id_servicio']:''; ?>' />
        <button type="submit" name="enviar" class="btn btn-outline-success">
            <i class="fa fa-save p-1 icons"></i>
            Guardar
        </button>
    </form>
</div>