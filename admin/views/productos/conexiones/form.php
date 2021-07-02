<div class="ps-5 pe-5 pt-3 pb-5 my-container active-cont">
    <h1 class="display-3">Agregar/Actualizar Conexión</h1>
    <form action="conexiones.php?action=<?php echo(isset($datos))?'actualizar':'guardar'; ?>" method="POST" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
        <div class="col-md-4">
            <label class="form-label">Código</label>
            <input type="text" name="conexion[codigo_producto]" value='<?php echo(isset($datos[0]['codigo_producto']))?$datos[0]['codigo_producto']:''; ?>' class="form-control" id="txtCodigo" <?php echo($_GET['action'] == 'ver')?'readonly':''?> required>
            <div class="invalid-feedback">
                Llenar este campo por favor.
            </div>
        </div>

        <div class="col-md-4">
            <label class="form-label">Producto</label>
            <input type="text" name="conexion[producto]" value='<?php echo(isset($datos[0]['producto']))?$datos[0]['producto']:''; ?>' class="form-control" id="txtProducto" required>
            <div class="invalid-feedback">
                Llenar este campo por favor.
            </div>
        </div>

        <div class="col-md-4">
            <label class="form-label">Costo</label>
            <input type="text" name="conexion[costo]" value='<?php echo(isset($datos[0]['costo']))?$datos[0]['costo']:''; ?>' class="form-control" id="txtCosto" pattern="[0-9]{1,3}$|^[0-9]{1,3}\.[0-9]{1,3}" required>
            <div class="invalid-feedback">
                Llenar este campo por favor o usar el formato adecuado.
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label">Descripción</label>
            <textarea name="conexion[descripcion]" class="form-control" id="txtDescripcion" rows="3" required><?php echo(isset($datos[0]['descripcion']))?$datos[0]['descripcion']:''; ?></textarea>
            <div class="invalid-feedback">
                Llenar este campo por favor.
            </div>
        </div>

        <div class="col-md-3">
            <label class="form-label">Existencias</label>
            <input type="text" name="conexion[existencias]" value='<?php echo(isset($datos[0]['existencias']))?$datos[0]['existencias']:''; ?>' class="form-control" id="txtExistencias" <?php echo(isset($datos))?'disabled':'pattern="[0-9]{1,3}$|^[0-9]{1,3}\.[0-9]{1,3}" required'; ?>>
            <div class="invalid-feedback">
                Llenar este campo por favor o usar el formato adecuado.
            </div>
        </div>

        <div class="col-md-3">
            <label class="form-label">Diametro</label>
            <input type="text" name="conexion[diametro]" value='<?php echo(isset($datos[0]['diametro']))?$datos[0]['diametro']:''; ?>' class="form-control" id="txtDiametro" pattern="[0-9]{1,3}$|^[0-9]{1,3}\.[0-9]{1,3}" required>
            <div class="invalid-feedback">
                Llenar este campo por favor o usar el formato adecuado.
            </div>
        </div>

        <div class="col-md-3">
            <label class="form-label">Marca</label>
            <select name="conexion[id_marca]" class="form-control" id="slctMarca" required>
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
            <select name="conexion[id_unidad]" class="form-control" id="slctUnidad" required>
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
            <label class="form-label">Extremidad 1</label>
            <select name="conexion[id_extremidad1]" class="form-control" id="slctExtremidad1" required>
                <?php
                echo($_GET['action'] == 'crear')?"<option disabled selected value> -- Selecciona una opción --</option>":"";
                foreach($extremidades as $key => $extremidad):
                    $selected = '';
                    if(isset($datos)){
                        if ($extremidad['id_extremidad'] == $datos[0]['id_extremidad1']) {
                            $selected = ' selected';
                        }
                    }
                    ?>
                    <option value="<?php echo($extremidad['id_extremidad']); ?>"<?php echo($selected); ?>><?php echo($extremidad['extremidad']); ?></option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">
                Seleccione una opción.
            </div>
        </div>

        <div class="col-md-3">
            <label class="form-label">Extremidad 2</label>
            <?php print_r($formas_conexion); ?>
            <select name="conexion[id_extremidad2]" class="form-control" id="slctExtremidad2" required>
                <?php
                echo($_GET['action'] == 'crear')?"<option disabled selected value> -- Selecciona una opción --</option>":"";
                foreach($extremidades as $key => $extremidad):
                    $selected = '';
                    if(isset($datos)){
                        if ($extremidad['id_extremidad'] == $datos[0]['id_extremidad2']) {
                            $selected = ' selected';
                        }
                    }
                    ?>
                    <option value="<?php echo($extremidad['id_extremidad']); ?>"<?php echo($selected); ?>><?php echo($extremidad['extremidad']); ?></option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">
                Seleccione una opción.
            </div>
        </div>

        <div class="col-md-3">
            <label class="form-label">Forma de conexión</label>
            <select name="conexion[id_forma_conexion]" class="form-control" id="slctFormaConexion" required>
                <?php
                    echo($_GET['action'] == 'crear')?"<option disabled selected value> -- Selecciona una opción --</option>":"";
                    foreach($formas_conexion as $key => $forma_conexion):
                        $selected = '';
                        if(isset($datos)){
                            if ($forma_conexion['id_forma_conexion'] == $datos[0]['id_forma_conexion']) {
                                $selected = ' selected';
                            }
                        }
                ?>
                    <option value="<?php echo($forma_conexion['id_forma_conexion']); ?>"<?php echo($selected); ?>><?php echo($forma_conexion['forma_conexion']); ?></option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">
                Seleccione una opción.
            </div>
        </div>

        <div class="col-md-3">
            <label class="form-label">Imagen</label>
            <input type="file" name="fotografia" class="form-control" required>
            <div class="invalid-feedback">
                Seleccione una imagen.
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