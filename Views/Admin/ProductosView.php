<?php include_once 'Headers.php'; ?>

<body>
    <?php include_once 'Menu.php'; ?>

    <div class="container mt-4">
        <form action="productos" method="POST">
            <div class="row justify-content-between">
                <div class="col-4">
                    <h1>Productos</h1>
                </div>

                <div class="col-4 d-flex align-items-center">
                    <input type="search" class="form-control" placeholder="Buscar producto" name="search" value="<?php echo isset($search) ? $search : ''; ?>">
                    <button class="btn btn-primary" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </div>
        </form>


        <div class="row mt-4">
            <div class="col-12 d-flex">
                <a href="productos/agregar" class="ms-auto"><button class="btn btn-primary"><i class="fa-solid fa-plus"></i> Agregar</button></a>
            </div>
        </div>

        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Tipo</th>
                        <th>Precio</th>
                        <th>Existencias</th>
                        <th>Imagen</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($productos as $producto) {
                    ?>
                        <tr>
                            <td><?php echo $producto['codigo'] ?></td>
                            <td><?php echo $producto['nombre'] ?></td>
                            <td><?php echo $producto['descripcion'] ?></td>
                            <td><?php echo $producto['categoria'] ?></td>
                            <td><?php echo $producto['precio'] ?></td>
                            <td><?php echo $producto['existencias'] ?></td>
                            <td class="text-center"><img src="/Static/Img/Productos/<?php echo $producto['imagen'] ?>" width="100" alt="Producto"></td>
                            <td class="text-center align-middle">
                                <div class="btn-group">
                                    <a href="productos/editar/<?php echo $producto['id'] ?>" class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <a href="productos/eliminar/<?php echo $producto['id'] ?>" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
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