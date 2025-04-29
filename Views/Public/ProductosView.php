<?php include_once 'Headers.php'; ?>

<body>
    <?php include_once 'Menu.php'; ?>

    <div class="container mt-4">
        <div class="row mb-3">
            <div class="col-12">
                <?php if (isset($_SESSION['cliente_nombre'])): ?>
                    <h1>Hola, <strong> <?= $_SESSION['cliente_nombre'] ?> </strong></h1>
                <?php endif; ?>
            </div>
        </div>

        <form action="" method="POST">
            <div class="row justify-content-end">
                <div class="col-4 d-flex align-items-center">
                    <input type="search" class="form-control" placeholder="Buscar producto" name="search" value="<?php echo isset($_POST['search']) ? $_POST['search'] : ''; ?>">
                    <button class="btn btn-primary borderN" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </div>
        </form>

        <div class="row mt-4">
            <?php if (!empty($productos)): ?>
                <?php foreach ($productos as $producto) : ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="card h-100 shadow-sm border-0">
                            <!-- Imagen del producto con efecto hover -->
                            <div class="overflow-hidden bg-light" style="height: 180px;">
                                <img src="/LIS104_Desafio2/Static/Img/Productos/<?php echo $producto['imagen'] ?>"
                                    class="card-img-top img-fluid h-100 object-fit-cover"
                                    alt="<?php echo $producto['nombre'] ?>"
                                    style="transition: transform .3s;">
                            </div>

                            <div class="card-body text-center d-flex flex-column">
                                <h5 class="card-title fw-bold mb-2"><?php echo $producto['nombre'] ?></h5>

                                <?php if ($producto['existencias'] > 0) { ?>
                                    <div class="mt-auto">
                                        <p class="h4 text-azul fw-bold mb-2">$<?php echo number_format($producto['precio'], 2) ?></p>
                                        <p class="text-black small mb-3">Disponibles: <?php echo $producto['existencias'] ?></p>
                                        <a href="productos/detalle/<?php echo $producto['id'] ?>"
                                            class="btn btn-outline-dark stretched-link">
                                            Ver Detalle
                                        </a>
                                    </div>
                                <?php } else { ?>
                                    <div class="mt-auto">
                                        <span class="badge bg-danger py-2 px-3 mb-3">AGOTADO</span>
                                        <p class="text-black small">Próximamente disponible</p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info text-center py-4">
                        <i class="bi bi-info-circle-fill fs-4"></i>
                        <h4 class="mt-2">No se encontraron productos disponibles</h4>
                        <p class="mb-0">Pronto tendremos nuevos productos en stock</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>


    <?php include_once 'Toast.php'; ?>
</body>

</html>