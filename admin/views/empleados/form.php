<div class="ps-5 pe-5 pt-5 pb-5 my-container active-cont">
    <h3 class="display-6">Agregar/Actualizar Empleados</h3>
    <form action="empleados.php?action=<?php echo($_GET['action'] == 'ver')?'actualizar':'guardar'; ?>" method="POST" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
        <div class="col-md-4">
            <label class="form-label">RFC</label>
            <input type="text" name="empleado[rfc]" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['rfc']:''; ?>' class="form-control" id="txtRFC" <?php echo($_GET['action'] == 'ver')?'readonly':''?> minlength="12" maxlength="13" pattern="([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A-Z\d])" required>
            <div class="invalid-feedback">
                Llenar este campo por favor o introducir el formato adecuado.
            </div>
        </div>

        <div class="col-md-4">
            <label class="form-label">Nombre</label>
            <input type="text" name="empleado[nombre]" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['nombre']:''; ?>' class="form-control" id="txtNombre" required>
            <div class="invalid-feedback">
                Llenar este campo por favor.
            </div>
        </div>

        <div class="col-md-4">
            <label class="form-label">Apellido paterno</label>
            <input type="text" name="empleado[apaterno]" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['apaterno']:''; ?>' class="form-control" id="txtApaterno" required>
            <div class="invalid-feedback">
                Llenar este campo por favor.
            </div>
        </div>

        <div class="col-md-4">
            <label class="form-label">Apellido materno</label>
            <input type="text" name="empleado[amaterno]" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['amaterno']:''; ?>' class="form-control" id="txtAmaterno">
        </div>

        <div class="col-md-4">
            <label class="form-label">Dirección</label>
            <textarea name ="empleado[direccion]" class="form-control" id="txaDireccion" rows="3" required><?php echo($_GET['action'] == 'ver')?$datos[0]['direccion']:'';?></textarea>
            <div class="invalid-feedback">
                Llenar este campo por favor.
            </div>
        </div>

        <div class="col-md-4">
            <label class="form-label">Correo</label>
            <input type="email" name="empleado[correo]" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['correo']:''; ?>' class="form-control" id="txtCorreo" required>
            <div class="invalid-feedback">
                Llenar este campo por favor.
            </div>
        </div>

        <div class="col-md-4">
            <label class="form-label">Contraseña</label>
            <input type="password" name="empleado[contrasenia]" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['contrasenia']:''; ?>' class="form-control" id="txtContrasenia" required>
            <div class="invalid-feedback">
                Llenar este campo por favor.
            </div>
        </div>

        <div class="col-md-4">
            <label class="form-label">Puesto</label>
            <select name="empleado[id_puesto]" class="form-control" id="slctPuesto" required>
                <?php
                    $acc = $_GET['action'];
                    echo "<option disabled selected value> -- Selecciona una opción --</option>";
                    foreach($puesto as $key => $puestos):
                        $selected = '';
                        if($acc =='ver'){
                            if($puestos['id_puesto'] == $datos[0]['id_puesto']){ $selected = ' selected'; }
                        }
                ?>
                    <option value="<?php echo($puestos['id_puesto']); ?>" <?php echo($_GET['action'] == 'leer')?'':$selected; ?>><?php echo($puestos['puesto']) ?></option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">
                Seleccionar una foto por favor
            </div>
        </div>

        <div class="col-md-4">
            <label class="form-label">Fotografia</label>
            <input type="file" name="fotografia" class="form-control" <?php echo($_GET['action'] == 'ver')?'':'required'; ?>>
            <div class="invalid-feedback">
                Elegir un archivo por favor
            </div>
        </div>

        <div class="col-12">
            <button type="submit" name="enviar" class="btn btn-outline-success">
                <i class="fa fa-save p-1 icons"></i>
                Guardar
            </button>
        </div>
    </form>
</div>
