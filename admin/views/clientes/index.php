<div class="ps-5 pe-5 pt-3 my-container active-cont">
    <h3 class="display-3">Clientes</h3>
    <div class="col-md-4">
        <a href="clientes.php?action=crear" class="btn btn-outline-success mb-3"><i class="fa fa-plus p-1 icons"></i>
            Agregar
        </a>
    </div>
    <div class="d-flex flex-row-reverse">
        <form action="clientes.php" method="GET">
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
            <th scope="col">Nombre</th>
            <th scope="col">Apellido Paterno</th>
            <th scope="col">Apellido Materno</th>
            <th scope="col">Dirección</th>
            <th scope="col">Correo</th>
            <th scope="col">Telefono</th>
            <th scope="col">Acción</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($datos as $key => $cliente): ?>
            <tr>
                <td><?=$cliente['rfc']?></td>
                <td><?=$cliente['nombre']?></td>
                <td><?=$cliente['apaterno']?></td>
                <td><?=$cliente['amaterno']?></td>
                <td><?=$cliente['domicilio']?></td>
                <td><?=$cliente['email']?></td>
                <td><?=$cliente['telefono']?></td>
                <td>
                    <a href="clientes.php?action=ver&rfc=<?=$cliente['rfc']?>" class="btn btn-outline-primary">
                        <i class="fa fa-arrow-up p-1 icons"></i>
                    </a>
                    <a href="clientes.php?action=eliminar&rfc=<?=$cliente['rfc']?>" class="btn btn-outline-danger">
                        <i class="fa fa-trash p-1 icons"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <nav>
        <ul class="pagination">
            <?php for($i = 0, $k = 1; $i < $clientes -> total(); $i+=5, $k++): ?>
                <li class="page-item"><a class="page-link" href="clientes.php?<?php echo(isset($_GET['busqueda']))?'busqueda='.$_GET['busqueda'].'&':''; ?>&desde=<?php echo($i); ?>&limite=5"><?php echo ($k); ?></a></li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php
        echo "Filtrando " . count($datos) . " de un total del " . $clientes -> total() . " clientes"
    ?>
</div>