<?php
	session_start();
	require '../base_de_datos/conexion.php';

	class articulo extends conexion{
		#atributos
		protected $id;
		protected $path_imagen;
		#metodos
		public function __construct($id)
		{
			$this->id = $id;
		}

		public function verificar_existe_id()
		{
			$this->conectarse();
			$this->id = $this->conexion->real_escape_string($this->id);
			$enlace_objeto = $this->conexion->query("SELECT imagen FROM publicaciones WHERE id = '$this->id'");
			$this->desconectarse();
			$imagen = $enlace_objeto->fetch_assoc();
			if (empty($imagen['imagen'])) {
				setcookie('error', 'El artículo ya no exíste', time() + 1, "/");
				header('Location: ../../index.php');
			}else{
				$this->path_imagen = $imagen['imagen'];
			}
		}

		public function eliminar_imagen()
		{
				unlink('../../'.$path_imagen['imagen']);
		}

		public function eliminar_articulo()
		{
			$this->conectarse();
			$this->conexion->query("DELETE FROM publicaciones WHERE id = '$this->id' ");
			$this->desconectarse();
		}

		public function eliminacion_realizada_exitosamente()
		{
			setcookie('correcto', 'La publicación se eliminó exitosamente', time() + 1, "/");
			header('Location: ../../index.php');
		}

	}

	$id = $_POST['id'];
	$articulo = new articulo($id);
	$articulo->verificar_existe_id();
	$articulo->eliminar_imagen();
	$articulo->eliminar_articulo();
	$articulo->eliminacion_realizada_exitosamente();

?>