<div class="ps-5 pe-5 pt-5 pb-5 my-container active-cont">
    <h3 class="display-6">Agregar/Actualizar extremidades</h3>
    <form action="extremidades.php?action=<?php echo($_GET['action'] == 'ver')?'actualizar':'guardar'; ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Extremidades</label>
            <input type="text" name="extremidad[extremidad]" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['extremidad']:''; ?>' class="form-control" id="txtExtremidad">
        </div>

        <input type="hidden" name="extremidad[id_extremidad]" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['id_extremidad']:''; ?>' />
        <button type="submit" name="enviar" class="btn btn-outline-success">
            <i class="fa fa-save p-1 icons"></i>
            Guardar
        </button>
    </form>
</div>