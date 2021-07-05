<div class="ps-5 pe-5 pt-3 my-container active-cont">
    <h3 class="display-3">Extremidades</h3>
    <div class="d-flex flex-row-reverse">
        <form action="extremidades.php" method="GET">
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
            <th scope="col">Extremidades</th>
            <th scope="col">Acción</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($datos as $key => $extremidad): ?>
            <tr>
                <td><?=$extremidad['extremidad']?></td>
                <td>
                    <a href="extremidades.php?action=ver&id_extremidad=<?=$extremidad['id_extremidad']?>" class="btn btn-outline-primary">
                        <i class="fa fa-arrow-up p-1 icons"></i>
                    </a>
                    <a href="extremidades.php?action=eliminar&id_extremidad=<?=$extremidad['id_extremidad']?>" class="btn btn-outline-danger">
                        <i class="fa fa-trash p-1 icons"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <nav>
        <ul class="pagination">
            <?php for($i = 0, $k = 1; $i < $extremidades -> total(); $i+=3, $k++): ?>
                <li class="page-item"><a class="page-link" href="extremidades.php?<?php echo(isset($_GET['busqueda']))?'busqueda='.$_GET['busqueda'].'&':''; ?>&desde=<?php echo($i); ?>&limite=3"><?php echo ($k); ?></a></li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php
    echo "Filtrando " . count($datos) . " de un total del " . $extremidades -> total() . " extremidades"
    ?>
</div>