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
	<h2 class="text-center">No tenés los permisos para acceder a éste sitio</h2>
	<h1 class="text-center">error 403</h1>
	<?php require_once ('layout/footer.php') ?>
</body>
</html>