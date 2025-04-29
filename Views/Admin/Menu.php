<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="ms-3  navbar-brand text-white" href="/">
            <img src="/Static/Img/logo.png" alt="Logo" height="50">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse text-white" id="navbar">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 gap-3">
                <li class="nav-item ">
                    <a class="nav-link text-white" href="ventas">
                        <i class="fas fa-money-bill-transfer"></i> Ventas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="productos">
                        <i class="fas fa-box"></i> Productos
                    </a>
                </li>
                <?php if (isset($_SESSION['usuario_rol']) && $_SESSION['usuario_rol'] == 'administrador'): ?>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="categorias">
                            <i class="fas fa-list"></i> Categorias
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="usuarios">
                            <i class="fas fa-user-gear"></i> Usuarios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="clientes">
                            <i class="fas fa-user-tag"></i> Clientes
                        </a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link text-white" href="usuarios/logout">
                        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>