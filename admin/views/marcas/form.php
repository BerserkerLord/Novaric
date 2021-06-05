<div class="ps-5 pe-5 pt-5 my-container active-cont">
    <h3 class="display-6">Agregar/Actualizar marca</h3>
    <form action="marcas.php?action=<?php echo($_GET['action'] == 'ver')?'actualizar':'guardar'; ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Marca</label>
            <input type="text" name="marca[marca]" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['marca']:''; ?>' class="form-control" id="txtMarca">
        </div>

        <div class="mb-3">
            <label class="form-label">Fotografia</label>
            <input type="file" name="fotografia" class="form-control">
        </div>

        <input type="hidden" name='marca[id_marca]' value='<?php echo($_GET['action'] == 'ver')?$datos[0]['id_marca']:''; ?>' />
        <button type="submit" name="enviar" class="btn btn-success">
            <i class="fa fa-save p-1 icons"></i>
            Guardar
        </button>
    </form>
</div>