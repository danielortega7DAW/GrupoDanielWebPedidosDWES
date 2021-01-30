<!--Alex Santana-->
<?php
	//Se incluye la conexion con la bbdd
	include("conexion.php");
	//Se incluye las funciones
	include("funciones.php");
	
	//Se inicia la sesión para el usuario y para el carrito
	session_start();
	if(!isset($_SESSION["usuario"])){
		header("location:../1.-login/pe_login.php");
	}
	
	
		
?>
<HTML>
<HEAD> 
<title>Comprar productos</title>
<style>
	table {border-collapse: collapse;}
	th, td {border: 1px solid #dddddd;
			width:40%;
			text-align:center;}
		.error{
	color:red;
	}
	.tit{
		position:relative;
		right: 165px;
	}
	
	.mover{
		//float:right;
		position:relative;
		bottom:39px;
		margin-left:202px;
	}
</style>
   
</HEAD>

<BODY>

	<h1>Realizar Pedidos</h1>
	<!--<?php echo "<h2>Usuario: ".$_SESSION["usuario"]."</h2>";?>-->
	
	<form action="<?php echo $_SERVER['PHP_SELF']; ?> " method="post">
		
			Art&iacute;culos  <select name="producto">
					<option>--Selecciona un producto--</option>
					<?php
						//Se lista los nombres de los productos  en un select
						$listaP=listaProductos();
						foreach($listaP as $prod){
                            echo "<option value='".$prod['productName']."'>".$prod['productName']."</option>";
                        }
						
					?>
					</select>&nbsp;&nbsp&nbsp
					<label>Cantidad</label>
					<input type="number" name="cantidad" placeholder="Cantidad" value="1"><br><br>
					<input type="submit" name="agregar" value="Agregar al carrito">
					<input type="submit" name="ver" value="Ver carrito">
					<br><br>
					
					
	
	
	<div>
	<?php
		if (isset($_POST["agregar"])){
			$producto=$_POST["producto"];
			$cantidad=$_POST["cantidad"];
			//Se comprueba el stock de productos
			$listita=stockProductos($producto);
			if($cantidad < $listita){
				//Se crea una sesión de carrito con el producto y cantidad en un array asociativo
				$_SESSION["carrito"][$producto]=$cantidad;
				echo "Producto agregado al carrito<br><br>";
				//echo "<script>alert('Producto $producto agregado al carrito');</script>";
			} else{
				echo "<p class='error'>Producto no seleccionado o no hay suficiente stock del producto!</p>";
			}
		}
		
		//si se hace click en el input ver y si la sesion carrito no esta vacía (se muestra la tablaProductos y el precio total de estos)
		if(isset($_POST["ver"])){
			if(!empty($_SESSION["carrito"])){
				echo '<input class="mover" type="submit" name="vaciar" value="Vaciar carrito">';
				tablaProductos();
				echo "<br>";
				precioTotal();
				echo "<label>Tarjeta de cr&eacute;dito</label> <input type='text' name='card' value=''>&nbsp;&nbsp;";
				echo '<input class="otra" type="submit" name="compra" value="Finalizar compra">';
			} else{
				echo "No hay productos en el carrito<br><br>";
			}
		}
			
			
		//Se vacía el carrito poniendo la sesion a null
		if(isset($_POST["vaciar"])){
			$_SESSION["carrito"]=null;
		}
		
		//Al hacer click en en input compra, se procede a ejecutar las funciones
		if(isset($_POST["compra"])){
			$cardNumber=$_POST["card"];
			comprar($cardNumber);
		}
	
	?>
	
	
	</div>
	</form>
	<a href="pe_login.php"><input type="button" value="Cerrar Sesi&oacute;n"></a>	
</BODY>

</HTML>

