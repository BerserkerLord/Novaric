<div class="ps-5 pe-5 pt-3 my-container active-cont">
    <h3 class="display-3">Servicios</h3>
    <div class="d-flex flex-row-reverse">
        <form action="servicios.php" method="GET">
            <input class="input-group-text pe-1" style="display:inline-block;" type="text" name="busqueda">
            <button class="btn btn-outline-secondary" type="submit">
                Buscar
                <i class="fa fa-search p-1 icons"></i>
            </button>
        </form>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Fotografia</th>
            <th scope="col">Servicio</th>
            <th scope="col">Descripción</th>
            <th scope="col">Acción</th>
        </tr>
        </thead>
        <tbody>
            <?php foreach($datos as $key => $servicio): ?>
                <tr>
                    <td>
                        <img src="<?php echo (isset($servicio['fotografia']))? '../archivos/'.$servicio['fotografia']: '../archivos/default.jpg'; ?>" alt="foto servicio" class="rounded img-fluid" width="75">
                    </td>
                    <td><?=$servicio['servicio']?></td>
                    <td><?=$servicio['descripcion']?></td>
                    <td>
                        <a href="servicios.php?action=ver&id_servicio=<?=$servicio['id_servicio']?>" class="btn btn-outline-primary">
                            <i class="fa fa-arrow-up p-1 icons"></i>
                        </a>
                        <a href="servicios.php?action=eliminar&id_servicio=<?=$servicio['id_servicio']?>" class="btn btn-outline-danger">
                            <i class="fa fa-trash p-1 icons"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <nav>
        <ul class="pagination">
            <?php for($i = 0, $k = 1; $i < $servicios -> total(); $i+=3, $k++): ?>
                <li class="page-item"><a class="page-link" href="servicios.php?<?php echo(isset($_GET['busqueda']))?'busqueda='.$_GET['busqueda'].'&':''; ?>&desde=<?php echo($i); ?>&limite=3"><?php echo ($k); ?></a></li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php
        echo "Filtrando " . count($datos) . " de un total del " . $servicios -> total() . " servicios"
    ?>
</div>

