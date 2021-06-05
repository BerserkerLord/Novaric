<div class="ps-5 pe-5 pt-3 my-container active-cont">
    <h3 class="display-3">Puestos</h3>
    <div class="d-flex flex-row-reverse">
        <form action="puestos.php" method="GET">
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
            <th scope="col">Puesto</th>
            <th scope="col">Departamento</th>
            <th scope="col">Acción</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($datos as $key => $puesto): ?>
            <tr>
                <td><?=$puesto['puesto']?></td>
                <td><?=$puesto['departamento']?></td>
                <td>
                    <a href="puestos.php?action=ver&id_puesto=<?=$puesto['id_puesto']?>" class="btn btn-primary">
                        <i class="fa fa-arrow-up p-1 icons"></i>
                    </a>
                    <a href="puestos.php?action=eliminar&id_puesto=<?=$puesto['id_puesto']?>" class="btn btn-danger">
                        <i class="fa fa-trash p-1 icons"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <nav>
        <ul class="pagination">
            <?php for($i = 0, $k = 1; $i < $puestos -> total(); $i+=5, $k++): ?>
                <li class="page-item"><a class="page-link" href="puestos.php?<?php echo(isset($_GET['busqueda']))?'busqueda='.$_GET['busqueda'].'&':''; ?>&desde=<?php echo($i); ?>&limite=5"><?php echo ($k); ?></a></li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php
        echo "Filtrando " . count($datos) . " de un total del " . $puestos -> total() . " puestos"
    ?>
</div>