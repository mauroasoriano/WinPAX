<?php
	session_start();
	require '../base_de_datos/conexion.php';


	class iniciar_sesion extends conexion{
		#atributos
		protected $usuario;
		protected $clave;
		protected $clave_encriptada;
		protected $usuario_id;
		#clases
		public function __construct($usuario, $clave)
		{
			$this->usuario = $usuario;
			$this->clave = $clave;
		}

		public function tomar_clave_encriptada()
		{
			$this->conectarse();
			$registro_objecto = $this->conexion->query("SELECT id,clave FROM usuarios WHERE usuario = '$this->usuario' LIMIT 1");
			$this->desconectarse();

			while ($registro = $registro_objecto->fetch_assoc()) {
			    $this->clave_encriptada = $registro['clave'];
			    $this->usuario_id = $registro['id'];
			}
		}

		public function verificar_coincidencia_claves()
		{
			if (password_verify($this->clave, $this->clave_encriptada)) {
				//ambas claves coinciden
			}else{
				setcookie('error', 'contraseña incorrecta', time() + 1, "/");
				header('Location: ../../index.php');
			}
		}

		public function iniciar_sesion_exitoso()
		{
			$_SESSION['id'] = $this->usuario_id;
			setcookie('correcto', 'Bienvenido '.$this->usuario, time() + 1, "/");
			header('Location: ../../index.php');
		}

	}

	$usuario = $_POST['usuario'];
	$clave = $_POST['clave'];

	$usuario = new iniciar_sesion($usuario, $clave);
	$usuario->tomar_clave_encriptada();
	$usuario->verificar_coincidencia_claves(); #necesito usar la función PASSWORD_VERIFY para ver la coincidencia
	$usuario->iniciar_sesion_exitoso();
?>