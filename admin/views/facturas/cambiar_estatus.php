<?php
    if($_GET['action'] == 'ver_estatus'){
        $tipo = '';
        if(isset($_GET['tipo'])){
            switch($_GET['tipo'])
            {
                case 'compra': $tipo = 'compra'; break;
                case 'venta': $tipo = 'venta'; break;
                case 'servicio': $tipo = 'servicio'; break;
            }
        }
    }
?>

<div class="ps-5 pe-5 pt-5 pb-5 my-container active-cont">
    <h3 class="display-6">Actualizar estatús</h3>
    <form action="facturas_<?php if($_GET['action'] != 'leer'){ if(isset($_GET['tipo'])) { echo $tipo; } else { echo ' '; }} else { echo ' '; } ?>
.php?action=actualizar_estatus" method="POST" enctype="multipart/form-data" class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Estatus</label>
            <select name="factura[id_estatus_factura]" class="form-control" id="slctEstatusFactura">
                <?php
                    $acc = $_GET['action'];
                    echo "<option disabled value> -- Selecciona una opción --</option>";
                    echo($acc == 'ver_estatus')?"":"";
                    foreach($estatuses as $key => $estatus):
                        $selected = '';
                        if($acc =='ver_estatus'){
                            if($estatus['id_estatus_factura'] == $datos[0]['id_estatus_factura']){ $selected = ' selected'; }
                        }
                        ?>
                    <option value="<?php echo($estatus['id_estatus_factura']); ?>" <?php echo($_GET['action'] == 'leer')?'':$selected; ?>><?php echo($estatus['estatus_factura']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <?php
            $dis = '';
            if($_GET['action'] == 'ver_estatus'){
                $dis = '';
            } else {
                $dis = 'disabled';
            }
        ?>

        <input type="hidden" name='factura[id_factura]' value='<?php echo($_GET['action'] == 'ver_estatus')?$datos[0]['id_factura']:''; ?>' />
        <div class="col-12">
            <button type="submit" name="enviar" class="btn btn-outline-success" <?=$dis;?>>
                <i class="fa fa-save p-1 icons"></i>
                Guardar
            </button>
        </div>
    </form>
</div>
<?php //echo(is_null($_GET['action']))?'servicio':(($_GET['tipo'] == 'compra')?'compra':'servicio'); ?>


