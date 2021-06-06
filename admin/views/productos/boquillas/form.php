<div class="ps-5 pe-5 pt-3 pb-5 my-container active-cont">
    <h1 class="display-3">Agregar/Actualizar boquilla</h1>
    <form action="boquillas.php?action=<?php echo(isset($datos))?'actualizar':'guardar'; ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Código</label>
            <input type="text" name="boquilla[codigo_producto]" value='<?php echo(isset($datos[0]['codigo_producto']))?$datos[0]['codigo_producto']:''; ?>' class="form-control" id="txtCodigo" <?php echo($_GET['action'] == 'ver')?'readonly':''?>>
        </div>

        <div class="mb-3">
            <label class="form-label">Producto</label>
            <input type="text" name="boquilla[producto]" value='<?php echo(isset($datos[0]['producto']))?$datos[0]['producto']:''; ?>' class="form-control" id="txtProducto">
        </div>

        <div class="mb-3">
            <label class="form-label">Costo</label>
            <input type="text" name="boquilla[costo]" value='<?php echo(isset($datos[0]['costo']))?$datos[0]['costo']:''; ?>' class="form-control" id="txtCosto">
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="boquilla[descripcion]" class="form-control" id="txtDescripcion" rows="3"><?php echo(isset($datos[0]['descripcion']))?$datos[0]['descripcion']:''; ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Existencias</label>
            <input type="text" name="boquilla[existencias]" value='<?php echo(isset($datos[0]['existencias']))?$datos[0]['existencias']:''; ?>' class="form-control" id="txtExistencias">
        </div>

        <div class="mb-3">
            <label class="form-label">Caudal mínimo</label>
            <input type="text" name="boquilla[caudal_minimo]" value='<?php echo(isset($datos[0]['caudal_minimo']))?$datos[0]['caudal_minimo']:''; ?>' class="form-control" id="txtCaudalMinimo">
        </div>

        <div class="mb-3">
            <label class="form-label">Caudal máximo</label>
            <input type="text" name="boquilla[caudal_maximo]" value='<?php echo(isset($datos[0]['caudal_maximo']))?$datos[0]['caudal_maximo']:''; ?>' class="form-control" id="txtCaudalMaximo">
        </div>

        <div class="mb-3">
            <label class="form-label">Presión mínima</label>
            <input type="text" name="boquilla[presion_minima]" value='<?php echo(isset($datos[0]['presion_minima']))?$datos[0]['presion_minima']:''; ?>' class="form-control" id="txtPresionMinima">
        </div>

        <div class="mb-3">
            <label class="form-label">Presión máxima</label>
            <input type="text" name="boquilla[presion_maxima]" value='<?php echo(isset($datos[0]['presion_maxima']))?$datos[0]['presion_maxima']:''; ?>' class="form-control" id="txtPresionMaxima">
        </div>

        <div class="mb-3">
            <label class="form-label">Radio mínimo</label>
            <input type="text" name="boquilla[radio_minimo]" value='<?php echo(isset($datos[0]['radio_minimo']))?$datos[0]['radio_minimo']:''; ?>' class="form-control" id="txtRadioMinimo">
        </div>

        <div class="mb-3">
            <label class="form-label">Radio máximo</label>
            <input type="text" name="boquilla[radio_maximo]" value='<?php echo(isset($datos[0]['radio_maximo']))?$datos[0]['radio_maximo']:''; ?>' class="form-control" id="txtRadioMaximo">
        </div>

        <div class="mb-3">
            <label class="form-label">Trayectoria</label>
            <input type="text" name="boquilla[trayectoria]" value='<?php echo(isset($datos[0]['trayectoria']))?$datos[0]['trayectoria']:''; ?>' class="form-control" id="txtTrayectoria">
        </div>

        <div class="mb-3">
            <label class="form-label">Ajuste</label>
            <input type="text" name="boquilla[ajuste]" value='<?php echo(isset($datos[0]['ajuste']))?$datos[0]['ajuste']:''; ?>' class="form-control" id="txtAjuste">
        </div>

        <div class="mb-3">
            <label class="form-label">Marca</label>
            <select name="boquilla[id_marca]" class="form-control" id="slctMarca">
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
        </div>

        <div class="mb-3">
            <label class="form-label">Unidad</label>
            <select name="boquilla[id_unidad]" class="form-control" id="slctUnidad">
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
        </div>

        <div class="mb-3">
            <label class="form-label">Tipo de boquilla</label>
            <select name="boquilla[id_tipo_boquilla]" class="form-control" id="slctTipoBoquilla">
                <?php
                    echo($_GET['action'] == 'crear')?"<option disabled selected value> -- Selecciona una opción --</option>":"";
                    foreach($tipos_boquilla as $key => $tipo_boquilla):
                        $selected = '';
                        if(isset($datos)){
                            if ($tipo_boquilla['id_tipo_boquilla'] == $datos[0]['id_tipo_boquilla']) {
                                $selected = ' selected';
                            }
                        }
                ?>
                    <option value="<?php echo($tipo_boquilla['id_tipo_boquilla']); ?>"<?php echo($selected); ?>><?php echo($tipo_boquilla['tipo_boquilla']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Forma de aspersión</label>
            <select name="boquilla[id_forma_aspersion]" class="form-control" id="slctFormaAspersion">
                <?php
                    echo($_GET['action'] == 'crear')?"<option disabled selected value> -- Selecciona una opción --</option>":"";
                    foreach($formas_aspersion as $key => $forma_aspersion):
                        $selected = '';
                        if(isset($datos)){
                            if ($forma_aspersion['id_forma_aspersion'] == $datos[0]['id_forma_aspersion']) {
                                $selected = ' selected';
                            }
                        }
                ?>
                    <option value="<?php echo($forma_aspersion['id_forma_aspersion']); ?>"<?php echo($selected); ?>><?php echo($forma_aspersion['forma_aspersion']); ?></option>
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