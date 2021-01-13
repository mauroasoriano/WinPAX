<?php 
	
	require 'core/base_de_datos/conexion.php';
	class select extends conexion
	{
		function __construct()
		{
			$this->conectarse();
			$select = $this->conexion->query('SELECT * FROM categorias');
			$this->desconectarse();
			echo var_dump($select_objecto);
			return $select;
		}
	}
	$select_objecto = new select();
?>
<select name="categoria" class="form-control col-sm-12" style="margin-bottom: 10px">
	<?php while($registro = $select_objecto->fetch_assoc()): ?>
	<option value="<?php echo $registro['id'] ?>"><?php echo $registro['nombre'] ?></option>
	<?php endwhile; ?>
</select>