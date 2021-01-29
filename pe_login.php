 <!--Código por: Raquel Alcázar--> 

<?php
	session_start();
	include_once("funciones.php");

	if(isset($_SESSION["usuario"])){
		session_unset();
		session_destroy();
	}
	
	if (isset($_POST) && !empty($_POST)) {

		$username = $_POST["username"];
		$passcode = $_POST["passcode"];

		$consulta = comprobarAdmin($username, $passcode);

		if($consulta != null){
			$_SESSION["usuario"] = $consulta["id"];
			header("location: pe_inicio.php"); 
		}	

	}
			
?>

<!DOCTYPE html>
<html>
<head>
	<title>Ejercicio 11</title>
	<meta charset="utf-8" />
	<meta name="author" value="Raquel Alcázar" />
</head>
<body>
	<h1>Iniciar Sesión</h1>
	<form method="post" action="<?php echo htmlentities($_SERVER["PHP_SELF"]);?>">
		<label for="username">Username:</label>
		<input type="text" name="username" required/><br><br>
		
		<label for="passcode">Passcode:</label>
		<input type="password" name="passcode" required/><br><br>

		<input type="submit" value="Iniciar sesión"/>
	</form>
</body>
</html>

<?php
	if (isset($_POST) && !empty($_POST) && $consulta==null){
		echo "<p>Datos incorrectos.<p>";
	}
?>
