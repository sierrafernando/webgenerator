<?php 
	session_start();
	if (!isset($_SESSION['email'])){
		header("Location: login.php");
	}

	if (isset($_GET['web'])){
		$web = $_GET['web'];
		
		if (!file_exists("$web.zip")){
			shell_exec("zip -r $web.zip $web");
			header("Location: $web.zip");
		} else{
			header("Location: $web.zip");
		}
	}
	else{
		header("Location: panel.php");
	}
?>