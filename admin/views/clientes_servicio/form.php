<div class="ps-5 pe-5 pt-5 pb-5 my-container active-cont">
    <h3 class="display-6">Agregar/Actualizar clientes de servicios</h3>
    <form action="clientes_servicio.php?action=<?php echo($_GET['action'] == 'ver')?'actualizar':'guardar'; ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">RFC</label>
            <input type="text" name="cliente_servicio[rfc]" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['rfc']:''; ?>' class="form-control" id="txtRFC" <?php echo($_GET['action'] == 'ver')?'readonly':''?>>
        </div>

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="cliente_servicio[nombre]" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['nombre']:''; ?>' class="form-control" id="txtNombre">
        </div>

        <div class="mb-3">
            <label class="form-label">Apellido paterno</label>
            <input type="text" name="cliente_servicio[apaterno]" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['apaterno']:''; ?>' class="form-control" id="txtApaterno">
        </div>

        <div class="mb-3">
            <label class="form-label">Apellido materno</label>
            <input type="text" name="cliente_servicio[amaterno]" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['amaterno']:''; ?>' class="form-control" id="txtAmaterno">
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="cliente_servicio[email]" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['email']:''; ?>' class="form-control" id="txtemail">
        </div>

        <div class="mb-3">
            <label class="form-label">Dirección</label>
            <textarea name ="cliente_servicio[domicilio]" class="form-control" id="txtDireccion" rows="3"><?php echo($_GET['action'] == 'ver')?$datos[0]['domicilio']:'';?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Telefono</label>
            <input type="text" name="cliente_servicio[telefono]" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['telefono']:''; ?>' class="form-control" id="txtTelefono">
        </div>

        <button type="submit" name="enviar" class="btn btn-outline-success">
            <i class="fa fa-save p-1 icons"></i>
            Guardar
        </button>
    </form>
</div>