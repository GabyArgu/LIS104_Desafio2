<?php include_once 'Headers.php'; ?>

<body>
    <?php include_once 'Menu.php'; ?>

    <div class="container-fluid py-3 px-4">
        <?php
        $vendedor_posicion = rand(0, 1) == 0 ? 'left' : 'right';
        $vendedor_imagen = rand(0, 1) == 0 ? 'vendedora.png' : 'vendedor.png';
        ?>
        <h1 class="text-center my-3">Detalle de <?php echo $producto['nombre'] ?></h1>

        <div class="row align-items-center">
            <?php if ($vendedor_posicion == 'left') { ?>
                <div class="col-md-2 text-center">
                    <img src="/LIS104_Desafio2/Static/Img/<?php echo $vendedor_imagen; ?>" alt="Vendedor" class="vendedor-img">
                </div>
            <?php } ?>

            <div class="col-md-5 text-center detalle-imagen">
                <img src="/LIS104_Desafio2/Static/Img/Productos/<?php echo $producto['imagen'] ?>" alt="Imagen del producto">
            </div>
            <div class="col-md-4 detalle-texto">
                <h5>Descripción:</h5>
                <p><?php echo $producto['descripcion'] ?></p>
                <h5>Categoria:</h5>
                <p><?php echo $producto['categoria'] ?></p>
                <h5>Precio:</h5>
                <p><strong><?php echo $producto['precio'] ?></strong></p>
                <h5>Existencias:</h5>
                <p><?php echo $producto['existencias'] ?></p>

                <div class="btn-container mt-3">
                    <?php if (isset($_SESSION['cliente_id'])) : ?>
                        <form action="ventas/agregarProducto" method="POST" class="mb-3">
                            <input type="hidden" name="producto_id" value="<?= $producto['id'] ?>">
                            <input type="hidden" name="precio_unitario" value="<?= $producto['precio'] ?>">
                            <div class="form-group mb-4">
                                <label for="cantidad">Cantidad:</label>
                                <input type="number" class="form-control" name="cantidad" min="1" max="<?= $producto['existencias'] ?>" value="1">
                            </div>
                            <a href="productos" class="btn btn-success rounded-pill"><i class="fa-solid fa-bag-shopping"></i> Regresar</a>
                            <button class="btn btn-primary rounded-pill px-4">Añadir al <i class="fa-solid fa-cart-shopping"></i></button>
                        </form>
                    <?php else : ?>
                        <a href="productos" class="btn btn-success rounded-pill"><i class="fa-solid fa-bag-shopping"></i> Regresar</a>
                    <?php endif; ?>
                </div>
            </div>

            <?php if ($vendedor_posicion == 'right') { ?>
                <div class="col-md-2 text-center">
                    <img src="/LIS104_Desafio2/Static/Img/<?php echo $vendedor_imagen; ?>" alt="Vendedor" class="vendedor-img">
                </div>
            <?php } ?>
        </div>
    </div>

    <?php include_once 'Toast.php'; ?>
</body>

</html>