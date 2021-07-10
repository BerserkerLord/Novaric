<div class="ps-5 pe-5 pt-3 pb-5 my-container active-cont">
    <h1 class="display-3">Agregar/Actualizar miscelaneo</h1>
    <form action="miscelaneos.php?action=<?php echo(isset($datos))?'actualizar':'guardar'; ?>" method="POST" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
        <div class="col-md-3">
            <label class="form-label">Código</label>
            <input type="text" name="miscelaneo[codigo_producto]" value='<?php echo(isset($datos[0]['codigo_producto']))?$datos[0]['codigo_producto']:''; ?>' class="form-control" id="txtCodigo" <?php echo($_GET['action'] == 'ver')?'readonly':''?> required>
            <div class="invalid-feedback">
                Llenar este campo por favor.
            </div>
        </div>

        <div class="col-md-3">
            <label class="form-label">Producto</label>
            <input type="text" name="miscelaneo[producto]" value='<?php echo(isset($datos[0]['producto']))?$datos[0]['producto']:''; ?>' class="form-control" id="txtProducto" required>
            <div class="invalid-feedback">
                Llenar este campo por favor.
            </div>
        </div>

        <div class="col-md-3">
            <label class="form-label">Costo</label>
            <input type="text" name="miscelaneo[costo]" value='<?php echo(isset($datos[0]['costo']))?$datos[0]['costo']:''; ?>' class="form-control" id="txtCosto" required>
            <div class="invalid-feedback">
                Llenar este campo por favor o usar el formato adecuado.
            </div>
            <small>Formato: Solo numeros mayores a cero</small><br><br>
        </div>

        <div class="col-md-3">
            <label class="form-label">Descripción</label>
            <textarea name="miscelaneo[descripcion]" class="form-control" id="txtDescripcion" rows="3" required><?php echo(isset($datos[0]['descripcion']))?$datos[0]['descripcion']:''; ?></textarea>
        </div>

        <div class="col-md-3">
            <label class="form-label">Existencias</label>
            <input type="text" name="miscelaneo[existencias]" value='0' class="form-control" id="txtExistencias" required readonly>
        </div>

        <div class="col-md-3">
            <label class="form-label">Marca</label>
            <select name="miscelaneo[id_marca]" class="form-control" id="slctMarca" required>
                <?php
                    echo($_GET['action'] == 'crear')?"<option disabled selected value> -- Selecciona una opción --</option>":"";
                    foreach($marcas as $key => $marca):
                        $selected = '';
                        if(isset($datos)){
                            if($marca['id_marca'] == $datos[0]['id_marca']){
                                $selected = ' selected';
                            }
                        }
                ?>
                    <option value="<?php echo($marca['id_marca']); ?>"<?php echo($selected); ?>><?php echo($marca['marca']); ?></option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">
                Seleccione una opción.
            </div>
        </div>

        <div class="col-md-3">
            <label class="form-label">Unidad</label>
            <select name="miscelaneo[id_unidad]" class="form-control" id="slctUnidad" required>
                <?php
                    echo($_GET['action'] == 'crear')?"<option disabled selected value> -- Selecciona una opción --</option>":"";
                    foreach($unidades as $key => $unidad):
                        $selected = '';
                        if(isset($datos)){
                            if ($unidad['id_unidad'] == $datos[0]['id_unidad']) {
                                $selected = ' selected';
                            }
                        }
                ?>
                    <option value="<?php echo($unidad['id_unidad']); ?>"<?php echo($selected); ?>><?php echo($unidad['unidad']); ?></option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">
                Seleccione una opción.
            </div>
        </div>

        <div class="col-md-3">
            <label class="form-label">Imagen</label>
            <input type="file" name="fotografia" class="form-control" <?php echo($_GET['action'] == 'crear')?'required':''; ?>>
            <div class="invalid-feedback">
                Seleccione un archivo.
            </div>
        </div>

        <div class="col-12">
            <button type="submit" name="enviar" class="btn btn-outline-primary">
                Guardar
                <i class="fa fa-save p-1 icons"></i>
            </button>
        </div>
    </form>
</div>
