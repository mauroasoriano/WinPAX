<?php
	session_start();
	require ('../base_de_datos/conexion.php');

	class categoria extends conexion{
		#atributos
		protected $id;
		protected $nombre;
		#metodos
		public function __construct($id, $nombre)
		{
			$this->id = $id;
			$this->nombre = $nombre;
		}

		public function verificar_categoria()
		{
			if (strlen($this->nombre) >= 4 && strlen($this->nombre) <= 20) {
				echo strlen($this->nombre);
			}else{
				setcookie('error', 'Formulario incorrecto, categoria demasiado larga', time() + 1, "/");
				header('Location: ../../categorias.php');
			}
		}

		public function verificar_existe_categoria()
		{
			$this->conectarse();
			$this->id = $this->conexion->real_escape_string($this->id);
			$this->nombre = $this->conexion->real_escape_string($this->nombre);
			$id_objeto = $this->conexion->query("SELECT id FROM categorias WHERE id = '$this->id' LIMIT 1");
			$this->desconectarse();
			
			$id_objeto = $id_objeto->fetch_assoc();
			if (empty($id_objeto['id'])) {
				setcookie('error', 'La categoría no exíste', time() + 1, "/");
				header('Location: ../../categorias.php');
			}
		}

		public function modificar_categoria()
		{
			$this->conectarse();
			$this->conexion->query("UPDATE categorias SET nombre = '$this->nombre' WHERE id = '$this->id' LIMIT 1");
			$this->desconectarse();
		}

		public function modificacion_exitosa()
		{
			setcookie('correcto', 'La cateogría se modifico con éxito', time() + 1, "/");
			header('Location: ../../categorias.php');
		}
	}
	$id = $_POST['id'];
	$nombre = $_POST['nombre'];
	$categoria = new categoria($id, $nombre);
	$categoria->verificar_existe_categoria();
	$categoria->verificar_categoria();
	$categoria->modificar_categoria();
	$categoria->modificacion_exitosa();
?>