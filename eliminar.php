<?php 
	
	session_start();
	if (!isset($_SESSION['email'])){
		header("Location: login.php");
	}

	require 'conexion.php';

	if (isset($_GET['web'])){
		$web = $_GET['web'];

		shell_exec("rm -r $web");
		shell_exec("rm -r $web.zip");

		$webs = "DELETE FROM `webs` WHERE `webs`.`dominio` = '$web'";

		$query = mysqli_query($conexion, $webs);

		if ($query){
			header("Location: panel.php");
		} 
		else{
			$mensaje = "Algo salió mal.";
		}
	}
	else{
		header("Location: panel.php");
	}

?>