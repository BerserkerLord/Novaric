<div class="ps-5 pe-5 pt-5 pb-5 my-container active-cont">
    <h3 class="display-6">Agregar/Actualizar puestos</h3>
    <form action="puestos.php?action=<?php echo($_GET['action'] == 'ver')?'actualizar':'guardar'; ?>" method="POST" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
        <div class="col-md-6">
            <label class="form-label">Puesto</label>
            <input type="text" name="puesto[puesto]" value='<?php echo($_GET['action'] == 'ver')?$datos[0]['puesto']:''; ?>' class="form-control" id="txtPuesto" required>
            <div class="invalid-feedback">
                Llenar este campo por favor o coloque el formato adecuado.
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label">Departamento</label>
            <select name="puesto[id_departamento]" class="form-control" id="slctDepartamento" required>
                <?php
                    $acc = $_GET['action'];
                    echo "<option disabled selected value> -- Selecciona una opción --</option>";
                    echo($acc == 'ver')?"":"";
                    foreach($departamento as $key => $departamentos):
                        $selected = '';
                        if($acc =='ver'){
                            if($departamentos['id_departamento'] == $datos[0]['id_departamento']){ $selected = ' selected'; }
                        }
                ?>
                    <option value="<?php echo($departamentos['id_departamento']); ?>" <?php echo($_GET['action'] == 'leer')?'':$selected; ?>><?php echo($departamentos['departamento']) ?></option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">
                Seleccionar una opción por favor
            </div>
        </div>

        <div class="col-12|">
            <input type="hidden" name='puesto[id_puesto]' value='<?php echo($_GET['action'] == 'ver')?$datos[0]['id_puesto']:''; ?>' />
            <button type="submit" name="enviar" class="btn btn-outline-success">
                <i class="fa fa-save p-1 icons"></i>
                Guardar
            </button>
        </div>
    </form>
</div>