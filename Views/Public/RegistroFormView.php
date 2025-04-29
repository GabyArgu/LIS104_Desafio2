<?php include_once 'Headers.php'; ?>

<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card text-white p-4">
            <div class="card-header bg-transparent">
                <h1 class="card-title fw-bold">Registro de Clientes</h1>
            </div>
            <div class="card-body">
                <form id="formRegistro" action="clientes/registro" method="POST">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="nombre">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" name="correo">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Contraseña</label>
                            <input type="password" class="form-control" name="contrasena">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Repetir Contraseña</label>
                            <input type="password" class="form-control" name="contrasena2">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Dirección</label>
                            <input type="text" class="form-control" name="direccion">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" name="telefono">
                        </div>
                    </div>

                    <div class="d-flex w-100">
                        <a href="clientes/login" class="ms-auto">
                            <button type="button" class="btn btn-outline-dark rounded-pill px-4">Regresar</button>
                        </a>
                        <button type="submit" class="btn btn-dark rounded-pill px-4 ms-3">Registrar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <?php include_once 'Toast.php'; ?>

</body>

</html>