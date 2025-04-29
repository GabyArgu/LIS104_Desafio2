<?php include_once 'Headers.php'; ?>

<body>
    <?php include_once 'Menu.php'; ?>

    <div class="container mt-4">
        <form action="categorias" method="POST">
            <div class="row justify-content-between">
                <div class="col-4">
                    <h1>Categorias</h1>
                </div>

                <div class="col-4 d-flex align-items-center">
                    <input type="search" class="form-control" placeholder="Buscar categoria" name="search" value="<?php echo isset($search) ? $search : ''; ?>">
                    <button class="btn btn-primary borderN" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </div>
        </form>


        <div class="row">
            <div class="col-12 d-flex">
                <a href="categorias/agregar" class="ms-auto mt-4"><button class="btn btn-primary"><i class="fa-solid fa-plus"></i> Agregar</button></a>
            </div>
        </div>

        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($categorias as $categoria) {
                    ?>
                        <tr>
                            <td><?php echo $categoria['id'] ?></td>
                            <td><?php echo $categoria['nombre'] ?></td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="categorias/editar/<?php echo $categoria['id'] ?>" class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <a href="categorias/eliminar/<?php echo $categoria['id'] ?>" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
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