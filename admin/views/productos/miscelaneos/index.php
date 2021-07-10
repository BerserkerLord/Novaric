<div class="ps-5 pe-5 pt-3 pb-3 my-container active-cont">
    <h3 class="display-3">Miscelaneos</h3>
    <div>
        <div class="row no-gutters">
            <div class="col-md-4">
                <a href="miscelaneos.php?action=crear" class="btn btn-outline-success mb-3"><i class="fa fa-plus p-1 icons"></i>
                    Agregar
                </a>
            </div>
            <div class="d-flex flex-row-reverse">
                <form action="miscelaneos.php" method="GET">
                    <input class="input-group-text pe-1" style="display:inline-block;" type="text" name="busqueda">
                    <button class="btn btn-outline-secondary" type="submit">
                        Buscar
                        <i class="fa fa-search p-1 icons"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th scope="col">Imagen</th>
            <th scope="col">Código</th>
            <th scope="col">Producto</th>
            <th scope="col">Costo</th>
            <th scope="col">Precio</th>
            <th scope="col">Precio público</th>
            <th scope="col">Existencias</th>
            <th scope="col">Marca</th>
            <th scope="col">Acción</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($datos as $key => $miscelaneo): ?>
            <tr>
                <td>
                    <img src="<?php echo (isset($miscelaneo['fotografia']))? '../archivos/'.$miscelaneo['fotografia']: '../archivos/default.jpg'; ?>" alt="foto miscelaneo" class="rounded img-fluid" height="75" width="75">
                </td>
                <td><?=$miscelaneo['codigo_producto']?></td>
                <td><?=$miscelaneo['producto']?></td>
                <td><?=$miscelaneo['costo']?></td>
                <td><?=$miscelaneo['precio']?></td>
                <td><?=$miscelaneo['precio_publico']?></td>
                <td><?=$miscelaneo['existencias'] . ' ' . $miscelaneo['unidad'] . '(s)'?></td>
                <td><?=$miscelaneo['marca']?></td>
                <td>
                    <a href="miscelaneos.php?action=ver&codigo_producto=<?=$miscelaneo['codigo_producto']?>" class="btn btn-outline-primary">
                        <i class="fa fa-arrow-up p-1 icons"></i>
                    </a>
                    <a href="miscelaneos.php?action=eliminar&codigo_producto=<?=$miscelaneo['codigo_producto']?>" class="btn btn-outline-danger">
                        <i class="fa fa-trash p-1 icons"></i>
                    </a>
                </td>
            </tr>
            <tr>
                <td colspan="9"><?="<b>" . "Descripción: " . "</b>" . $miscelaneo['descripcion']?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <nav>
        <ul class="pagination">
            <?php for($i = 0, $k = 1; $i < $miscelaneos -> total('codigo_producto', 'miscelaneo'); $i+=5, $k++): ?>
                <li class="page-item"><a class="page-link" href="miscelaneos.php?<?php echo(isset($_GET['busqueda']))?'busqueda='.$_GET['busqueda'].'&':''; ?>&desde=<?php echo($i); ?>&limite=5"><?php echo ($k); ?></a></li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php
        echo "Filtrando " . count($datos) . " de un total del " . $miscelaneos -> total('codigo_producto', 'miscelaneo') . " miscelaneos"
    ?>
</div>