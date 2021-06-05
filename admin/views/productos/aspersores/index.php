<div class="ps-5 pe-5 pt-3 pb-3 my-container active-cont">
    <h3 class="display-3">Aspersores</h3>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <a href="aspersores.php?action=crear" class="btn btn-success mb-3"><i class="fa fa-plus p-1 icons"></i>
                    Agregar
                </a>
            </div>
            <div class="col-md-4 offset-md-4">
                <form action="aspersores.php" method="GET">
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
        <?php foreach($datos as $key => $aspersor): ?>
            <tr>
                <td>
                    <img src="<?php echo (isset($aspersor['fotografia']))? '../archivos/'.$aspersor['fotografia']: '../archivos/default.jpg'; ?>" alt="foto tuberia" class="rounded img-fluid" height="75px" width="75px">
                </td>
                <td><?=$aspersor['codigo_producto']?></td>
                <td><?=$aspersor['producto']?></td>
                <td><?=$aspersor['costo']?></td>
                <td><?=$aspersor['precio']?></td>
                <td><?=$aspersor['precio_publico']?></td>
                <td><?=$aspersor['existencias'] . ' ' . $aspersor['unidad'] . '(s)'?></td>
                <td><?=$aspersor['marca']?></td>
                <td>
                    <a href="aspersores.php?action=ver&codigo_producto=<?=$aspersor['codigo_producto']?>" class="btn btn-primary">
                        <i class="fa fa-arrow-up p-1 icons"></i>
                    </a>
                    <a href="aspersores.php?action=eliminar&codigo_producto=<?=$aspersor['codigo_producto']?>" class="btn btn-danger">
                        <i class="fa fa-trash p-1 icons"></i>
                    </a>
                </td>
            </tr>
            <tr>
                <td colspan="10"><?="<b>" . "Descripción: " . "</b>" . $aspersor['descripcion']?></td>
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
            <th scope="col">Alcance</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($datos as $key => $aspersor): ?>
            <tr>
                <td><?=$aspersor['codigo_producto']?></td>
                <td><?=$aspersor['caudal_minimo'] . 'm' . '<sup>3</sup>' . '/hr - ' . $aspersor['caudal_maximo'] . 'm' . '<sup>3</sup>' . '/hr'?></td>
                <td><?=$aspersor['presion_minima'] . ' bar' . ' - ' . $aspersor['presion_maxima'] . ' bar'?></td>
                <td><?=$aspersor['alcance_minimo'] . " m - " . $aspersor['alcance_maximo'] . ' m'?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <nav>
        <ul class="pagination">
            <?php for($i = 0, $k = 1; $i < $aspersores -> total('codigo_producto', 'aspersor'); $i+=10, $k++): ?>
                <li class="page-item"><a class="page-link" href="aspersores.php?<?php echo(isset($_GET['busqueda']))?'busqueda='.$_GET['busqueda'].'&':''; ?>&desde=<?php echo($i); ?>&limite=10"><?php echo ($k); ?></a></li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php
        echo "Filtrando " . count($datos) . " de un total del " . $aspersores -> total('codigo_producto', 'aspersor') . " aspersores"
    ?>
</div>