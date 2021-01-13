<?php
	session_start();
	require '../base_de_datos/conexion.php';

	class categoria extends conexion{
		#atributos
		protected $nombre;
		#clases
		public function __construct($nombre)
		{
			$this->nombre = $nombre;
		}

		public function verificar_categoria()
		{
			if (strlen($this->nombre) >= 4 && strlen($this->nombre) <= 20) {
				# categoria valida
			}else{
				setcookie('error', 'Formulario incorrecto, categoria demasiado larga', time() + 1, "/");
				header('Location: ../../categorias.php');
			}
		}

		public function verificar_existe_otra_categoria()
		{
			$this->conectarse();
			$this->nombre = $this->conexion->real_escape_string($this->nombre);
			$id_objecto = $this->conexion->query("SELECT id FROM categorias WHERE nombre = '$this->nombre' LIMIT 1")or die($this->conexion->error);
			$this->desconectarse();
			$id = $id_objecto->fetch_assoc();
			if (empty($id['id'])) {
				//no existe otra categoria
			}else{
				setcookie('error', 'Ya exíste una categoría con se nombre', time() + 1, "/");
				header('Location: ../../categorias.php');
				die();
			}
		}

		public function crear_categoria()
		{
			$this->conectarse();
			$this->nombre = $this->conexion->real_escape_string($this->nombre);
			$this->conexion->query("INSERT INTO categorias(nombre) VALUES ('$this->nombre')");
			$this->desconectarse();
		}

		public function categoria_creada_exitosamente()
		{
			setcookie('correcto', 'La categoría '.$this->nombre.' se creó con éxito', time() + 1, "/");
			header('Location: ../../categorias.php');
		}
	}

	$nombre = $_POST['nombre'];
	$categoria = new categoria($nombre);
	$categoria->verificar_categoria();
	$categoria->verificar_existe_otra_categoria();
	$categoria->crear_categoria();
	$categoria->categoria_creada_exitosamente();
?>