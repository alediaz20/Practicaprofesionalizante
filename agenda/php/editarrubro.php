
<?php
  header("Access-Control-Allow-Origin: *");
	require_once 'BaseConexion.php';

	$conexion= new mysqli($host, $usu,$pass, $db) or 	die(mysql_error());
	$conexion->set_charset("utf8");

	$nombre=$_POST['nombre'];
  $id=$_POST['id'];

	$resultado=mysqli_query($conexion,"UPDATE rubro SET nombre='".$nombre."' WHERE id=".$id) or
               die($conexion->error);


	echo json_encode($res);
	die();
?>
