<div class="ps-5 pe-5 pb-5 my-container active-cont">
    <h3 class="display-6">Agregar producto a factura</h3>
    <form action="facturas_compra.php?action=guardar_producto" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">No. factura</label>
            <input type="text" class="form-control" name='factura_compra[id_factura]' value='<?php echo $id_factura ?>' readonly/>
        </div>

        <div class="mb-3">
            <label class="form-label">Producto</label>
            <select name="factura_compra[codigo_producto]" class="form-control" id="slctproducto">
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

        <button type="submit" name="enviar" class="btn btn-outline-success">
            <i class="fa fa-save p-1 icons"></i>
            Guardar
        </button>
    </form>
</div>