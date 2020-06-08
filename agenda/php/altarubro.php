<?php
  header("Access-Control-Allow-Origin: *");
  require_once 'BaseConexion.php';

	$conexion= new mysqli($host, $usu,$pass, $db) or 	die(mysql_error());
	$conexion->set_charset("utf8");

	$nombre=$_POST['nombre'];
	$resultado=mysqli_query($conexion,"INSERT INTO `rubro` (`id`, `nombre`) VALUES (NULL, '".$nombre."');") or
			   die($conexion->error);

$res['rubro']=$resultado->fetch_all(MYSQLI_ASSOC);
	if ($resultado>0) {
		$res['rubro']=$resultado->fetch_all(MYSQLI_ASSOC);
	}
	echo json_encode($res);
	die();

?>
