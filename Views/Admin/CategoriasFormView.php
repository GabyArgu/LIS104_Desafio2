<?php include_once 'Headers.php'; ?>

<body>
    <?php include_once 'Menu.php'; ?>

    <div class="container mt-4">
        <h1 class="page-header mb-4"><?php echo isset($categoria) ? 'Editar' : 'Agregar'; ?> Categoria</h1>

        <form method="POST" action="categorias/<?php echo isset($categoria) ? 'editar' : 'agregar'; ?>" class="row g-3">
            <input type="hidden" name="id" value="<?php echo isset($categoria) ? $categoria['id'] : ""; ?>">

            <div class="form-group col-md-6">
                <label class="control-label" for="nombre">Nombre:</label>
                <input type="text" class="form-control" name="nombre" value="<?php echo isset($categoria) ? $categoria['nombre'] : ""; ?>">
            </div>

            <div class="modal-footer">
                <a href="categorias" class="btn btn-danger me-2">Cancelar</a>
                <button type="submit" class="btn btn-primary"><?php echo isset($categoria) ? 'Editar' : 'Agregar'; ?></button>
            </div>
        </form>
    </div>


    <?php include_once 'Toast.php'; ?>

</body>

</html>