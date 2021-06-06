<div class="ps-5 pe-5 pt-3 pb-3 my-container active-cont">
    <h3 class="display-3">Válvulas</h3>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <a href="valvulas.php?action=crear" class="btn btn-outline-success mb-3"><i class="fa fa-plus p-1 icons"></i>
                    Agregar
                </a>
            </div>
            <div class="col-md-4 offset-md-4">
                <form action="valvulas.php" method="GET">
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
        <?php foreach($datos as $key => $valvula): ?>
            <tr>
                <td>
                    <img src="<?php echo (isset($valvula['fotografia']))? '../archivos/'.$valvula['fotografia']: '../archivos/default.jpg'; ?>" alt="foto valvula" class="rounded img-fluid" height="75px" width="75px">
                </td>
                <td><?=$valvula['codigo_producto']?></td>
                <td><?=$valvula['producto']?></td>
                <td><?=$valvula['costo']?></td>
                <td><?=$valvula['precio']?></td>
                <td><?=$valvula['precio_publico']?></td>
                <td><?=$valvula['existencias'] . ' ' . $valvula['unidad'] . '(s)'?></td>
                <td><?=$valvula['marca']?></td>
                <td>
                    <a href="valvulas.php?action=ver&codigo_producto=<?=$valvula['codigo_producto']?>" class="btn btn-outline-primary">
                        <i class="fa fa-arrow-up p-1 icons"></i>
                    </a>
                    <a href="valvulas.php?action=eliminar&codigo_producto=<?=$valvula['codigo_producto']?>" class="btn btn-outline-danger">
                        <i class="fa fa-trash p-1 icons"></i>
                    </a>
                </td>
            </tr>
            <tr>
                <td colspan="10"><?="<b>" . "Descripción: " . "</b>" . $valvula['descripcion']?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <h3 class="display-6 pt-4">Ficha Técnica</h3>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th scope="col"">Código</th>
            <th scope="col">Temperatura nominal</th>
            <th scope="col">Caudal</th>
            <th scope="col">Presion Recomendada</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($datos as $key => $valvula): ?>
            <tr>
                <td rowspan="2"><?=$valvula['codigo_producto']?></td>
                <td><?=$valvula['temperatura_nominal']?>&#8451;</td>
                <td><?=$valvula['presion_minima_recomendada'] . ' bar' . ' - ' . $valvula['presion_maxima_recomendada'] . ' bar'?></td>
                <td><?=$valvula['caudal_minimo'] . 'm' . '<sup>3</sup>' . '/hr - ' . $valvula['caudal_maximo'] . 'm' . '<sup>3</sup>' . '/hr'?></td>
            </tr>
            <tr>
                <td colspan="3"><?="<b>" . "Especificaciones del solenoide: " . "</b>" . $valvula['especificacion_solenoide']?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <nav>
        <ul class="pagination">
            <?php for($i = 0, $k = 1; $i < $valvulas -> total('codigo_producto', 'valvula'); $i+=10, $k++): ?>
                <li class="page-item"><a class="page-link" href="valvulas.php?<?php echo(isset($_GET['busqueda']))?'busqueda='.$_GET['busqueda'].'&':''; ?>&desde=<?php echo($i); ?>&limite=10"><?php echo ($k); ?></a></li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php
        echo "Filtrando " . count($datos) . " de un total del " . $valvulas -> total('codigo_producto', 'valvula') . " valvulas"
    ?>
</div>