<div class="ps-5 pe-5 pt-3 pb-3 my-container active-cont">
    <h3 class="display-3">Tuberías</h3>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <a href="tuberias.php?action=crear" class="btn btn-outline-success mb-3"><i class="fa fa-plus p-1 icons"></i>
                    Agregar
                </a>
            </div>
            <div class="col-md-4 offset-md-4">
                <form action="tuberias.php" method="GET">
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
        <?php foreach($datos as $key => $tuberia): ?>
            <tr>
                <td>
                    <img src="<?php echo (isset($tuberia['fotografia']))? '../archivos/'.$tuberia['fotografia']: '../archivos/default.jpg'; ?>" alt="foto tuberia" class="rounded img-fluid" height="75px" width="75px">
                </td>
                <td><?=$tuberia['codigo_producto']?></td>
                <td><?=$tuberia['producto']?></td>
                <td><?=$tuberia['costo']?></td>
                <td><?=$tuberia['precio']?></td>
                <td><?=$tuberia['precio_publico']?></td>
                <td><?=$tuberia['existencias'] . ' ' . $tuberia['unidad'] . '(s)'?></td>
                <td><?=$tuberia['marca']?></td>
                <td>
                    <a href="tuberias.php?action=ver&codigo_producto=<?=$tuberia['codigo_producto']?>" class="btn btn-outline-primary">
                        <i class="fa fa-arrow-up p-1 icons"></i>
                    </a>
                    <a href="tuberias.php?action=eliminar&codigo_producto=<?=$tuberia['codigo_producto']?>" class="btn btn-outline-danger">
                        <i class="fa fa-trash p-1 icons"></i>
                    </a>
                </td>
            </tr>
            <tr>
                <td colspan="10"><?="<b>" . "Descripción: " . "</b>" . $tuberia['descripcion']?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <h3 class="display-6 pt-4">Ficha Técnica</h3>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th scope="col">Código</th>
            <th scope="col">Diametro</th>
            <th scope="col">Longitud</th>
            <th scope="col">Extremidades</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($datos as $key => $tuberia): ?>
            <tr>
                <td><?=$tuberia['codigo_producto']?></td>
                <td><?=$tuberia['diametro'] . ' mm'?></td>
                <td><?=$tuberia['longitud'] . ' m'?></td>
                <td><?=$tuberia['extremidad1'] . " - " . $tuberia['extremidad2']?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <nav>
        <ul class="pagination">
            <?php for($i = 0, $k = 1; $i < $tuberias -> total('codigo_producto', 'tuberia'); $i+=10, $k++): ?>
                <li class="page-item"><a class="page-link" href="tuberias.php?<?php echo(isset($_GET['busqueda']))?'busqueda='.$_GET['busqueda'].'&':''; ?>&desde=<?php echo($i); ?>&limite=10"><?php echo ($k); ?></a></li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php
        echo "Filtrando " . count($datos) . " de un total del " . $tuberias -> total('codigo_producto', 'tuberia') . " tuberias"
    ?>
</div>