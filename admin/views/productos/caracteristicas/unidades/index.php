<div class="ps-5 pe-5 pt-3 my-container active-cont">
    <h3 class="display-3">Unidades</h3>
    <div class="d-flex flex-row-reverse">
        <form action="unidades.php" method="GET">
            <input class="input-group-text" style="display:inline-block;" type="text" name="busqueda">
            <button class="btn btn-outline-secondary" type="submit">
                Buscar
                <i class="fa fa-search p-1 icons"></i>
            </button>
        </form>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Unidad</th>
            <th scope="col">Acción</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($datos as $key => $unidad): ?>
            <tr>
                <td><?=$unidad['unidad']?></td>
                <td>
                    <a href="unidades.php?action=ver&id_unidad=<?=$unidad['id_unidad']?>" class="btn btn-outline-primary">
                        <i class="fa fa-arrow-up p-1 icons"></i>
                    </a>
                    <a href="unidades.php?action=eliminar&id_unidad=<?=$unidad['id_unidad']?>" class="btn btn-outline-danger">
                        <i class="fa fa-trash p-1 icons"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <nav>
        <ul class="pagination">
            <?php for($i = 0, $k = 1; $i < $unidades -> total(); $i+=5, $k++): ?>
                <li class="page-item"><a class="page-link" href="unidades.php?<?php echo(isset($_GET['busqueda']))?'busqueda='.$_GET['busqueda'].'&':''; ?>&desde=<?php echo($i); ?>&limite=5"><?php echo ($k); ?></a></li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php
        echo "Filtrando " . count($datos) . " de un total del " . $unidades -> total() . " unidades"
    ?>
</div>