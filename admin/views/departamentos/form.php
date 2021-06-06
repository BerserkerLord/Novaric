<div class="ps-5 pe-5 pt-5 pb-5 my-container active-cont">
    <h3 class="display-6">Agregar/Actualizar departamentos</h3>
    <form action="departamentos.php?action=<?php echo($_GET['action'] == 'ver')?'actualizar':'guardar'; ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Departamento</label>
            <input type="text" name="departamento[departamento]" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['departamento']:''; ?>' class="form-control" id="txtDepartamento">
        </div>

        <input type="hidden" name='departamento[id_departamento]' value='<?php echo($_GET['action'] == 'ver')?$datos[0]['id_departamento']:''; ?>' />
        <button type="submit" name="enviar" class="btn btn-outline-success">
            <i class="fa fa-save p-1 icons"></i>
            Guardar
        </button>
    </form>
</div>