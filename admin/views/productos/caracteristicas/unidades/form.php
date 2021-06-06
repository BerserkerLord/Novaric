<div class="ps-5 pe-5 pt-5 pb-5 my-container active-cont">
    <h3 class="display-6">Agregar/Actualizar unidad</h3>
    <form action="unidades.php?action=<?php echo($_GET['action'] == 'ver')?'actualizar':'guardar'; ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Unidad</label>
            <input type="text" name="unidad[unidad]" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['unidad']:''; ?>' class="form-control" id="txtUnidad">
        </div>

        <input type="hidden" name="unidad[id_unidad]" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['id_unidad']:''; ?>' />
        <button type="submit" name="enviar" class="btn btn-outline-success">
            <i class="fa fa-save p-1 icons"></i>
            Guardar
        </button>
    </form>
</div>