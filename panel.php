<?php 
	require 'conexion.php';
	session_start();

	if(!isset($_SESSION['email'])){
		header("Location: login.php");
	} 
	
	$mensaje = "";
	$dominios = "";

	$email=$_SESSION['email'];

	$usuarios = "SELECT `idUsuario` FROM `usuarios` WHERE `email` = '$email'";
		
	$query = mysqli_query($conexion, $usuarios);

	if (mysqli_num_rows($query) > 0) {
		$idUser = mysqli_fetch_array($query,MYSQLI_NUM);
	}
	else{
		$idUser = ['MadMat'];
	}

	if(isset($_POST['crear'])){
		$web = $_POST['web'];
		$dominio = "$idUser[0]$web";
		$fecha = shell_exec("date +'%Y-%m-%d'");

		$webs = "SELECT `dominio` FROM `webs` WHERE `dominio` = '$dominio'";

		$query = mysqli_query($conexion, $webs);

		if (mysqli_num_rows($query) > 0) {
			$mensaje = "El dominio ya existe.";
		}
		else if (empty($dominio) || $dominio == PHP_EOL) {
			$mensaje = "Completar todos los campos.";
		}
		else {
			$insertar = "INSERT INTO `webs`(`idUsuario`, `dominio`, `fechaCreacion`) VALUES ('$idUser[0]','$dominio','$fecha')";
				
			$query = mysqli_query($conexion, $insertar);
			
			if ($query){
				shell_exec(".././wix.sh $dominio $dominio");
				shell_exec("chmod 757 $dominio");
			} 
			else{
				$mensaje = "Algo salió mal.";
			}
		}
	}

	if ($email == "admin@server.com") {
		$webs = "SELECT `dominio` FROM `webs`";

		$query = mysqli_query($conexion, $webs);

		if (mysqli_num_rows($query) > 0) {
			while ($fila = mysqli_fetch_array($query,MYSQLI_NUM)) {
				$dominios .= "<a href='$fila[0]'>$fila[0]</a>";
				$dominios .= "<a href='descargar.php?web=$fila[0]'>descargar web</a>";
				$dominios .= "<a href='eliminar.php?web=$fila[0]'>eliminar web</a><br>";
			}
		}
	}
	else {
		$webs = "SELECT `dominio` FROM `webs` WHERE `idUsuario` = '$idUser[0]'";

		$query = mysqli_query($conexion, $webs);

		if (mysqli_num_rows($query) > 0) {
			while ($fila = mysqli_fetch_array($query,MYSQLI_NUM)) {
				$dominios .= "<a href='$fila[0]'>$fila[0]</a>";
				$dominios .= "<a href='descargar.php?web=$fila[0]'>descargar web</a>";
				$dominios .= "<a href='eliminar.php?web=$fila[0]'>eliminar web</a><br>";
			}
		}
	}
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>webgenerator - Panel - Fernando Sierra</title>
</head>
<body>
	<style>
		body *{
			margin:5px;
		}
	</style>
	<h1>Bienvenido a tu panel</h1>
	<a href="logout.php">Cerrar sesión de <?php echo $idUser[0]; ?></a><br>
	<?php echo $mensaje; ?>
	<form action="" method="post">
		<label for="web">Generar Web de:</label>
		<input type="text" name="web" id="web" required><br>
		<input type="submit" name="crear" value="Crear web">
	</form>
	<?php echo $dominios; ?>
</body>
</html>