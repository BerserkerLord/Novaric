<div class="ps-5 pe-5 pt-3 my-container active-cont">
    <h3 class="display-3">Clientes de servicios</h3>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <a href="clientes_Servicio.php?action=crear" class="btn btn-outline-success mb-3"><i class="fa fa-plus p-1 icons"></i>
                    Agregar
                </a>
            </div>
            <div class="col-md-4 offset-md-4">
                <form action="clientes_Servicio.php" method="GET">
                    <input class="input-group-text pe-1" style="display:inline-block;" type="text" name="busqueda">
                    <button class="btn btn-outline-secondary" type="submit">
                        Buscar
                        <i class="fa fa-search p-1 icons"></i>
                    </button>
                </form>
            </div>
        </div>
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
        <?php foreach($datos as $key => $cliente_servicio): ?>
            <tr>
                <td><?=$cliente_servicio['rfc']?></td>
                <td><?=$cliente_servicio['nombre']?></td>
                <td><?=$cliente_servicio['apaterno']?></td>
                <td><?=$cliente_servicio['amaterno']?></td>
                <td><?=$cliente_servicio['domicilio']?></td>
                <td><?=$cliente_servicio['email']?></td>
                <td><?=$cliente_servicio['telefono']?></td>
                <td>
                    <a href="clientes_servicio.php?action=ver&rfc=<?=$cliente_servicio['rfc']?>" class="btn btn-outline-primary">
                        <i class="fa fa-arrow-up p-1 icons"></i>
                    </a>
                    <a href="clientes_servicio.php?action=eliminar&rfc=<?=$cliente_servicio['rfc']?>" class="btn btn-outline-danger">
                        <i class="fa fa-trash p-1 icons"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <nav>
        <ul class="pagination">
            <?php for($i = 0, $k = 1; $i < $clientes_servicio -> total(); $i+=5, $k++): ?>
                <li class="page-item"><a class="page-link" href="clientes_servicio.php?<?php echo(isset($_GET['busqueda']))?'busqueda='.$_GET['busqueda'].'&':''; ?>&desde=<?php echo($i); ?>&limite=5"><?php echo ($k); ?></a></li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php
        echo "Filtrando " . count($datos) . " de un total del " . $clientes_servicio -> total() . " clientes"
    ?>
</div>