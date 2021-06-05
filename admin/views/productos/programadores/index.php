<div class="ps-5 pe-5 pt-3 pb-3 my-container active-cont">
    <h3 class="display-3">Programadores</h3>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <a href="programadores.php?action=crear" class="btn btn-success mb-3"><i class="fa fa-plus p-1 icons"></i>
                    Agregar
                </a>
            </div>
            <div class="col-md-4 offset-md-4">
                <form action="programadores.php" method="GET">
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
            <th scope="col" >Imagen</th>
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
        <?php foreach($datos as $key => $programador): ?>
            <tr>
                <td>
                    <img src="<?php echo (isset($programador['fotografia']))? '../archivos/'.$programador['fotografia']: '../archivos/default.jpg'; ?>" alt="foto programador" class="rounded img-fluid" height="75px" width="75px">
                </td>
                <td><?=$programador['codigo_producto']?></td>
                <td><?=$programador['producto']?></td>
                <td><?=$programador['costo']?></td>
                <td><?=$programador['precio']?></td>
                <td><?=$programador['precio_publico']?></td>
                <td><?=$programador['existencias'] . ' ' . $programador['unidad'] . '(s)'?></td>
                <td><?=$programador['marca']?></td>
                <td>
                    <a href="programadores.php?action=ver&codigo_producto=<?=$programador['codigo_producto']?>" class="btn btn-primary">
                        <i class="fa fa-arrow-up p-1 icons"></i>
                    </a>
                    <a href="programadores.php?action=eliminar&codigo_producto=<?=$programador['codigo_producto']?>" class="btn btn-danger">
                        <i class="fa fa-trash p-1 icons"></i>
                    </a>
                </td>
            </tr>
            <tr>
                <td colspan="10"><?="<b>" . "Descripción: " . "</b>" . $programador['descripcion']?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <h3 class="display-6 pt-4">Ficha Técnica</h3>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th scope="col">Código</th>
            <th scope="col">Máximo de estaciones</th>
            <th scope="col">Entradas de sensores</th>
            <th scope="col">Entrada de transformador</th>
            <th scope="col">Salida del transformador(24 VCA)</th>
            <th scope="col">Salida de la estación(24 VCA)</th>
            <th scope="col">Salida P/MV(24 VCA)</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($datos as $key => $programador): ?>
            <tr>
                <td><?=$programador['codigo_producto']?></td>
                <td><?=$programador['maximo_estaciones']?></td>
                <td><?=$programador['entradas_sensores']?></td>
                <td><?=$programador['entrada_transformador']?></td>
                <td><?=$programador['salida_transformador'] . ' A'?></td>
                <td><?=$programador['salida_estacion'] . ' A'?></td>
                <td><?=$programador['salida_p_mv'] . ' A'?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <nav>
        <ul class="pagination">
            <?php for($i = 0, $k = 1; $i < $programadores -> total('codigo_producto', 'programador'); $i+=10, $k++): ?>
                <li class="page-item"><a class="page-link" href="programadores.php?<?php echo(isset($_GET['busqueda']))?'busqueda='.$_GET['busqueda'].'&':''; ?>&desde=<?php echo($i); ?>&limite=10"><?php echo ($k); ?></a></li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php
        echo "Filtrando " . count($datos) . " de un total del " . $programadores -> total('codigo_producto', 'programador') . " programadores"
    ?>
</div>