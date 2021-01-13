<?php
	session_start();
	require '../base_de_datos/conexion.php';

	class articulo extends conexion{
		#atributos
		protected $id;
		protected $nombre_imagen;
		protected $tipo_imagen;
		protected $peso_imagen;
		protected $imagen;
		protected $enlace;

		protected $contenido;
		protected $categoria;
		#metodos
		public function anterior_imagen($id, $contenido, $categoria)
		{
			$this->id = $id;
			$this->contenido = $contenido;
			$this->categoria = $categoria;
		}

		public function modificar_cambios()
		{
			$this->conectarse();
			$this->contenido = $this->conexion->real_escape_string($this->contenido);
			$this->categoria = $this->conexion->real_escape_string($this->categoria);
			$this->id = $this->conexion->real_escape_string($this->id);
			$this->conexion->query("UPDATE publicaciones SET contenido = '$this->contenido', categoria_id = '$this->categoria' WHERE id = '$this->id' LIMIT 1");
			$this->desconectarse();
		}

		public function tomar_url_actual()
		{
			$this->conectarse();
			$enlace_objeto = $this->conexion->query("SELECT enlace FROM publicaciones WHERE id = '$this->id' LIMIT 1");
			$this->desconectarse();
			$enlace = $enlace_objeto->fetch_assoc();
			$this->enlace = $enlace['enlace'];
		}

		public function nueva_imagen($id, $imagen, $contenido, $categoria)
		{
			$this->id = $id;
			$this->nombre_imagen = $imagen['name'];
			$this->tipo_imagen = $imagen['type'];
			$this->peso_imagen = $imagen['size'];
			$this->imagen = $imagen['tmp_name'];

			$this->contenido = $contenido;
			$this->categoria = $categoria;
		}

		public function verificar_peso_archivo()
		{
			if ($this->peso_imagen < 10000000) {
				//paso
			}else{
				setcookie('error', 'EL archivo tiene que pesar menos que 10MB', time() + 1, "/");
				header('Location: ../../index.php');				
			}
		}

		public function verificar_archivo()
		{
			$array = ['image/png', 'image/jpg', 'image/gif', 'image/jpeg'];
			if (in_array($this->tipo_imagen, $array)) {
				//el archivo es una imágen
			}else{
				setcookie('error', 'El archivo NO es una imágen', time() + 1, "/");
				header('Location: ../../index.php');
			}
		}

		public function guardar_imagen()
		{
			$extension_imagen = pathinfo($this->nombre_imagen, PATHINFO_EXTENSION);
			$this->nombre_imagen = date("YmdHismm").'.'.$extension_imagen;
			move_uploaded_file($this->imagen, __DIR__.'/../../img/'.$this->nombre_imagen);
		}

		public function verificar_categoria()
		{
			$this->conectarse();
			$id_categoria_objeto = $this->conexion->query("SELECT id FROM categorias WHERE id = '$this->categoria' LIMIT 1");
			$this->desconectarse();
			while ($registro = $id_categoria_objeto->fetch_assoc()) {
				$verificar_existe_id = $registro['id'];
			}
			if (empty($verificar_existe_id)) {
				setcookie('error', 'La categoría seleccionada no exíste', time() + 1, "/");
				header('Location: ../../index.php');
			}
		}

		public function verificar_contenido()
		{
			if (strlen($this->contenido) < 4) {
				setcookie('error', 'El contenido es obligatorio', time() + 1, "/");
				header('Location: ../../index.php');
			}
		}

		public function eliminar_anterior_imagen()
		{
			$this->conectarse();
			$this->id = $this->conexion->real_escape_string($this->id);
			$path_imagen_objeto = $this->conexion->query("SELECT enlace,imagen FROM publicaciones WHERE id = '$this->id' LIMIT 1");
			$path_imagen = $path_imagen_objeto->fetch_assoc();
			$this->desconectarse();
			if (empty($path_imagen['imagen'])) {
				setcookie('error', 'El artículo a modificar no exíste', time() + 1, "/");
				header('Location: ../../articulo.php');
			}else{
				$this->enlace = $path_imagen['enlace'];
				unlink('../../'.$path_imagen['imagen']);
			}
		}

		public function modificar_articulo_con_nueva_imagen()
		{
			$this->conectarse();
			$enlace = str_shuffle('abcdefghijklmnopqrs');
			$this->contenido = $this->conexion->real_escape_string($this->contenido);
			$this->categoria = $this->conexion->real_escape_string($this->categoria);
			$this->conexion->query("UPDATE publicaciones SET imagen = 'img/$this->nombre_imagen', contenido = '$this->contenido', categoria_id = '$this->categoria' LIMIT 1");
			$this->desconectarse();
		}

		public function modificacion_realizada_exitosamente()
		{
			setcookie('correcto', 'La publicación se modifico exitosamente', time() + 1, "/");
			header('Location: ../../'.$this->enlace);
		}

		public function cambiar_articulo_con_nueva_imagen()
		{

		}
	}
	$id = $_POST['id'];
	$imagen = $_FILES['imagen'];
	$imagen_default = $_POST['imagen_default'];
	$categoria = $_POST['categoria'];
	$contenido = $_POST['contenido'];

	if ($imagen_default === 'false') {
		$articulo = new articulo();
		$articulo->nueva_imagen($id, $imagen, $contenido, $categoria);
		$articulo->verificar_peso_archivo();
		$articulo->verificar_archivo();
		$articulo->verificar_categoria();
		$articulo->verificar_contenido();
		$articulo->eliminar_anterior_imagen();
		$articulo->guardar_imagen();
		$articulo->modificar_articulo_con_nueva_imagen();
		$articulo->modificacion_realizada_exitosamente();
	}else{
		$articulo = new articulo();
		$articulo->anterior_imagen($id, $contenido, $categoria);
		$articulo->modificar_cambios();
		$articulo->tomar_url_actual();
		$articulo->modificacion_realizada_exitosamente();	
	}
?>