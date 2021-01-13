<?php 
	require 'core/base_de_datos/conexion.php'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<?php 
		session_start();
		require_once ('layout/head.php') 
	?>
	<title>Inicio</title>
</head>
<body>
	<?php require_once ('layout/header.php') ?>
	<div class="row">
		<?php
		$cards = new conexion();
		$cards->conectarse();
		$conexion = $cards->conexion;
		$ids_objetos = $conexion->query('SELECT id,enlace,imagen FROM publicaciones ORDER BY id DESC');
		$cards->desconectarse();
		?>
		<?php while($registro = $ids_objetos->fetch_assoc()): ?>
			<div class="card col-sm-6 col-md-4 col-lg-3" style="width: 18rem;">
				<a href="<?=$registro['enlace'] ?>">
			  	<img class="card-img-top" src="<?=$registro['imagen'] ?>" alt="Card image cap">
				</a>
			</div>
		<?php endwhile; ?>
	</div>
	<?php require_once ('layout/footer.php') ?>
</body>
</html>