<div class="ps-5 pe-5 pt-5 my-container active-cont">
    <h3 class="display-6">Agregar/Actualizar tipos de conexión</h3>
    <form action="formas_conexion.php?action=<?php echo($_GET['action'] == 'ver')?'actualizar':'guardar'; ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Forma de conexión</label>
            <input type="text" name="forma_conexion[forma_conexion]" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['forma_conexion']:''; ?>' class="form-control" id="txtFormaConexion">
        </div>

        <input type="hidden" name="forma_conexion[id_forma_conexion]" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['id_forma_conexion']:''; ?>' />
        <button type="submit" name="enviar" class="btn btn-success">
            <i class="fa fa-save p-1 icons"></i>
            Guardar
        </button>
    </form>
</div>