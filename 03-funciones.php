<?php

/* funcionalidad: conectarse a la base de datos */
function conexionBBDD(){
    
    $servername = "localhost";
    $username = "root";
    $password = "rootroot";
    $dbname = "pedidos";

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $conn;
}


# Función 'obtenerClientesNum'. 
# Parámetros: Conexión a la bbdd 
# 	
# Funcionalidad: Conseguir un Array con los customerNumber
# 
# Return: Array de customerNumber
#
# Realizado: 22/01/2021
# Código por Javier Gonzalez

function obtenerClientesNum($conn){
	$clientes = array();
    
    $sql = "SELECT customerNumber FROM customers ORDER BY customerNumber";

    foreach ($conn->query($sql) as $row) {
        $clientes[]=$row['customerNumber'];   
    }
    return $clientes;
}

# Función 'getInfoPedidoCliente'. 
# Parámetros:  Conexión y el Numero de Cliente que obtenemos del despleagable
# 	
# Funcionalidad:
#	- Hacemos una busqueda del orderNumber, orderDate, status realizados por un cliente
#	- Por cada pedido, buscamos línea producto, nombre ,cantidad pedida y precio unidatario
# 	- Se crea una tabla por pedido
#
# Return: Array de customerNumber
#
# Realizado: 22/01/2021
# Código por Javier Gonzalez 
function getInfoPedidoCliente($conn, $customerNumber){

	$stmt = $conn->prepare("SELECT orderNumber, orderDate, status FROM orders WHERE customerNumber='$customerNumber'");
    $stmt->execute();

    
    if($stmt->rowCount()==0){
    	echo "El cliente ".$customerNumber." no ha realizado ningún pedido.";
    }
    else{
	    //Guardamos en variables los resultados del select
	        //$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
	        foreach($stmt->fetchAll() as $row) {
	            $orderNumber=$row['orderNumber'];
	            $orderDate=$row['orderDate'];
	            $status=$row['status'];

	            echo "<div id=desc>Descripción del pedido : ".$orderNumber." realizado en fecha ".$orderDate.". Estado: <span class='estado'>".$status."</span></div><br>";

	            $stmt2 = $conn->prepare("SELECT orderdetails.orderLineNumber as orden2, products.productName as nombre2, orderdetails.quantityOrdered as cant2, orderdetails.priceEach as price2 FROM orderdetails JOIN products ON orderdetails.productCode=products.productCode WHERE orderdetails.orderNumber='$orderNumber'");
	            $stmt2->execute();

				echo "<table>";
				echo "<tr>";
	        		echo "<th>Numero de Línea del producto</th>";
	        		echo "<th>Nombre de producto</th> ";
	        		echo "<th>Cantidad Pedida</th>";
	        		echo "<th>Precio Unitario</th>";
	            echo "</tr>";

	            foreach($stmt2->fetchAll() as $row) {
	            	$orderLineNumber=$row['orden2'];
	            	$productName=$row['nombre2'];
	            	$quantityOrdered=$row['cant2'];
	            	$priceEach=$row['price2'];
 	
	            	echo "<tr>";
	            		echo "<td>".$orderNumber."</td>";
	            		echo "<td>".$productName."</td>";
	            		echo "<td>".$quantityOrdered."</td>";
	            		echo "<td>".$priceEach."</td>";
	            	echo "</tr>";
	            	
	            }
	            echo "</table>";
	            echo "<br><br><br>";

	        }
        }
    }    

?>