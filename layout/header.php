<div id="app">
	<nav class="navbar navbar-expand-md navbar-light bg-light">
		<a class="navbar-brand" href="index.php">WinPAX</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav mr-auto">
			</ul>
			<ul class="navbar-nav">

				<?php if (!isset($_SESSION['id'])): ?>

				<!-- INICIAR SESIÓN -->
				<li class="nav-item">
				<button type="button" class="btn btn-secondary nav-item" data-toggle="modal" data-target="#iniciar-sesion-modal">
				  Iniciar sesión
				</button>
				<!-- Modal -->
					<div class="modal fade" id="iniciar-sesion-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalLabel">Iniciar sesión</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
				      	<form action="core/header/iniciar_sesion.php" method="POST">
						      <div class="modal-body">
						      	<div class="row">
						      		<div class="col-md-6 col-sm-12">
									      <label for="usuario_label">Usuario</label>
									      <input v-model="usuario" type="text" name="usuario" :class="revisar_usuario" id="usuario_label" required>
								      </div>
						      		<div class="col-md-6 col-sm-12">
									      <label for="clave_label">Contraseña</label>
									      <input v-model="clave" type="password" name="clave" :class="revisar_clave" id="clave_label" required>
								      </div>
								    </div>
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
						        <button type="submit" class="btn btn-success">Iniciar sesión</button>
						      </div>
						    </form>
					    </div>
					  </div>
					</div>
				<script src="js/header/iniciar_sesion.js"></script>
				<!-- /INICIAR SESIÓN -->
				</li>
				<!-- REGISTRARSE -->
				<li class="nav-item" style="margin-left:10px">
				<button type="button" class="btn btn-secondary nav-item" data-toggle="modal" data-target="#registrarse-modal">
				  Registrarse
				</button>
					<!-- Modal -->
					<div class="modal fade" id="registrarse-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalLabel">Registrarse</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
				      	<form action="core/header/registrarse.php" method="POST">
						      <div class="modal-body">
						      	<div class="row">
						      		<div class="col-sm-12" style="margin-bottom:10px">
									      <label for="registrarme_usuario_label">Usuario</label>
									      <input v-model="usuario" type="text" name="usuario" :class="revisar_usuario" id="registrarme_usuario_label" required>
								      </div>
						      		<div class="col-sm-6">
									      <label for="registrarme_clave_label">Contraseña</label>
									      <input v-model="clave" type="password" name="clave" :class="revisar_clave" id="registrarme_clave_label" required>
								      </div>
						      		<div class="col-sm-6">
									      <label for="registrarme_repetir_clave">Repetir contraseña</label>
									      <input v-model="repetir_clave" type="password" :class="revisar_clave" id="registrarme_repetir_clave" required>
								      </div>
								    </div>
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
						        <button type="submit" class="btn btn-success">Registrarme</button>
						      </div>
						    </form>
					    </div>
					  </div>
					</div>
				<script src="js/header/registrarse.js"></script>
				<!-- /REGISTRARSE -->
				</li>
				<?php else: ?>

				<?php 
				$usuario = new conexion;
				$usuario->conectarse();
				$permisos_objetos = $usuario->conexion->query("SELECT rango FROM usuarios WHERE id = '$_SESSION[id]' LIMIT 1");
				$usuario->desconectarse();
				$permisos = $permisos_objetos->fetch_assoc();
				?>
				<?php if($permisos['rango'] == 'administrador'): ?>
					<li class="nav-item">
						<a href="usuarios.php" class="btn btn-secondary nav-item" style="margin-right:10px">
						  Ver usuarios
						</a>
					</li>
					<li class="nav-item">
						<a href="categorias.php" class="btn btn-secondary nav-item" style="margin-right:10px">
						  Ver categorías
						</a>
					</li>
				<?php endif ?>
				<li class="nav-item">
					<button type="button" class="btn btn-secondary nav-item" data-toggle="modal" data-target="#crear-articulo-modal">
					  Crear nuevo artículo
					</button>
				</li>
				<div class="modal fade" id="crear-articulo-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog modal-lg">
				    <div class="modal-content">
				      <div class="modal-header">
				        <h5 class="modal-title" id="exampleModalLabel">Crear nuevo artículo</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>
				      <form action="core/header/crear_articulo.php" method="POST" enctype="multipart/form-data">
					      <div class="modal-body">
					      	<div class="row">
					      		<div class="col-sm-4 offset-sm-4">
					      			<img style="width:100%;margin-bottom:15px" :src="imagen" alt="subir imagen">
					      		</div>
					      		<div class="col-sm-12">
											<div class="input-group mb-3">
											  <div class="input-group-prepend">
											    <span class="input-group-text">Subir imágen</span>
											  </div>
											  <div class="custom-file">
											    <input @change="cambiar_imagen($event)" type="file" name="imagen" required class="custom-file-input" id="imagen_file">
											    <label class="custom-file-label" for="imagen_file">Seleccione una imágen</label>
											  </div>
								      </div>
									    <p class="col-sm-12 text-danger text-center">{{error_imagen}}</p>
											<?php
												$objeto = new conexion;
												$objeto->conectarse();
												$conexion = $objeto->conexion;
												$registro_objecto = $conexion->query('SELECT * FROM categorias');
												$objeto->desconectarse();
											?>
											<select name="categoria" class="form-control col-sm-12" style="margin-bottom: 10px">
												<?php while ($registro = $registro_objecto->fetch_assoc()): ?>
													<option value="<?= $registro['id']; ?>"><?= $registro['nombre']; ?></option>
												<?php endwhile; ?>
											</select>
										</div>
									  <div class="form-group col-sm-12">
									    <label for="contenido_label">Contenido</label>
									    <textarea class="form-control" name="contenido" minlength="4" required id="contenido_label" rows="4"></textarea>
									  </div>
						      </div>
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
					        <button type="submit" class="btn btn-success">Crear</button>
					      </div>
				      </form>
				    </div>
				  </div>
				</div>
				<script src="js/header/crear_articulo.js"></script>
				<!-- /CREAR ARTICULO -->
				<li class="nav-item">
					<a href="core/header/cerrar_sesion.php" class="btn btn-danger nav-item" style="margin-left:10px">
					  cerrar sesión
					</a>
				</li>

				<?php endif; ?>

			</ul>
		</div>
	</nav>
</div>
<?php
	if (isset($_COOKIE['error'])) {
		echo '
			<div class="alert alert-danger" role="alert">
			  '.$_COOKIE['error'].'
			</div>
		';
	}else	if (isset($_COOKIE['correcto'])) {
		echo '
			<div class="alert alert-success" role="alert">
			  '.$_COOKIE['correcto'].'
			</div>
		';
	}
?>