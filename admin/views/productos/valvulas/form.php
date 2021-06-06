<div class="ps-5 pe-5 pt-3 pb-5 my-container active-cont">
    <h1 class="display-3">Agregar/Actualizar válvula</h1>
    <form action="valvulas.php?action=<?php echo(isset($datos))?'actualizar':'guardar'; ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Código</label>
            <input type="text" name="valvula[codigo_producto]" value='<?php echo(isset($datos[0]['codigo_producto']))?$datos[0]['codigo_producto']:''; ?>' class="form-control" id="txtCodigo" <?php echo($_GET['action'] == 'ver')?'readonly':''?>>
        </div>

        <div class="mb-3">
            <label class="form-label">Producto</label>
            <input type="text" name="valvula[producto]" value='<?php echo(isset($datos[0]['producto']))?$datos[0]['producto']:''; ?>' class="form-control" id="txtProducto">
        </div>

        <div class="mb-3">
            <label class="form-label">Costo</label>
            <input type="text" name="valvula[costo]" value='<?php echo(isset($datos[0]['costo']))?$datos[0]['costo']:''; ?>' class="form-control" id="txtCosto">
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="valvula[descripcion]" class="form-control" id="txtDescripcion" rows="3"><?php echo(isset($datos[0]['descripcion']))?$datos[0]['descripcion']:''; ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Existencias</label>
            <input type="text" name="valvula[existencias]" value='<?php echo(isset($datos[0]['existencias']))?$datos[0]['existencias']:''; ?>' class="form-control" id="txtExistencias">
        </div>

        <div class="mb-3">
            <label class="form-label">Temperatura Nominal</label>
            <input type="text" name="valvula[temperatura_nominal]" value='<?php echo(isset($datos[0]['temperatura_nominal']))?$datos[0]['temperatura_nominal']:''; ?>' class="form-control" id="txtTemperaturaNominal">
        </div>

        <div class="mb-3">
            <label class="form-label">Caudal mínimo</label>
            <input type="text" name="valvula[caudal_minimo]" value='<?php echo(isset($datos[0]['caudal_minimo']))?$datos[0]['caudal_minimo']:''; ?>' class="form-control" id="txtCaudalMinimo">
        </div>

        <div class="mb-3">
            <label class="form-label">Caudal máximo</label>
            <input type="text" name="valvula[caudal_maximo]" value='<?php echo(isset($datos[0]['caudal_maximo']))?$datos[0]['caudal_maximo']:''; ?>' class="form-control" id="txtCaudalMaximo">
        </div>

        <div class="mb-3">
            <label class="form-label">Presion mínima recomendada</label>
            <input type="text" name="valvula[presion_minima_recomendada]" value='<?php echo(isset($datos[0]['presion_minima_recomendada']))?$datos[0]['presion_minima_recomendada']:''; ?>' class="form-control" id="txtPresionMinimaRecomendada">
        </div>

        <div class="mb-3">
            <label class="form-label">Presion máxima recomendada</label>
            <input type="text" name="valvula[presion_maxima_recomendada]" value='<?php echo(isset($datos[0]['presion_maxima_recomendada']))?$datos[0]['presion_minima_recomendada']:''; ?>' class="form-control" id="txtPresionMaximaRecomendada">
        </div>

        <div class="mb-3">
            <label class="form-label">Especificación del solenoide</label>
            <textarea name ="valvula[especificacion_solenoide]" class="form-control" id="txtEspecificacionSolenoide" rows="3"><?php echo(isset($datos[0]['especificacion_solenoide']))?$datos[0]['especificacion_solenoide']:''; ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Marca</label>
            <select name="valvula[id_marca]" class="form-control" id="slctMarca">
                <?php
                echo($_GET['action'] == 'crear')?"<option disabled selected value> -- Selecciona una opción --</option>":"";
                print_r($marcas);
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
        </div>

        <div class="mb-3">
            <label class="form-label">Unidad</label>
            <select name="valvula[id_unidad]" class="form-control" id="slctUnidad">
                <?php
                echo($_GET['action'] == 'crear')?"<option disabled selected value> -- Selecciona una opción --</option>":"";
                print_r($unidades);
                foreach($unidades as $key => $unidad):
                    $selected = '';
                    if(isset($datos)){
                        if ($unidad['id_unidad'] == $datos[0]['codigo_producto']) {
                            $selected = ' selected';
                        }
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