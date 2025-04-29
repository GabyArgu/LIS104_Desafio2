<?php include_once 'Headers.php'; ?>

<body>
    <?php include_once 'Menu.php'; ?>

    <div class="container mt-4">
        <h1 class="page-header mb-4"><?php echo isset($usuario) ? 'Editar' : 'Agregar'; ?> Usuario</h1>

        <form method="POST" action="usuarios/<?php echo isset($usuario) ? 'editar' : 'agregar'; ?>" class="row g-3">
            <input type="hidden" name="id" value="<?php echo isset($usuario) ? $usuario['id'] : ""; ?>">

            <div class="form-group col-md-6">
                <label class="control-label" for="nombre">Nombre:</label>
                <input type="text" class="form-control" name="nombre" value="<?php echo isset($usuario) ? $usuario['nombre'] : ""; ?>">
            </div>

            <div class="form-group col-md-6">
                <label class="control-label" for="correo">Correo:</label>
                <input type="email" class="form-control" name="correo" value="<?php echo isset($usuario) ? $usuario['correo'] : ""; ?>">
            </div>

            <div class="form-group col-md-6">
                <label class="control-label" for="contrasena">Contraseña:</label>
                <input type="password" class="form-control" name="contrasena" value="">
            </div>

            <div class="form-group col-md-6">
                <label class="control-label" for="rol">Rol:</label>
                <select class="form-control" name="rol">
                    <option value="administrador" <?php echo isset($usuario) && $usuario['rol'] == 'administrador' ? 'selected' : ''; ?>>Administrador</option>
                    <option value="empleado" <?php echo isset($usuario) && $usuario['rol'] == 'empleado' ? 'selected' : ''; ?>>Empleado</option>
                </select>
            </div>

            <div class="form-group col-md-6">
                <label class="control-label" for="estado">Estado:</label>
                <select class="form-control" name="estado">
                    <option value="1" <?php echo isset($usuario) && $usuario['estado'] == 1 ? 'selected' : ''; ?>>Activo</option>
                    <option value="0" <?php echo isset($usuario) && $usuario['estado'] == 0 ? 'selected' : ''; ?>>Inactivo</option>
                </select>
            </div>

            <div class="modal-footer">
                <a href="usuarios" class="btn btn-danger me-2">Cancelar</a>
                <button type="submit" class="btn btn-primary"><?php echo isset($usuario) ? 'Editar' : 'Agregar'; ?></button>
            </div>
        </form>
    </div>


    <?php include_once 'Toast.php'; ?>

</body>

</html>