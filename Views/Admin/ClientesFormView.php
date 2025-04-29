<?php include_once 'Headers.php'; ?>

<body>
    <?php include_once 'Menu.php'; ?>

    <div class="container mt-4">
        <h1 class="page-header mb-4"><?php echo isset($cliente) ? 'Editar' : 'Agregar'; ?> Cliente</h1>

        <form method="POST" action="clientes/<?php echo isset($cliente) ? 'editar' : 'agregar'; ?>" class="row g-3">
            <input type="hidden" name="id" value="<?php echo isset($cliente) ? $cliente['id'] : ""; ?>">

            <div class="form-group col-md-6">
                <label class="control-label" for="nombre">Nombre:</label>
                <input type="text" class="form-control" name="nombre" value="<?php echo isset($cliente) ? $cliente['nombre'] : ""; ?>">
            </div>

            <div class="form-group col-md-6">
                <label class="control-label" for="correo">Correo:</label>
                <input type="email" class="form-control" name="correo" value="<?php echo isset($cliente) ? $cliente['correo'] : ""; ?>">
            </div>

            <div class="form-group col-md-6">
                <label class="control-label" for="contrasena">Contraseña:</label>
                <input type="password" class="form-control" name="contrasena" value="">
            </div>

            <div class="form-group col-md-6">
                <label class="control-label" for="direccion">Dirección:</label>
                <input type="text" class="form-control" name="direccion" value="<?php echo isset($cliente) ? $cliente['direccion'] : ""; ?>">
            </div>

            <div class="form-group col-md-6">
                <label class="control-label" for="telefono">Teléfono:</label>
                <input type="tel" class="form-control" name="telefono" value="<?php echo isset($cliente) ? $cliente['telefono'] : ""; ?>">
            </div>

            <div class="form-group col-md-6">
                <label class="control-label" for="habilitado">Estado:</label>
                <select class="form-control" name="habilitado">
                    <option value="1" <?php echo isset($cliente) && $cliente['habilitado'] == 1 ? 'selected' : ''; ?>>Activo</option>
                    <option value="0" <?php echo isset($cliente) && $cliente['habilitado'] == 0 ? 'selected' : ''; ?>>Inactivo</option>
                </select>
            </div>

            <div class="modal-footer">
                <a href="clientes" class="btn btn-danger me-2">Cancelar</a>
                <button type="submit" class="btn btn-primary"><?php echo isset($cliente) ? 'Editar' : 'Agregar'; ?></button>
            </div>
        </form>
    </div>


    <?php include_once 'Toast.php'; ?>

</body>

</html>