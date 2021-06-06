<div class="ps-5 pe-5 pb-5 my-container active-cont">
    <h3 class="display-6">Agregar factura para servicios</h3>
    <form action="facturas_servicio.php?action=guardar_factura" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Servicios</label>
            <?php
                $info_servicios = array();
                foreach($servicios as $key => $servicio): ?>
            <div class="container">
                <div class="row pb-1">
                    <div class="form-check col-md-3 pe-2">
                        <input class="form-check-input" type="checkbox" value="<?php echo $servicio['id_servicio'] ?>" name='id_servicios[]' id="flexCheckChecked" >
                        <label class="form-check-label" for="flexCheckChecked">
                            <?php echo $servicio['servicio'] ?>
                        </label>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="montos[]">
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="mb-3">
            <label class="form-label">RFC Cliente</label>
            <select name="factura_servicio[rfc]" class="form-control" id="slctRFC">
                <?php
                    echo "<option disabled selected value> -- Selecciona una opción --</option>";
                    foreach($clientes as $key => $cliente):?>
                    <option value="<?php echo($cliente['rfc']); ?>"><?php echo($cliente['rfc']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="factura_servicio[descripcion]" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Ubicación</label>
            <textarea name="factura_servicio[domicilio]" class="form-control" rows="3"></textarea>
        </div>

        <input type="hidden" name='departamento[id_departamento]' value='<?php echo($_GET['action'] == 'ver')?$datos[0]['id_departamento']:''; ?>' />
        <button type="submit" name="enviar" class="btn btn-outline-success">
            <i class="fa fa-save p-1 icons"></i>
            Guardar
        </button>
    </form>
</div>