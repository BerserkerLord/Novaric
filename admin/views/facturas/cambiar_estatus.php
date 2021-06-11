<div class="ps-5 pe-5 pt-5 pb-5 my-container active-cont">
    <h3 class="display-6">Actualizar estatús</h3>
    <form action="facturas_<?php if($_GET['action'] != 'leer'){ if(isset($_GET['tipo'])) { echo(($_GET['tipo'] == 'compra')?'compra':'servicio'); } else { echo ' '; }} else { echo ' '; } ?>
.php?action=actualizar_estatus" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Estatus</label>
            <select name="factura[id_estatus_factura]" class="form-control" id="slctEstatusFactura">
                <?php
                    $acc = $_GET['action'];
                    echo "<option disabled selected value> -- Selecciona una opción --</option>";
                    echo($acc == 'ver_estatus')?"":"";
                    foreach($estatuses as $key => $estatus):
                        $selected = '';
                        print_r($estatus);
                        if($acc =='ver_estatus'){
                            if($estatus['id_estatus_factura'] == $datos[0]['id_estatus_factura']){ $selected = ' selected'; }
                        }
                        ?>
                    <option value="<?php echo($estatus['id_estatus_factura']); ?>" <?php echo($_GET['action'] == 'leer')?'':$selected; ?>><?php echo($estatus['estatus_factura']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <input type="hidden" name='factura[id_factura]' value='<?php echo($_GET['action'] == 'ver_estatus')?$datos[0]['id_factura']:''; ?>' />
        <button type="submit" name="enviar" class="btn btn-outline-success" <?php echo($_GET['action'] != 'ver_estatus')?'Disabled':''?>>
            <i class="fa fa-save p-1 icons"></i>
            Guardar
        </button>
    </form>
</div>
<?php //echo(is_null($_GET['action']))?'servicio':(($_GET['tipo'] == 'compra')?'compra':'servicio'); ?>


