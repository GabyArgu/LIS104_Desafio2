<?php include_once 'Headers.php'; ?>

<body>
    <?php include_once 'Menu.php'; ?>

    <div class="container mt-4">
        <h1 class="page-header mb-4"><?php echo isset($producto) ? 'Editar' : 'Agregar'; ?> Producto</h1>

        <form method="POST" action="productos/<?php echo isset($producto) ? 'editar' : 'agregar'; ?>" class="row g-3" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo isset($producto) ? $producto['id'] : ""; ?>">

            <div class="form-group col-md-6">
                <label class="control-label" for="codigo">Código:</label>
                <?php if (isset($producto)): ?>
                    <input type="text" class="form-control" name="codigo" value="<?= $producto['codigo'] ?>" readonly>
                <?php else: ?>
                    <input type="text" class="form-control" name="codigo" value="<?= $codigo_auto ?>" readonly>
                <?php endif; ?>
            </div>
            <div class="form-group col-md-6">
                <label class="control-label" for="nombre">Nombre:</label>
                <input type="text" class="form-control" name="nombre" value="<?php echo isset($producto) ? $producto['nombre'] : ""; ?>">
            </div>
            <div class="form-group col-md-6">
                <label class="control-label" for="descripcion">Descripción:</label>
                <input type="text" class="form-control" name="descripcion" value="<?php echo isset($producto) ? $producto['descripcion'] : ""; ?>">
            </div>
            <div class="form-group col-md-6">
                <label class="control-label" for="categoria_id">Categoria:</label>
                <select name="categoria_id" class="form-control">
                    <option value="">Seleccione</option>
                    <?php if (!empty($categorias)): ?>
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?= $categoria['id'] ?>" <?= (isset($producto) && $producto['categoria_id'] == $categoria['id']) ? 'selected' : '' ?>>
                                <?= $categoria['nombre'] ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label class="control-label" for="precio">Precio:</label>
                <input type="number" step="0.01" class="form-control" name="precio" value="<?php echo isset($producto) ? $producto['precio'] : ""; ?>">
            </div>
            <div class="form-group col-md-6">
                <label class="control-label" for="existencias">Existencias:</label>
                <input type="number" class="form-control" name="existencias" value="<?php echo isset($producto) ? $producto['existencias'] : ""; ?>">
            </div>

            <div class="form-group col-md-6">
                <label class="control-label" for="imagen">Imagen:</label>
                <input type="file" class="form-control" name="imagen">
            </div>

            <div class="modal-footer">
                <a href="productos" class="btn btn-danger me-2">Cancelar</a>
                <button type="submit" name="submit" class="btn btn-primary"><?php echo isset($producto) ? 'Editar' : 'Agregar'; ?></button>
            </div>
        </form>
    </div>


    <?php include_once 'Toast.php'; ?>
</body>

</html>