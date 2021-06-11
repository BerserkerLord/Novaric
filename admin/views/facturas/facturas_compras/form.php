<div class="ps-5 pe-5 pb-5 my-container active-cont">
    <h3 class="display-6">Agregar factura</h3>
    <form action="facturas_compra.php?action=guardar_factura" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Producto</label>
            <select name="factura_compra[codigo_producto]" class="form-control" id="slctProducto">
                <?php
                echo "<option disabled selected value> -- Selecciona una opción --</option>";
                foreach($productos as $key => $producto):?>
                    <option value="<?php echo($producto['codigo_producto']); ?>"><?php echo($producto['producto']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Cantidad</label>
            <input type="text" name="factura_compra[cantidad]" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">RFC Proveedor</label>
            <select name="factura_compra[rfc]" class="form-control" id="slctRazonSocial">
                <?php
                echo "<option disabled selected value> -- Selecciona una opción --</option>";
                foreach($proveedores as $key => $proveedor):?>
                    <option value="<?php echo($proveedor['rfc']); ?>"><?php echo($proveedor['razon_social']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" name="enviar" class="btn btn-outline-success">
            <i class="fa fa-save p-1 icons"></i>
            Guardar
        </button>
    </form>
</div>