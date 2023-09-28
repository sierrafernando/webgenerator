<?php 
	session_start();
	if (isset($_SESSION['email'])){
		header("Location: panel.php");
	}

	require 'conexion.php';
	$mensaje= "" ;
	
	if(isset($_POST['ingresar'])){
		$email = trim($_POST['email']);
		$contra = $_POST['password'];

		if (empty($email) || $email == PHP_EOL || empty($contra) || $contra == PHP_EOL){
			$mensaje = "Completar todos los campos.";
		}
		else{
			$usuarios = "SELECT `email`,`password` FROM `usuarios` WHERE `email` = '$email' AND `password` = '$contra'";
			
			$query = mysqli_query($conexion, $usuarios);
			
			$existe=False;

			if (mysqli_num_rows($query) > 0) {
				$_SESSION['email'] = $email;
				header("Location: panel.php");
			}
			else{
				$mensaje = "El email o la contraseña son incorrectos.";
			}
		}
	}
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>webgenerator - Login - Fernando Sierra</title>
</head>
<body>
	<style>
		body *{
			margin:5px;
		}
	</style>
	<h1>webgenerator Fernando Sierra</h1>
	<?php echo $mensaje ?>
	<form action="" method="post">
		<label for="email">Email:</label> 
		<input type="text" name="email" id="email" required><br>
		<label for="password">Contraseña:</label> 
		<input type="password" name="password" id="password" required><br>
		<a href="register.php">Crear cuenta</a><br>
		<input type="submit" name="ingresar" value="ingresar">
	</form>
</body>
</html>