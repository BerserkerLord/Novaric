<div class="ps-5 pe-5 pt-5 my-container active-cont">
    <h3 class="display-6">Agregar/Actualizar tipos de boquilla</h3>
    <form action="tipos_boquilla.php?action=<?php echo($_GET['action'] == 'ver')?'actualizar':'guardar'; ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Marca</label>
            <input type="text" name="tipo_boquilla[tipo_boquilla]" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['tipo_boquilla']:''; ?>' class="form-control" id="txtTipoBoquilla">
        </div>

        <input type="hidden" name='tipo_boquilla[id_tipo_boquilla]' value='<?php echo($_GET['action'] == 'ver')?$datos[0]['id_tipo_boquilla']:''; ?>' />
        <button type="submit" name="enviar" class="btn btn-success">
            <i class="fa fa-save p-1 icons"></i>
            Guardar
        </button>
    </form>
</div>