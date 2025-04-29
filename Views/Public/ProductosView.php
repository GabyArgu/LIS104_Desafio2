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
                    <button class="btn btn-primary" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </div>
        </form>

        <div class="row mt-4">
            <?php if (!empty($productos)): ?>
                <?php foreach ($productos as $producto) : ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="card h-100 shadow-sm">
                            <!-- Imagen del producto -->
                            <img src="/Static/Img/Productos/<?php echo $producto['imagen'] ?>" alt="Imagen del producto">
                            <div class="card-body text-center">
                                <h5 class="card-title"> <?php echo $producto['nombre'] ?> </h5>
                                <?php if ($producto['existencias'] > 0) { ?>
                                    <p class="card-text text-white fw-bold">$<?php echo $producto['precio'] ?></p>
                                    <p class="card-text">Existencias: <?php echo $producto['existencias'] ?></p>
                                    <a href="productos/detalle/<?php echo $producto['id'] ?>" class="btn btn-dark">Ver Detalle</a>
                                <?php } else { ?>
                                    <p class="btn btn-danger">Producto no disponible</p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center w-100 font-weight-bold">No se encontraron cupones disponibles.</p>
            <?php endif; ?>
        </div>
    </div>


    <?php include_once 'Toast.php'; ?>
</body>

</html>