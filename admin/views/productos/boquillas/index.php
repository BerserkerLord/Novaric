<div class="ps-5 pe-5 pt-3 pb-3 my-container active-cont">
    <h3 class="display-3">Boquillas</h3>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <a href="boquillas.php?action=crear" class="btn btn-outline-success mb-3"><i class="fa fa-plus p-1 icons"></i>
                    Agregar
                </a>
            </div>
            <div class="col-md-4 offset-md-4">
                <form action="boquillas.php" method="GET">
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
        <?php foreach($datos as $key => $boquilla): ?>
            <tr>
                <td>
                    <img src="<?php echo (isset($boquilla['fotografia']))? '../archivos/'.$boquilla['fotografia']: '../archivos/default.jpg'; ?>" alt="foto tuberia" class="rounded img-fluid" height="75px" width="75px">
                </td>
                <td><?=$boquilla['codigo_producto']?></td>
                <td><?=$boquilla['producto']?></td>
                <td><?=$boquilla['costo']?></td>
                <td><?=$boquilla['precio']?></td>
                <td><?=$boquilla['precio_publico']?></td>
                <td><?=$boquilla['existencias'] . ' ' . $boquilla['unidad'] . '(s)'?></td>
                <td><?=$boquilla['marca']?></td>
                <td>
                    <a href="boquillas.php?action=ver&codigo_producto=<?=$boquilla['codigo_producto']?>" class="btn btn-outline-primary">
                        <i class="fa fa-arrow-up p-1 icons"></i>
                    </a>
                    <a href="boquillas.php?action=eliminar&codigo_producto=<?=$boquilla['codigo_producto']?>" class="btn btn-outline-danger">
                        <i class="fa fa-trash p-1 icons"></i>
                    </a>
                </td>
            </tr>
            <tr>
                <td colspan="10"><?="<b>" . "Descripción: " . "</b>" . $boquilla['descripcion']?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <h3 class="display-6 pt-4">Ficha Técnica</h3>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th scope="col">Código</th>
            <th scope="col">Caudal</th>
            <th scope="col">Presión</th>
            <th scope="col">Radio</th>
            <th scope="col">Trayectoria</th>
            <th scope="col">Ajuste</th>
            <th scope="col">Tipo</th>
            <th scope="col">Forma de aspersión</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($datos as $key => $boquilla): ?>
            <tr>
                <td><?=$boquilla['codigo_producto']?></td>
                <td><?=$boquilla['caudal_minimo'] . 'm' . '<sup>3</sup>' . '/hr - ' . $boquilla['caudal_maximo'] . 'm' . '<sup>3</sup>' . '/hr'?></td>
                <td><?=$boquilla['presion_minima'] . ' bar' . ' - ' . $boquilla['presion_minima'] . ' bar'?></td>
                <td><?=$boquilla['radio_minimo'] . " m - " . $boquilla['radio_maximo'] . ' m'?></td>
                <td><?=$boquilla['trayectoria']?>&deg;</td>
                <td><?=$boquilla['ajuste']?></td>
                <td><?=$boquilla['tipo_boquilla']?></td>
                <td><?=$boquilla['forma_aspersion']?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <nav>
        <ul class="pagination">
            <?php for($i = 0, $k = 1; $i < $boquillas -> total('codigo_producto', 'boquilla'); $i+=10, $k++): ?>
                <li class="page-item"><a class="page-link" href="boquillas.php?<?php echo(isset($_GET['busqueda']))?'busqueda='.$_GET['busqueda'].'&':''; ?>&desde=<?php echo($i); ?>&limite=10"><?php echo ($k); ?></a></li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php
        echo "Filtrando " . count($datos) . " de un total del " . $boquillas -> total('codigo_producto', 'boquilla') . " boquillas"
    ?>
</div>