<div class="ps-5 pe-5 pt-3 my-container active-cont">
    <h3 class="display-3">Formas de aspresión de boquillas</h3>
    <div class="d-flex flex-row-reverse">
        <form action="formas_aspersion.php" method="GET">
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
            <th scope="col">Forma de aspersión</th>
            <th scope="col">Acción</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($datos as $key => $forma_aspersion): ?>
            <tr>
                <td><?=$forma_aspersion['forma_aspersion']?></td>
                <td>
                    <a href="formas_aspersion.php?action=ver&id_forma_aspersion=<?=$forma_aspersion['id_forma_aspersion']?>" class="btn btn-outline-primary">
                        <i class="fa fa-arrow-up p-1 icons"></i>
                    </a>
                    <a href="formas_aspersion.php?action=eliminar&id_forma_aspersion=<?=$forma_aspersion['id_forma_aspersion']?>" class="btn btn-outline-danger">
                        <i class="fa fa-trash p-1 icons"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <nav>
        <ul class="pagination">
            <?php for($i = 0, $k = 1; $i < $formas_aspersion -> total(); $i+=5, $k++): ?>
                <li class="page-item"><a class="page-link" href="formas_aspersiona.php?<?php echo(isset($_GET['busqueda']))?'busqueda='.$_GET['busqueda'].'&':''; ?>&desde=<?php echo($i); ?>&limite=5"><?php echo ($k); ?></a></li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php
        echo "Filtrando " . count($datos) . " de un total del " . $formas_aspersion -> total() . " resultados"
    ?>
</div>