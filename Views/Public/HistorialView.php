<?php include_once 'Headers.php'; ?>

<body>
    <?php include_once 'Menu.php'; ?>

    <div class="container mt-4">
        <div class="row mb-3">
            <div class="col-12">
                <?php if (isset($_SESSION['cliente_nombre'])): ?>
                    <h2>Historial </strong></h2>
                    <p>Aquí puedes ver tu historial de compras <strong> <?= $_SESSION['cliente_nombre'] ?> </strong></p>
                <?php endif; ?>
            </div>
        </div>

        <?php if (!empty($historial)): ?>
            <div class="table-responsive mt-4">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($historial as $compra) {
                        ?>
                            <tr>
                                <td><?php echo $compra['fecha'] ?></td>
                                <td><?php echo $compra['total'] ?></td>
                                <td><?php echo $compra['estado'] ? 'Comprado' : 'En carrito' ?></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="ventas/detalle/<?php echo $compra['id'] ?>" class="btn btn-primary"><i class="fa-solid fa-list"></i></a>
                                        <a href="ventas/comprobante/<?php echo $compra['id'] ?>" class="btn btn-secondary"><i class="fa-solid fa-receipt"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="row">
                <div class="col-12">
                    <p class="text-center w-100 font-weight-bold">No tienes compras en el historial.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>


    <?php include_once 'Toast.php'; ?>
</body>

</html>