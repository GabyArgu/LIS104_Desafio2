<?php include_once 'Headers.php'; ?>

<body>
    <?php include_once 'Menu.php'; ?>

    <div class="container mt-4">
        <form action="clientes" method="POST">
            <div class="row justify-content-between">
                <div class="col-4">
                    <h1>Clientes</h1>
                </div>

                <div class="col-4 d-flex align-items-center">
                    <input type="search" class="form-control" placeholder="Buscar usuario" name="search" value="<?php echo isset($search) ? $search : ''; ?>">
                    <button class="btn btn-primary" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </div>
        </form>

        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        <th>Habilitado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($clientes as $cliente) {
                    ?>
                        <tr>
                            <td><?php echo $cliente['nombre'] ?></td>
                            <td><?php echo $cliente['correo'] ?></td>
                            <td><?php echo $cliente['direccion'] ?></td>
                            <td><?php echo $cliente['telefono'] ?></td>
                            <td><?php echo $cliente['habilitado'] ? 'Activo' : 'Inactivo' ?></td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="clientes/editar/<?php echo $cliente['id'] ?>" class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <a href="clientes/inhabilitar/<?php echo $cliente['id'] ?>" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
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