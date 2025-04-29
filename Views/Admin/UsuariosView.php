<?php include_once 'Headers.php'; ?>

<body>
    <?php include_once 'Menu.php'; ?>

    <div class="container mt-4">
        <form action="usuarios" method="POST">
            <div class="row justify-content-between">
                <div class="col-4">
                    <h1>Usuarios</h1>
                </div>

                <div class="col-4 d-flex align-items-center">
                    <input type="search" class="form-control" placeholder="Buscar usuario" name="search" value="<?php echo isset($search) ? $search : ''; ?>">
                    <button class="btn btn-primary borderN" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </div>
        </form>


        <div class="row">
            <div class="col-12 d-flex">
                <a href="usuarios/agregar" class="ms-auto mt-4"><button class="btn btn-primary"><i class="fa-solid fa-plus"></i> Agregar</button></a>
            </div>
        </div>

        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($usuarios as $usuario) {
                    ?>
                        <tr>
                            <td><?php echo $usuario['nombre'] ?></td>
                            <td><?php echo $usuario['correo'] ?></td>
                            <td><?php echo $usuario['rol'] ?></td>
                            <td><?php echo $usuario['estado'] ? 'Activo' : 'Inactivo' ?></td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="usuarios/editar/<?php echo $usuario['id'] ?>" class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <?php if ($usuario['id'] != $_SESSION['usuario_id']): ?>
                                        <a href="usuarios/eliminar/<?php echo $usuario['id'] ?>" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
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