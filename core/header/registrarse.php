<?php
	require '../base_de_datos/conexion.php';
	session_start();

	class registrarse extends conexion{

		protected $usuario;
		protected $clave;
		protected $usuario_id;

		public function __construct($usuario, $clave)
		{
			$this->usuario = $usuario;
			$this->clave = $clave;
		}

		public function verificar_formulario()
		{
			if (strlen($this->usuario) >= 4 && strlen($this->usuario) <= 20) {
				//pass
			}else{
				setcookie('error', 'Formulario incorrecto, usuario demasiado largo o corto', time() + 1, "/");
				header('Location: ../../index.php');
			}

			if (strlen($this->clave) >= 4 && strlen($this->clave) <= 20) {
				//pass
			}else{
				setcookie('error', 'Formulario incorrecto, contraseña demasiada larga o corta', time() + 1, "/");
				header('Location: ../../index.php');
			}
		}

		public function encriptar_clave()
		{
			$this->clave = password_hash($this->clave, PASSWORD_BCRYPT, ['cost' => 11]);
		}

		public function registrarse_ahora()
		{
			$this->conectarse();
			$this->conexion->query("INSERT INTO usuarios(usuario, clave) VALUES ('$this->usuario', '$this->clave')");
			$registro_objecto = $this->conexion->query("SELECT id FROM usuarios WHERE usuario = '$this->usuario'");
			$this->desconectarse();

			while ($registro = $registro_objecto->fetch_assoc()) {
			    $this->usuario_id = $registro['id'];
			}
		}

		public function registro_exitoso()
		{
			$_SESSION['id'] = $this->usuario_id;
			setcookie('correcto', 'Bienvenido '.$this->usuario, time() + 1, "/");
			header('Location: ../../index.php');
		}
	}

	$usuario = $_POST['usuario'];
	$clave = $_POST['clave'];

	$usuario = new registrarse($usuario, $clave);
	$usuario->verificar_formulario();
	$usuario->encriptar_clave();
	$usuario->registrarse_ahora();
	$usuario->registro_exitoso();
?>