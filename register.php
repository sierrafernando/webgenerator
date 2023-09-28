<?php 
	session_start();
	if (isset($_SESSION['email'])){
		header("Location: panel.php");
	}

	require 'conexion.php';
	$mensaje = "";
	
	if(isset($_POST['registrarse'])){
		$email = trim($_POST['email']);
		$contra = $_POST['password'];
		$contra2 = $_POST['password2'];
		$fecha = shell_exec("date +'%Y-%m-%d'");

		if (empty($email) || $email == PHP_EOL || empty($contra) || $contra == PHP_EOL || empty($contra2) || $contra2 == PHP_EOL){
			$mensaje = "Completar todos los campos.";
		}
		else if ($contra != $contra2){
			$mensaje = "Las contraseñas no coinciden.";
		}
		else{
			$usuarios = "SELECT `email` FROM `usuarios` WHERE `email` = '$email'";
			
			$query = mysqli_query($conexion, $usuarios);

			if (mysqli_num_rows($query) > 0) {
				$mensaje = "El email ingresado ya existe.";
			}
			else {
				$insertar = "INSERT INTO `usuarios` (`email`, `password`, `fechaRegistro`) VALUES ('$email', '$contra', '$fecha')";
				
				$query = mysqli_query($conexion, $insertar);
				
				if ($query){
					$_SESSION['email'] = $email;
					header("Location: panel.php");
				} 
				else{
					$mensaje = "Algo salió mal.";
				}
			}	
		}
	}
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>webgenerator - Register - Fernando Sierra</title>
</head>
<body>
	<style>
		body *{
			margin:5px;
		}
	</style>
	<h1>Registrarte es simple.</h1>
	<?php echo $mensaje ?>
	<form action="" method="post">
		<label for="email">Email:</label>
		<input type="email" name="email" id="email" required><br>
		<label for="password">Contraseña:</label>
		<input type="password" name="password" id="password" required><br>
		<label for="password2">Repetir contraseña:</label>
		<input type="password" name="password2" id="password2" required><br>
		<input type="submit" value="registrarse" name="registrarse">
	</form>
</body>
</html>