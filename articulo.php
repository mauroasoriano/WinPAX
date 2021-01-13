<?php
	session_start();
	require 'core/base_de_datos/conexion.php'; 
	$usuario = $_GET['usuario'];
	$publicacion = $_GET['publicacion'];
	$enlace = "articulo.php?usuario=".$usuario."&publicacion=".$publicacion;
	$conexion = new conexion;
	$conexion->conectarse();
	$usuario = $conexion->conexion->real_escape_string($usuario);
	$publicacion = $conexion->conexion->real_escape_string($publicacion);
	$publicacion_objeto = $conexion->conexion->query(
		"SELECT p.id, p.usuario_id, p.categoria_id, u.usuario, u.rango, c.nombre, p.imagen, p.contenido, p.fecha_creado FROM publicaciones p JOIN usuarios u ON p.usuario_id = u.id JOIN categorias c ON p.categoria_id = c.id WHERE enlace = '$enlace' AND u.usuario = '$usuario' LIMIT 1");
	$conexion->desconectarse();

	$registro = $publicacion_objeto->fetch_assoc();

	if (empty($registro)) {
		header('Location: 404.php');
	}else{
		$datos_publicacion['id'] = $registro['id'];
		$datos_publicacion['usuario_id'] = $registro['usuario_id'];
		$datos_publicacion['usuario'] = $registro['usuario'];
		$datos_publicacion['rango'] = $registro['rango'];
		$datos_publicacion['categoria'] = $registro['nombre'];
		$datos_publicacion['categoria_id'] = $registro['categoria_id'];
		$datos_publicacion['imagen'] = $registro['imagen'];
		$datos_publicacion['contenido'] = $registro['contenido'];
		$datos_publicacion['fecha_creado'] = $registro['fecha_creado'];
	}
	unset($usuario);
	if (isset($_SESSION['id'])) {
		$conexion->conectarse();
		$rango_objeto = $conexion->conexion->query("SELECT rango FROM usuarios WHERE id = '$_SESSION[id]'");
		$conexion->desconectarse();
		$rango_usuario_logeado = $rango_objeto->fetch_assoc();
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<?php 
		require_once ('layout/head.php') 
	?>
	<title>Publicación</title>
</head>
<body>
	<?php require_once ('layout/header.php') ?>
	<div class="container" style="margin-top:10px">
		<div class="row bg-secondary rounded">
			<?php if(!empty($rango_usuario_logeado['rango'])):?>
				<?php if($rango_usuario_logeado['rango'] == 'administrador' || $_SESSION['id'] == $datos_publicacion['usuario_id']): ?>
				<div class="col-sm-12">
					<!-- MODIFICAR ARTICULO -->
					<button class="btn btn-warning" data-toggle="modal" data-target="#modificar-articulo-modal"><i class="fas fa-pencil-alt"></i></button>
					<input type="hidden" value="<?= $datos_publicacion['imagen'] ?>" id="imagen_id_vue">
					<input type="hidden" value="<?= $datos_publicacion['categoria'] ?>" id="categoria_id_vue">
					<input type="hidden" value="<?= $datos_publicacion['contenido'] ?>" id="contenido_id_vue">
					<div class="modal fade" id="modificar-articulo-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog modal-lg" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalLabel">Modificar artículo</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <form action="core/articulo/editar_articulo.php" method="POST" enctype="multipart/form-data">
					      	<input type="hidden" name="id" value="<?= $datos_publicacion['id']; ?>">
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
												    <input @change="cambiar_imagen($event)" type="file" name="imagen" class="custom-file-input" id="imagen_file">
												    <input type="hidden" id="imagen_default_valor" name="imagen_default" value="true">
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
													<option value="<?= $datos_publicacion['categoria_id'] ?>" selected><?= $datos_publicacion['categoria'] ?></option>
													<?php while ($registro = $registro_objecto->fetch_assoc()): ?>
														<option value="<?= $registro['id']; ?>"><?= $registro['nombre']; ?></option>
													<?php endwhile; ?>
												</select>
											</div>
										  <div class="form-group col-sm-12">
										    <label for="contenido_label">Contenido</label>
										    <textarea class="form-control" v-model="contenido" name="contenido" minlength="4" required id="contenido_label" rows="4"></textarea>
										  </div>
							      </div>
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
						        <button type="submit" class="btn btn-primary">Guardar cambios</button>
						      </div>
					      </form>
					    </div>
					  </div>
					</div>
					<script src="js/articulo/modificar_articulo.js"></script>
					<!-- /MODIFICAR ARTICULO -->
					<!-- ELIMINAR ARTICULO -->
					<button class="btn btn-danger" data-toggle="modal" data-target="#eliminar-articulo-modal"><i class="fas fa-trash"></i></button>
					<div class="modal fade" id="eliminar-articulo-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog" role="document">
					  	<form action="core/articulo/eliminar_articulo.php" method="POST">
					  		<input type="hidden" value="<?= $datos_publicacion['id'] ?>" name="id">
						    <div class="modal-content">
						      <div class="modal-header">
						        <h5 class="modal-title" id="exampleModalLabel">Eliminar articulo</h5>
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						          <span aria-hidden="true">&times;</span>
						        </button>
						      </div>
						      <div class="modal-body">
						      	<p class="text-center">¿Estás seguro que deseas eliminar este <span class="text-danger">artículo</span>?</p>
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
						        <button type="submit" class="btn btn-primary">Eliminar</button>
						      </div>
					      </form>
					    </div>
					  </div>
					</div>
					<!-- /ELIMINAR ARTICULO -->
				</div>
				<?php endif; ?>
			<?php endif; ?>
			<div class="col-sm-12">
				<div class="row">
					<img class="col-sm-4 offset-sm-4 rounded" src="<?= $datos_publicacion['imagen'] ?>" alt="la publicacion de la imagen">
				</div>
			</div>
			<div class="col-sm-12" style="margin-top:40px">
				<div class="row">
					<div class="col-sm-4">
						<p class="text-left text-white">creador de la publicación <span class="text-success"><?= $datos_publicacion['usuario'] ?></span></p>
					</div>
					<div class="col-sm-4">
						<p class="text-center text-white">categoría <span class="text-success"><?= $datos_publicacion['categoria'] ?></span></p>
					</div>
					<div class="col-sm-4">
						<p class="text-right text-white">fecha de creación <span class="text-success"><?= $datos_publicacion['fecha_creado'] ?></span></p>
					</div>
				</div>
			</div>
			<hr class="col-sm-11 bg-white">
			<div class="col-sm-12">
				<p class="text-white m-5">
					<?= $datos_publicacion['contenido'] ?>
				</p>
			</div>
		</div>
	</div>
	<?php require_once ('layout/footer.php') ?>
</body>
</html>