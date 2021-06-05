<div class="ps-5 pe-5 pt-3 my-container active-cont">
    <h3 class="display-3">Tipos de boquillas</h3>
    <div class="d-flex flex-row-reverse">
        <form action="tipos_boquilla.php" method="GET">
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
            <th scope="col">Tipo de boquilla</th>
            <th scope="col">Acción</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($datos as $key => $tipo_boquilla): ?>
            <tr>
                <td><?=$tipo_boquilla['tipo_boquilla']?></td>
                <td>
                    <a href="tipos_boquilla.php?action=ver&id_tipo_boquilla=<?=$tipo_boquilla['id_tipo_boquilla']?>" class="btn btn-primary">
                        <i class="fa fa-arrow-up p-1 icons"></i>
                    </a>
                    <a href="tipos_boquilla.php?action=eliminar&id_tipo_boquilla=<?=$tipo_boquilla['id_tipo_boquilla']?>" class="btn btn-danger">
                        <i class="fa fa-trash p-1 icons"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <nav>
        <ul class="pagination">
            <?php for($i = 0, $k = 1; $i < $tipos_boquilla -> total(); $i+=5, $k++): ?>
                <li class="page-item"><a class="page-link" href="tipos_boquilla.php?<?php echo(isset($_GET['busqueda']))?'busqueda='.$_GET['busqueda'].'&':''; ?>&desde=<?php echo($i); ?>&limite=5"><?php echo ($k); ?></a></li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php
        echo "Filtrando " . count($datos) . " de un total del " . $tipos_boquilla -> total() . " marcas"
    ?>
</div>