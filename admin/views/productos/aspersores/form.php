<div class="ps-5 pe-5 pt-3 pb-5 my-container active-cont">
    <h1 class="display-3">Agregar/Actualizar aspersor</h1>
    <form action="aspersores.php?action=<?php echo(isset($datos))?'actualizar':'guardar'; ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Código</label>
            <input type="text" name="aspersor[codigo_producto]" value='<?php echo(isset($datos[0]['codigo_producto']))?$datos[0]['codigo_producto']:''; ?>' class="form-control" id="txtCodigo" <?php echo($_GET['action'] == 'ver')?'readonly':''?>>
        </div>

        <div class="mb-3">
            <label class="form-label">Producto</label>
            <input type="text" name="aspersor[producto]" value='<?php echo(isset($datos[0]['producto']))?$datos[0]['producto']:''; ?>' class="form-control" id="txtProducto">
        </div>

        <div class="mb-3">
            <label class="form-label">Costo</label>
            <input type="taxt" name="aspersor[costo]" value='<?php echo(isset($datos[0]['costo']))?$datos[0]['costo']:''; ?>' class="form-control" id="txtCosto">
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="aspersor[descripcion]" class="form-control" id="txtDescripcion" rows="3"><?php echo(isset($datos[0]['descripcion']))?$datos[0]['descripcion']:''; ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Existencias</label>
            <input type="text" name="aspersor[existencias]" value='<?php echo(isset($datos[0]['existencias']))?$datos[0]['existencias']:''; ?>' class="form-control" id="txtExistencias">
        </div>

        <div class="mb-3">
            <label class="form-label">Caudal mínimo</label>
            <input type="text" name="aspersor[caudal_minimo]" value='<?php echo(isset($datos[0]['caudal_minimo']))?$datos[0]['caudal_minimo']:''; ?>' class="form-control" id="txtCaudalMinimo">
        </div>

        <div class="mb-3">
            <label class="form-label">Caudal máximo</label>
            <input type="text" name="aspersor[caudal_maximo]" value='<?php echo(isset($datos[0]['caudal_maximo']))?$datos[0]['caudal_maximo']:''; ?>' class="form-control" id="txtCaudalMaximo">
        </div>

        <div class="mb-3">
            <label class="form-label">Presión mínima</label>
            <input type="text" name="aspersor[presion_minima]" value='<?php echo(isset($datos[0]['presion_minima']))?$datos[0]['presion_minima']:''; ?>' class="form-control" id="txtPresionMinima">
        </div>

        <div class="mb-3">
            <label class="form-label">Presión máxima</label>
            <input type="text" name="aspersor[presion_maxima]" value='<?php echo(isset($datos[0]['presion_maxima']))?$datos[0]['presion_maxima']:''; ?>' class="form-control" id="txtPresionMaxima">
        </div>

        <div class="mb-3">
            <label class="form-label">Alcance mínimo</label>
            <input type="text" name="aspersor[alcance_minimo]" value='<?php echo(isset($datos[0]['alcance_minimo']))?$datos[0]['alcance_minimo']:''; ?>' class="form-control" id="txtAlcanceMinimo">
        </div>

        <div class="mb-3">
            <label class="form-label">Alcance máximo</label>
            <input type="text" name="aspersor[alcance_maximo]" value='<?php echo(isset($datos[0]['alcance_maximo']))?$datos[0]['alcance_maximo']:''; ?>' class="form-control" id="txtAlcanceMaximo">
        </div>

        <div class="mb-3">
            <label class="form-label">Marca</label>
            <select name="aspersor[id_marca]" class="form-control" id="slctMarca">
                <?php
                    echo($_GET['action'] == 'crear')?"<option disabled selected value> -- Selecciona una opción --</option>":"";
                    foreach($marcas as $key => $marca):
                        $selected = '';
                        if(isset($datos)){
                            if($marca['id_marca'] == $datos[0]['id_marca']){ $selected = ' selected'; }
                        }
                ?>
                    <option value="<?php echo($marca['id_marca']); ?>"<?php echo($selected); ?>><?php echo($marca['marca']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Unidad</label>
            <select name="aspersor[id_unidad]" class="form-control" id="slctUnidad">
                <?php
                    echo($_GET['action'] == 'crear')?"<option disabled selected value> -- Selecciona una opción --</option>":"";
                    foreach($unidades as $key => $unidad):
                        $selected = '';
                        if(isset($datos)){
                            if ($unidad['id_unidad'] == $datos[0]['id_unidad']) { $selected = ' selected'; }
                        }
                ?>
                    <option value="<?php echo($unidad['id_unidad']); ?>"<?php echo($selected); ?>><?php echo($unidad['unidad']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Imagen</label>
            <input type="file" name="fotografia" class="form-control">
        </div>

        <button type="submit" name="enviar" class="btn btn-outline-primary">
            Guardar
            <i class="fa fa-save p-1 icons"></i>
        </button>
    </form>
</div>