<?php include_once 'Headers.php'; ?>

<body>
    <?php include_once 'Menu.php'; ?>

    <div class="container mt-4">
        <div class="row mb-3">
            <div class="col-12">
                <?php if (isset($_SESSION['cliente_nombre'])): ?>
                    <h1>Carrito de <strong> <?= $_SESSION['cliente_nombre'] ?> </strong></h1>
                <?php endif; ?>
            </div>
        </div>

        <div class="row">
            <?php if (!empty($carrito)): ?>
                <div class="col-md-8 mb-4">
                    <?php foreach ($carrito as $producto): ?>
                        <div class="card coupon-card flex-row text-white border-0 py-4 px-5 mb-4">
                            <div class="card-body p-0 mb-4">
                                <h4 class="card-title fw-bold"><?= $producto['nombre'] ?></h4>
                                <h5 class="fw-bold mb-1">$<?= $producto['precio'] ?></h5>
                                <p class="mb-1"><?= $producto['descripcion'] ?></p>

                                <form action="ventas/actualizarCantidad" method="POST">
                                    <input type="hidden" name="detalle_id" value="<?= $producto['detalle_id'] ?>">
                                    <input type="hidden" name="producto_id" value="<?= $producto['producto_id'] ?>">
                                    <div class="form-group d-flex align-items-center mt-3 gap-3 col-6">
                                        <label for="cantidad">Cantidad</label>
                                        <input type="number" class="form-control" name="cantidad" value="<?= $producto['cantidad'] ?>">
                                        <button class="btn btn-dark rounded-pill px-4 text-nowrap">Actualizar</button>
                                    </div>
                                </form>
                            </div>
                            <div class="w-100 bg-black bg-opacity-50 d-flex justify-content-between text-white-50 py-1 px-2 rounded rounded-top-0 position-absolute bottom-0 start-0">
                                <p class="m-0">Disponibles <?= $producto['existencias'] ?></p>
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
                                    <h3 class="fw-bold text-end">
                                        $<?= array_reduce($carrito, function ($total, $producto) {
                                                return $total + ($producto['precio'] * $producto['cantidad']);
                                            }, 0); ?>
                                    </h3>
                                </div>

                                <form id="paymentForm" action="ventas/pagarCarrito" method="POST">
                                    <input type="hidden" name="total" value="<?= array_reduce($carrito, function ($total, $producto) {
                                                                                    return $total + ($producto['precio'] * $producto['cantidad']);
                                                                                }, 0); ?>">
                                    <div class="mb-3">
                                        <label for="cardNumber" class="form-label">Número de Tarjeta</label>
                                        <input type="text" class="form-control" id="cardNumber"
                                            placeholder="____ ____ ____ ____" maxlength="19" required
                                            oninput="this.value = formatearNumeroTarjeta(this);">
                                        <label id="cardNumberError" class="error-message"></label>
                                    </div>
                                    <div class="mb-3">
                                        <label for="expiryDate" class="form-label">Fecha de Vencimiento</label>
                                        <input type="text" class="form-control" id="expiryDate" placeholder="__/__"
                                            maxlength="5" required
                                            oninput="this.value = formatearFechaVencimiento(this);">
                                        <label id="expiryDateError" class="error-message"></label>
                                    </div>
                                    <div class="mb-3">
                                        <label for="cvv" class="form-label">CVV</label>
                                        <input type="text" class="form-control" id="cvv" placeholder="___" maxlength="3"
                                            required oninput="this.value = formatearCVV(this);">
                                        <label id="cvvError" class="error-message"></label>
                                    </div>
                                    <div class="card-footer bg-transparent">
                                        <button type="submit" id="submitButton" class="btn btn-dark rounded-pill px-4" disabled>Pagar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-center w-100 font-weight-bold">No tienes productos en el carrito.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>


    <?php include_once 'Toast.php'; ?>

    <script src="/LIS104_Desafio2/Static/Js/tarjeta.js"></script>
</body>

</html>