<?php include_once 'Headers.php'; ?>

<body>
    <?php include_once 'Menu.php'; ?>

    <div class="container mt-4">
        <form action="ventas" method="POST">
            <div class="row justify-content-between">
                <div class="col-4">
                    <h1>Ventas</h1>
                </div>

                <div class="col-4 d-flex align-items-center">
                    <input type="search" class="form-control" placeholder="Buscar venta" name="search" value="<?php echo isset($search) ? $search : ''; ?>">
                    <button class="btn btn-primary borderN" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </div>
        </form>

        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nombre Cliente</th>
                        <th>Correo Cliente</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($ventas as $venta) {
                    ?>
                        <tr>
                            <td><?php echo $venta['nombre'] ?></td>
                            <td><?php echo $venta['correo'] ?></td>
                            <td><?php echo $venta['fecha'] ?></td>
                            <td><?php echo $venta['total'] ?></td>
                            <td><?php echo $venta['estado'] ? 'Comprado' : 'En carrito' ?></td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="ventas/detalle/<?php echo $venta['venta_id'] ?>" class="btn btn-primary"><i class="fa-solid fa-list"></i></a>
                                    <?php if ($venta['estado']): ?>
                                        <a href="ventas/comprobante/<?php echo $venta['venta_id'] ?>" class="btn btn-secondary"><i class="fa-solid fa-receipt"></i></a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>


    <?php include_once 'Toast.php'; ?>
</body>

</html>