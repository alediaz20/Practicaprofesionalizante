
<?php
header("Access-Control-Allow-Origin: *");
	require_once 'BaseConexion.php';

	$conexion= new mysqli($host, $usu,$pass, $db) or 	die(mysql_error());
	$conexion->set_charset("utf8");

	$id=$_POST['id'];

	$resultado= mysqli_query ($conexion,"DELETE FROM rubro where rubro.id ='$id'")	 or
               die($conexion->error);

	echo json_encode($resultado);

	die();
?>
