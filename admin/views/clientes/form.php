<div class="ps-5 pe-5 pt-5 pb-5 my-container active-cont">
    <h3 class="display-6">Agregar/Actualizar clientes</h3>
    <form action="clientes.php?action=<?php echo($_GET['action'] == 'ver')?'actualizar':'guardar'; ?>" method="POST" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
        <div class="col-md-3">
            <label class="form-label">RFC</label>
            <input type="text" name="cliente[rfc]" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['rfc']:''; ?>' class="form-control" id="txtRFC" <?php echo($_GET['action'] == 'ver')?'readonly':''?> pattern="([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A-Z\d])" required>
            <div class="invalid-feedback">
                Llenar este campo por favor.
            </div>
        </div>

        <div class="col-md-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="cliente[nombre]" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['nombre']:''; ?>' class="form-control" id="txtNombre" required>
            <div class="invalid-feedback">
                Llenar este campo por favor.
            </div>
        </div>

        <div class="col-md-3">
            <label class="form-label">Apellido paterno</label>
            <input type="text" name="cliente[apaterno]" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['apaterno']:''; ?>' class="form-control" id="txtApaterno" required>
            <div class="invalid-feedback">
                Llenar este campo por favor.
            </div>
        </div>

        <div class="col-md-3">
            <label class="form-label">Apellido materno</label>
            <input type="text" name="cliente[amaterno]" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['amaterno']:''; ?>' class="form-control" id="txtAmaterno">
        </div>

        <div class="col-md-4">
            <label class="form-label">Dirección</label>
            <textarea name ="cliente[domicilio]" class="form-control" id="txtDireccion" rows="3" required><?php echo($_GET['action'] == 'ver')?$datos[0]['domicilio']:'';?></textarea>
            <div class="invalid-feedback">
                Llenar este campo por favor.
            </div>
        </div>

        <div class="col-md-4">
            <label class="form-label">Email</label>
            <input type="email" name="cliente[email]" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['email']:''; ?>' class="form-control" id="txtemail" required>
            <div class="invalid-feedback">
                Llenar este campo por favor.
            </div>
        </div>

        <div class="col-md-4">
            <label class="form-label">Telefono</label>
            <input type="text" name="cliente[telefono]" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['telefono']:''; ?>' class="form-control" id="txtTelefono" pattern="[0-9]{1,3}-[0-9]{3}-[0-9]{4}" required>
            <div class="invalid-feedback">
                Llenar este campo por favor o en el formato adecuado.
            </div>
            <small>Formato: 123-456-7890</small><br><br>
        </div>

        <div class="col-12">
            <button type="submit" name="enviar" class="btn btn-outline-success">
                <i class="fa fa-save p-1 icons"></i>
                Guardar
            </button>
        </div>
    </form>
</div>