<div class="ps-5 pe-5 pt-3 my-container active-cont">
    <h3 class="display-3">Empleados</h3>
    <div class="d-flex flex-row-reverse">
        <form action="empleados.php" method="GET">
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
            <th scope="col">RFC</th>
            <th scope="col">Fotografía</th>
            <th scope="col">Nombre</th>
            <th scope="col">Apellido Paterno</th>
            <th scope="col">Apellido Materno</th>
            <th scope="col">Dirección</th>
            <th scope="col">Correo</th>
            <th scope="col">Puesto</th>
            <th scope="col">Acción</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($datos as $key => $empleado): ?>
            <tr>
                <td><?=$empleado['rfc']?></td>
                <td>
                    <img src="<?php echo (isset($empleado['fotografia']))? '../archivos/'.$empleado['fotografia']: '../archivos/default.jpg'; ?>" alt="foto empleado" class="rounded img-fluid" width="75">
                </td>
                <td><?=$empleado['nombre']?></td>
                <td><?=$empleado['apaterno']?></td>
                <td><?=$empleado['amaterno']?></td>
                <td><?=$empleado['direccion']?></td>
                <td><?=$empleado['correo']?></td>
                <td><?=$empleado['puesto']?></td>
                <td>
                    <a href="empleados.php?action=ver&rfc=<?=$empleado['rfc']?>" class="btn btn-outline-primary mb-1">
                        <i class="fa fa-arrow-up p-1 icons"></i>
                    </a>
                    <a href="empleados.php?action=eliminar&rfc=<?=$empleado['rfc']?>" class="btn btn-outline-danger">
                        <i class="fa fa-trash p-1 icons"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <nav>
        <ul class="pagination">
            <?php for($i = 0, $k = 1; $i < $empleados -> total(); $i+=5, $k++): ?>
                <li class="page-item"><a class="page-link" href="empleados.php?<?php echo(isset($_GET['busqueda']))?'busqueda='.$_GET['busqueda'].'&':''; ?>&desde=<?php echo($i); ?>&limite=5"><?php echo ($k); ?></a></li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php
        echo "Filtrando " . count($datos) . " de un total del " . $empleados -> total() . " empleados"
    ?>
</div>