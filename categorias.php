<?php 
	session_start();
	require 'core/base_de_datos/conexion.php'; 
	$usuario = new conexion;
	$usuario->conectarse();
	$permisos_objetos = $usuario->conexion->query("SELECT rango FROM usuarios WHERE id = '$_SESSION[id]' LIMIT 1");
	$usuario->desconectarse();
	$permisos = $permisos_objetos->fetch_assoc();
	if ($permisos['rango'] != 'administrador') {
		header('Location: 403.php');
	}
	unset($usuario);
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<?php
		require_once ('layout/head.php') 
	?>
	<title>Categorias</title>
</head>
<body>
	<?php require_once ('layout/header.php') ?>
	<?php 
		$categorias = new conexion;
		$categorias->conectarse();
		$categorias_objetos = $categorias->conexion->query("SELECT id,nombre FROM categorias");
		$categorias->desconectarse();
	?>
	<div class="container" style="margin-top:50px">
	<!-- CREAR CATEGORIA -->
	<button class="btn btn-success m-1" data-toggle="modal" data-target="#crear-categoria-modal"><i class="fas fa-plus"></i> Crear nueva categoría</button>
	<div class="modal fade" id="crear-categoria-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-sm" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Crear categoría</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <form action="core/categorias/crear_categoria.php" method="POST">
		      <div class="modal-body">
		      	<label for="nombre_categoria">Nombre de la categoría</label>
		      	<input type="text" name="nombre" id="nombre_categoria" class="form-control" minlength="4" maxlength="20">
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
		        <button type="submit" class="btn btn-success">Crear</button>
		      </div>
	      </form>
	    </div>
	  </div>
	</div>
	<!-- /ELIMINAR CATEGORIA -->
	<table class="table table-striped">
	  <thead>
	    <tr>
	      <th scope="col"><p class="text-center">categorias</p></th>
	      <th scope="col"><p class="text-center">opciones</p></th>
	    </tr>
	  </thead>
	  <tbody>
	  	<?php
	  	$i = 0;
	  	while($registro = $categorias_objetos->fetch_assoc()): ?>
	    <tr>
	      <td><p class="text-center"><?= $registro['nombre'] ?></p></td>
	      <td>
	      	<div class="text-center">
		      	<!-- EDITAR CATEGORÍA -->
		      	<button class="btn btn-warning" data-toggle="modal" data-target="<?='#editar-cateogria-modal'.$i; ?>"><i class="fas fa-pencil-alt"></i></button>
						<div class="modal fade" id="<?='editar-cateogria-modal'.$i; $i++; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						  <div class="modal-dialog modal-sm" role="document">
						    <div class="modal-content">
						      <div class="modal-header">
						        <h5 class="modal-title" id="exampleModalLabel">Editar categoría</h5>
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						          <span aria-hidden="true">&times;</span>
						        </button>
						      </div>
						      <form action="core/categorias/editar_categoria.php" method="POST">
							      <div class="modal-body">
							      	<input type="hidden" name="id" value="<?= $registro['id'] ?>">
							      	<input type="text" name="nombre" minlength="4" class="form-control" value="<?= $registro['nombre'] ?>">
							      </div>
							      <div class="modal-footer">
							        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
							        <button type="submit" class="btn btn-primary">Guardar cambios</button>
							      </div>
						      </form>
						    </div>
						  </div>
						</div>
						<!-- /EDITAR CATEGORÍA -->
		      	<!-- ELIMINAR CATEGORIA -->
		      	<button class="btn btn-danger" data-toggle="modal" data-target="<?='#eliminar-cateogria-modal'.$i; ?>"><i class="fas fa-trash"></i></button>
						<div class="modal fade" id="<?='eliminar-cateogria-modal'.$i; $i++; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						  <div class="modal-dialog" role="document">
						    <div class="modal-content">
						      <div class="modal-header">
						        <h5 class="modal-title" id="exampleModalLabel">Eliminar categoría</h5>
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						          <span aria-hidden="true">&times;</span>
						        </button>
						      </div>
						      <form action="core/categorias/eliminar_categoria.php" method="POST">
							      <div class="modal-body">
							      	<input type="hidden" name="id" value="<?= $registro['id'] ?>">
							      	<p class="text-center">¿Estás seguro de eliminar a <span class="text-danger"><?= $registro['nombre'] ?></span>?</p>
							      	<p class="text-center text-muted">Cuando elimines ésta categoría, <b>todos los articulos que poseen ésta categoría se eliminaran tambien</b></p>
							      </div>
							      <div class="modal-footer">
							        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
							        <button type="submit" class="btn btn-danger">Eliminar</button>
							      </div>
						      </form>
						    </div>
						  </div>
						</div>
						<!-- /ELIMINAR CATEGORIA -->
	      	</div>
	      </td>
	    </tr>
			<?php endwhile; ?>
	  </tbody>
	</table>
	</div>
	<?php require_once ('layout/footer.php') ?>
</body>
</html>