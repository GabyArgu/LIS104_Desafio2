<?php include_once 'Headers.php'; ?>

<body>
	<div class="container vh-100">
		<div class="row h-100 align-items-center">
			<div class="col-md-6 d-flex flex-column align-items-center">
				<img src="/Static/Img/Login.svg" alt="" width="500" height="500">
				<a href="/"><button type="button"
						class="btn btn-outline-dark rounded-pill px-4">Regresar</button></a>
			</div>
			<div class="col-md-6">
				<div class="card text-white p-4">
					<div class="card-header bg-transparent">
						<h2 class="card-title fw-bold">Iniciar Sesión</h2>
					</div>
					<div class="card-body">
						<form action="clientes/login" method="POST">
							<div class="mb-3">
								<label for="exampleInputEmail1" class="form-label">Correo Electrónico</label>
								<input type="email" class="form-control" name="correo"
									aria-describedby="emailHelp">
							</div>
							<div class="mb-3">
								<label for="exampleInputPassword1" class="form-label">Contraseña</label>
								<input type="password" class="form-control" name="contrasena">
							</div>
							<div class="row">
								<div class="col d-flex justify-content-between align-items-center">
									<button type="submit" class="btn btn-dark rounded-pill px-4">Ingresar</button>
									<a href="clientes/registro"
										class="link-offset-3 link-underline-light text-white link-underline-opacity-0 link-underline-opacity-100-hover">¿No
										tienes cuenta con nosotros? Regístrate</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>


	<?php include_once 'Toast.php'; ?>
</body>

</html>