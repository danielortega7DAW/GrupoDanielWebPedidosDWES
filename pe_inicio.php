 <!--Código por: Raquel Alcázar--> 

<?php
	session_start();
	include_once("funciones.php");

	if (isset($_SESSION["usuario"])) {

		$id = $_SESSION["usuario"];
		$datos = obtenerNombre($id);

	} else {

		// Si el usuario NO ha iniciado sesión se redirige a "pe_login.php"
		header("location: pe_login.php"); 
		
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Web Compras</title>
	<meta charset="utf-8" />
	<meta name="author" value="Raquel Alcázar" />
</head>
<body>
	<h1>Bienvenido <?php echo $datos["username"]; ?></h1>
	<li><a href="pe_login.php">Cerrar sesión</a></li>
	<li><a href="pe_altaped.php">Alta de pedidos</a></li>
	<li><a href="pe_consped.php">Consultar pedidos</a></li>
	<li><a href="pe_consprodstock.php">Consultar stock de producto</a></li>
	<li><a href="pe_constock.php">Consultar stock de línea</a></li>
	<li><a href="pe_topprod.php">Consultar ventas</a></li>
	<li><a href="pe_conspago.php">Consultar compras</a></li>
</body>
</html>
