<?php 
	class conexion{

		protected $host = 'localhost';
		protected $user = 'root';
		protected $password = '';
		protected $database = 'WinPAX';

		public $conexion;

		public function conectarse()
		{
			$this->conexion = new mysqli($this->host, $this->user, $this->password, $this->database);
		}

		public function desconectarse()
		{
			$this->conexion->close();
		}

	}
?>