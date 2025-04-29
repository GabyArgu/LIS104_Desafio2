<?php include_once 'Headers.php'; ?>

<body>
	<div class="container vh-100">
		<div class="row h-100 align-items-center">
			<div class="col-md-6 d-flex flex-column align-items-center">
				<h1 class="fw-bold">ADMIN</h1>
				<img src="/Static/Img/login.svg" alt="" width="500" height="500">
			</div>
			<div class="col-md-6">
				<div class="card text-white p-4">
					<div class="card-header bg-transparent">
						<h2 class="card-title fw-bold">Iniciar Sesión</h2>
					</div>
					<div class="card-body">
						<form action="/admin/usuarios/login" method="POST">
							<div class="mb-3">
								<label for="exampleInputEmail1" class="form-label">Correo Electrónico</label>
								<input type="email" class="form-control" name="username"
									aria-describedby="emailHelp">
							</div>
							<div class="mb-3">
								<label for="exampleInputPassword1" class="form-label">Contraseña</label>
								<input type="password" class="form-control" name="password">
							</div>
							<div class="row">
								<div class="col d-flex justify-content-between align-items-center">
									<button type="submit" class="btn btn-dark rounded-pill px-4">Ingresar</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>


	<!--Mensajes-->
	<?php include_once 'Toast.php'; ?>
</body>

</html>