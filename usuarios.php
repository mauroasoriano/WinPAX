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
	<title>Usuarios</title>
</head>
<body>
	<?php require_once ('layout/header.php') ?>
	<?php 
		$usuarios = new conexion;
		$usuarios->conectarse();
		$usuarios_objetos = $usuarios->conexion->query("SELECT usuario,rango FROM usuarios");
		$usuarios->desconectarse();
		unset($usuarios);
	?>
	<div class="container" style="margin-top:50px">
	<table class="table table-striped">
	  <thead>
	    <tr>
	      <th scope="col"><p class="text-center">usuario</p></th>w
	      <th scope="col"><p class="text-center">rango</p></th>
	    </tr>
	  </thead>
	  <tbody>
	  	<?php while($registro = $usuarios_objetos->fetch_assoc()): ?>
	    <tr>
	      <td><p class="text-center"><?= $registro['usuario'] ?></p></td>
	      <td><p class="text-center"><?= $registro['rango'] ?></p></td>
	    </tr>
		<?php endwhile; ?>
	  </tbody>
	</table>
	</div>
	<?php require_once ('layout/footer.php') ?>
</body>
</html>