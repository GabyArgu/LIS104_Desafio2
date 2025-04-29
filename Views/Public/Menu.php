<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="ms-3  navbar-brand text-white" href="/">
            <img src="/Static/Img/logo.png" alt="" height="50">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse text-white" id="navbar">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 gap-3">
                <?php if (isset($_SESSION['cliente_id'])): ?>
                    <li class="nav-item ">
                        <a class="nav-link text-white" href="ventas/carrito">
                            <i class="fas fa-shopping-cart"></i> Mi Carrito
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="ventas/historial">
                            <i class="fas fa-list"></i> Mis Compras
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="clientes/logout">
                            <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="clientes/login">
                            <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>