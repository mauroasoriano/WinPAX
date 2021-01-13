<?php
	session_start();
	require '../base_de_datos/conexion.php';
	
	class articulo extends conexion{
		#atributos
		protected $nombre_imagen;
		protected $tipo_imagen;
		protected $peso_imagen;
		protected $imagen;

		protected $contenido;
		protected $categoria;
		#metodos
		public function __construct($imagen, $contenido, $categoria)
		{
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

		public function crear_articulo()
		{
			$this->conectarse();
			#agarro el usuario del que creó la publicación
			$nombre_objeto = $this->conexion->query("SELECT usuario FROM usuarios WHERE id = '$_SESSION[id]' LIMIT 1");
			while ($registro = $nombre_objeto->fetch_assoc()) {
				$nombre = $registro['usuario'];
			}
			$enlace = str_shuffle('abcdefghijklmnopqrs');
			$this->conexion->query("INSERT INTO publicaciones(enlace, usuario_id, categoria_id, imagen, contenido) 
				VALUES ('articulo.php?usuario=".$nombre."&publicacion=".$enlace."', '$_SESSION[id]', '$this->categoria', 'img/".$this->nombre_imagen."', '$this->contenido')");
			$this->desconectarse();
		}

		public function articulo_exitoso()
		{
			setcookie('correcto', 'Artículo creado con éxito', time() + 1, "/");
			header('Location: ../../index.php');			
		}
	}

	$imagen = $_FILES['imagen'];
	$contenido = $_POST['contenido'];
	$categoria = $_POST['categoria'];
	$articulo = new articulo($imagen, $contenido, $categoria);
	$articulo->verificar_peso_archivo();
	$articulo->verificar_archivo();
	$articulo->verificar_categoria();
	$articulo->verificar_contenido();
	$articulo->guardar_imagen();
	$articulo->crear_articulo();
	$articulo->articulo_exitoso();
?>