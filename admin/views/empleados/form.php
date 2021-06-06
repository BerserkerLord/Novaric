<div class="ps-5 pe-5 pt-5 pb-5 my-container active-cont">
    <h3 class="display-6">Agregar/Actualizar Empleados</h3>
    <form action="empleados.php?action=<?php echo($_GET['action'] == 'ver')?'actualizar':'guardar'; ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">RFC</label>
            <input type="text" name="empleado[rfc]" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['rfc']:''; ?>' class="form-control" id="txtRFC" <?php echo($_GET['action'] == 'ver')?'readonly':''?>>
        </div>

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="empleado[nombre]" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['nombre']:''; ?>' class="form-control" id="txtNombre">
        </div>

        <div class="mb-3">
            <label class="form-label">Apellido paterno</label>
            <input type="text" name="empleado[apaterno]" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['apaterno']:''; ?>' class="form-control" id="txtApaterno">
        </div>

        <div class="mb-3">
            <label class="form-label">Apellido materno</label>
            <input type="text" name="empleado[amaterno]" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['amaterno']:''; ?>' class="form-control" id="txtAmaterno">
        </div>

        <div class="mb-3">
            <label class="form-label">Dirección</label>
            <textarea name ="empleado[direccion]" class="form-control" id="txaDireccion" rows="3"><?php echo($_GET['action'] == 'ver')?$datos[0]['direccion']:'';?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Usuario</label>
            <input type="text" name="empleado[usuario]" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['usuario']:''; ?>' class="form-control" id="txtUsuario">
        </div>

        <div class="mb-3">
            <label class="form-label">Correo</label>
            <input type="email" name="empleado[correo]" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['correo']:''; ?>' class="form-control" id="txtCorreo">
        </div>

        <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input type="password" name="empleado[contrasenia]" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['contrasenia']:''; ?>' class="form-control" id="txtContrasenia">
        </div>

        <div class="mb-3">
            <label class="form-label">Puesto</label>
            <select name="empleado[id_puesto]" class="form-control" id="slctPuesto">
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
        </div>

        <div class="mb-3">
            <label class="form-label">Fotografia</label>
            <input type="file" name="fotografia" class="form-control">
        </div>

        <button type="submit" name="enviar" class="btn btn-outline-success">
            <i class="fa fa-save p-1 icons"></i>
            Guardar
        </button>
    </form>
</div>
