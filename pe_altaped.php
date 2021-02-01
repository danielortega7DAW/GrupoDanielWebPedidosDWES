 <!--Código por: Rodrigo Cano--> 
<html>
<head>
<title>Alta Pedido</title>
</head>
<body>


<?php
session_start();

include_once "funciones.php"; 


if(isset($_SESSION["usuario"])){//Comprueba que has iniciado sesion en caso contrario no te deja ver las opciones de la pagina
	echo "<h1>Pedidos</h1>";
	$errorCheck=false;//Boolean si hay algun error con el CheckNumber que nos proporcionan
	if (!isset($_SESSION['cesta'])) {//Crea la sesion cesta en caso de no existir
		$cesta= [];
		$_SESSION['cesta'] = $cesta;//Se guarda un array
	}
	if ($_SERVER["REQUEST_METHOD"] == "POST") {//Se añade un producto a la cesta
		if (isset($_POST['cesta'])) {
			$productName = limpiar_campo($_POST["productName"]);
			$cantidad = limpiar_campo($_POST["cantidad"]);
			$cesta=$_SESSION['cesta'];
			if ($cantidad>0){//Añade o borra un producto de la cesta
				$busqueda="SELECT * FROM products WHERE productName='$productName'";
				$CantidadStock=Codigos('quantityInStock', $busqueda);
				if((int)$CantidadStock>=$cantidad)
					$cesta[$productName]=$cantidad;
				else echo "<br> Solo hay $CantidadStock del producto $productName en Stock <br>";
			}
			else
				unset($cesta[$productName]);
			$_SESSION['cesta']=$cesta;
		}
	}
	if (isset($_SESSION['cesta']) && count($_SESSION['cesta'])>0 ) {//Muestra la cesta
		MostrarCesta($_SESSION['cesta']);
		echo "<br> Cantidad 0 para borrar de la cesta";
		echo "<br> Se puede modificar en cualquier momento";
	}
	if (isset($_POST['compraFin'])) {//Ver si hay un error con el checknumber
		$checkNumber = limpiar_campo($_POST["checkNumber"]);
		if (strlen($checkNumber)!=7)
			$errorCheck=true;
	}

	if (!isset($_POST['compra']) ){//Formulario de producto y cesta
		echo "<form name='alta_ped' action='pe_altaped.php' method='post'>";
		echo "<h3>Producto</h3>";
		echo "<select name='productName'>";
		Lista("productName", "SELECT * FROM products WHERE quantityInStock >= 0");
		echo "</select><br>";
		echo "<label for='cantidad'>Cantidad: </label>";
		echo "<input type='number' name='cantidad' min=0 /> <br />";
		echo "<input type='submit' value='Añadir a Cesta' name='cesta'>";
		echo "<input type='submit' value='Realizar Compra de la Cesta' name='compra'>";
		echo "</form>";
	} else if ((isset($_POST['compra']) || $errorCheck )  &&  count($_SESSION['cesta'])>0 ) {//Formulario de informacion del cliente
		echo "<form name='alta_ped' action='pe_altaped.php' method='post'>";
		echo "<h3>Cliente</h3>";
		echo "<label for='numeroPago'>Numero de Pago: </label>";
		echo "<input type='text' name='checkNumber' placeholder='AA99999' /> <br />";
		echo "<input type='submit' value='Finalizar Compra' name='compraFin'>";
		echo "</form>";
	}
	else {//En caso de no haber ningun producto en la cesta
		echo "<form name='alta_ped' action='pe_altaped.php' method='post'>";
		echo "<h3>Error, No hay productos en la cesta<h3><br>";
		echo "<input type='submit' value='Volver a Cesta' name='volver'>";
		echo "</form>";
	}
	if ($_SERVER["REQUEST_METHOD"] == "POST") {//Compra de producto

		if (isset($_POST['compraFin']) && count($_SESSION['cesta'])>0  && !$errorCheck) {
			$customerNumber= $_SESSION["usuario"];
			$checkNumber = limpiar_campo($_POST["checkNumber"]);
			$ahora = date('Y-m-d');
			//----------->crear el nuevo ordern
			$busqueda="SELECT * FROM customers WHERE customerNumber='$customerNumber'"; //
			$customerNumber=Codigos('customerNumber', $busqueda);
			$busqueda="SELECT * FROM orders";
			$orderNumber=Codigos('orderNumber', $busqueda);
			$orderNumber++;

			$NewOrders="INSERT INTO orders(orderNumber,orderDate,requiredDate,status,comments,customerNumber) values ($orderNumber,'$ahora','$ahora','Shipped',NULL,$customerNumber)";
			Ejecutar($NewOrders);

			//----------->crear los detalles de pedido y modificar la cantidad de Stock de los productos
			$cesta=$_SESSION['cesta'];
			$numeroOrden=1;
			$amount=0;
			foreach ($cesta as $productName => $cantidad) {
				$busqueda="SELECT * FROM products WHERE productName='$productName'"; //
				$productCode=Codigos('productCode', $busqueda);
				$buyPrice=Codigos('buyPrice', $busqueda);
				$priceEach=$buyPrice*$cantidad;
				$orderdetails="INSERT INTO orderdetails(orderNumber, productCode, quantityOrdered, priceEach, orderLineNumber) values ($orderNumber, '$productCode', $cantidad, '$priceEach', $numeroOrden)";
				$numeroOrden++;
				Ejecutar($orderdetails);

				$busqueda="SELECT * FROM products WHERE productName='$productName'";
				$CantidadStock=(int)(Codigos('quantityInStock', $busqueda));
				$CantidadStock-=$cantidad;
				$newCantidad="UPDATE products SET quantityInStock='$CantidadStock' WHERE productName='$productName'";
				Ejecutar($newCantidad);
				$amount+=$cantidad;
			}
			$orderdetails="INSERT INTO payments(customerNumber, checkNumber, paymentDate, amount) values ($customerNumber, '$checkNumber', '$ahora', '$amount')";
			Ejecutar($orderdetails);
			$_SESSION['cesta']=[];
			echo "Se ha realizado el pedido";
			echo "<br><a href='pe_altaped.php'>Volver a cesta</a>";
		}	
	}
}else{
echo "<br> Acceso Restringido debes hacer Login con tu usuario";
echo "<br><a href='pe_login.php'>Volver a pagina Login</a>";
}
?>
</body>
</html>
