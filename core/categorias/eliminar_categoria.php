<?php
	session_start();
	require '../base_de_datos/conexion.php';

	class categoria extends conexion{
		#atributos
		protected $id;
		#metodos
		public function __construct($id)
		{
			$this->id = $id;
		}

		public function verificar_existe_categoria()
		{
			$this->conectarse();
			$this->id = $this->conexion->real_escape_string($this->id);
			$id_objeto = $this->conexion->query("SELECT id FROM categorias WHERE id = '$this->id'");
			$this->desconectarse();
			$id_objeto = $id_objeto->fetch_assoc();
			if (empty($id_objeto)) {
				setcookie('error', 'La categoría no exíste', time() + 1, "/");
				header('Location: ../../categorias.php');				
			}
		}

		public function eliminar_imagenes_relacionadas_con_categoria()
		{
			$this->conectarse();
			$imagenes_objetos = $this->conexion->query("SELECT imagen FROM publicaciones");
			$this->desconectarse();
			while ($imagen = $imagenes_objetos->fetch_assoc()) {
				unlink('../../'.$imagen['imagen']);
			}
		}

		public function eliminar_categoria()
		{
			$this->conectarse();
			$this->conexion->query("DELETE FROM categorias WHERE id = '$this->id'");
			$this->desconectarse();
		}

		public function categoria_eliminada_exitosamente()
		{
			setcookie('correcto', 'La categoría y todos los articulos relacionado a ellas se eliminaron con éxito', time() + 1, "/");
			header('Location: ../../categorias.php');
		}
	}
	$id = $_POST['id'];
	$categoria = new categoria($id);
	$categoria->verificar_existe_categoria();
	$categoria->eliminar_imagenes_relacionadas_con_categoria();
	$categoria->eliminar_categoria();
	$categoria->categoria_eliminada_exitosamente();
?>