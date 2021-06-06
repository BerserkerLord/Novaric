<div class="ps-5 pe-5 pt-3 pb-5 my-container active-cont">
    <h1 class="display-3">Agregar/Actualizar programador</h1>
    <form action="programadores.php?action=<?php echo(isset($datos))?'actualizar':'guardar'; ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Código</label>
            <input type="text" name="programador[codigo_producto]" value='<?php echo(isset($datos[0]['codigo_producto']))?$datos[0]['codigo_producto']:''; ?>' class="form-control" id="txtCodigo" <?php echo($_GET['action'] == 'ver')?'readonly':''?>>
        </div>

        <div class="mb-3">
            <label class="form-label">Producto</label>
            <input type="text" name="programador[producto]" value='<?php echo(isset($datos[0]['producto']))?$datos[0]['producto']:''; ?>' class="form-control" id="txtProducto">
        </div>

        <div class="mb-3">
            <label class="form-label">Costo</label>
            <input type="text" name="programador[costo]" value='<?php echo(isset($datos[0]['costo']))?$datos[0]['costo']:''; ?>' class="form-control" id="txtCosto">
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="programador[descripcion]" class="form-control" id="txtDescripcion" rows="3"><?php echo(isset($datos[0]['descripcion']))?$datos[0]['descripcion']:''; ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Existencias</label>
            <input type="text" name="programador[existencias]" value='<?php echo(isset($datos[0]['existencias']))?$datos[0]['existencias']:''; ?>' class="form-control" id="txtExistencias">
        </div>

        <div class="mb-3">
            <label class="form-label">Máximo de estaciones</label>
            <input type="text" name="programador[maximo_estaciones]" value='<?php echo(isset($datos[0]['maximo_estaciones']))?$datos[0]['maximo_estaciones']:''; ?>' class="form-control" id="txtMaximoEstaciones">
        </div>

        <div class="mb-3">
            <label class="form-label">Entradas de sensores</label>
            <input type="text" name="programador[entradas_sensores]" value='<?php echo(isset($datos[0]['entradas_sensores']))?$datos[0]['entradas_sensores']:''; ?>' class="form-control" id="txtEntradasSensores">
        </div>

        <div class="mb-3">
            <label class="form-label">Entrada de transformador</label>
            <input type="text" name="programador[entrada_transformador]" value='<?php echo(isset($datos[0]['entrada_transformador']))?$datos[0]['entrada_transformador']:''; ?>' class="form-control" id="txtEntradaTransformador">
        </div>

        <div class="mb-3">
            <label class="form-label">Salida del transformador(24 VCA)</label>
            <input type="text" name="programador[salida_transformador]" value='<?php echo(isset($datos[0]['salida_transformador']))?$datos[0]['salida_transformador']:''; ?>' class="form-control" id="txtSalidaTransformador">
        </div>

        <div class="mb-3">
            <label class="form-label">Salida de la estación(24 VCA)</label>
            <input type="text" name="programador[salida_estacion]" value='<?php echo(isset($datos[0]['salida_estacion']))?$datos[0]['salida_estacion']:''; ?>' class="form-control" id="txtSalidaEstacion">
        </div>

        <div class="mb-3">
            <label class="form-label">Salida P/MV(24 VCA)</label>
            <input type="text" name="programador[salida_p_mv]" value='<?php echo(isset($datos[0]['salida_p_mv']))?$datos[0]['salida_p_mv']:''; ?>' class="form-control" id="txtSalidaPMV">
        </div>

        <div class="mb-3">
            <label class="form-label">Imagen</label>
            <input type="file" name="fotografia" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Marca</label>
            <select name="programador[id_marca]" class="form-control" id="slctMarca">
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
            <select name="programador[id_unidad]" class="form-control" id="slctUnidad">
                <?php
                echo($_GET['action'] == 'crear')?"<option disabled selected value> -- Selecciona una opción --</option>":"";
                print_r($unidades);
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

        <button type="submit" name="enviar" class="btn btn-outline-primary">
            Guardar
            <i class="fa fa-save p-1 icons"></i>
        </button>
    </form>
</div>