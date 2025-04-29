<?php include_once 'Headers.php'; ?>

<body>
    <?php include_once 'Menu.php'; ?>

    <div class="container mt-4">
        <div class="row mb-3">
            <div class="col-12">
                <?php if (isset($_SESSION['cliente_nombre'])): ?>
                    <h3>Detalle de compra del  <strong> <?= $detalle[0]['fecha'] ?> </strong></h3>
                <?php endif; ?>
            </div>
        </div>

        <div class="row">
            <?php if (!empty($detalle)): ?>
                <div class="col-md-8 mb-4">
                    <?php foreach ($detalle as $producto): ?>
                        <div class="card coupon-card flex-row text-white border-0 py-4 px-5 mb-4">
                            <div class="card-body p-0">
                                <h4 class="card-title fw-bold"><?= $producto['nombre'] ?></h4>
                                <h5 class="fw-bold mb-1">$<?= $producto['precio_unitario'] ?></h5>
                                <p class="mb-1"><?= $producto['descripcion'] ?></p>
                                <h5 class="fw-bold mb-1">Cantidad: <?= $producto['cantidad'] ?></h5>
                            </div>
                            <div class="d-flex align-items-center">
                                <img src="/LIS104_Desafio2/Static/Img/Productos/<?php echo $producto['imagen'] ?>" alt="Coupon Image" class="rounded" style="width: 100px; object-fit: cover;">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>


                <div class="col-md-4">
                    <div class="card carrito-card text-white p-4">
                        <div class="card-header bg-transparent">
                            <h2 class="card-title">Resumen de Compra</h2>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h3 class="fw-bold">Total:</h3>
                                </div>
                                <div class="col">
                                    <h3 class="fw-bold text-end">$<?= $detalle[0]['total'] ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="ventas/historial" class="btn btn-dark rounded-pill w-50 mt-3">Regresar</a>
                </div>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-center w-100 font-weight-bold">No hay detalles de esta compra.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>


    <?php include_once 'Toast.php'; ?>

    <script src="/LIS104_Desafio2/Static/Js/tarjeta.js"></script>
</body>

</html>