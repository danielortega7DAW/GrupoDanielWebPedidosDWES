 <!--Código por: Rodrigo Cano--> 
<?php
function Conect(){
# Función 'Conect'. 
# Parámetros: 
#
#
#
# Funcionalidad:
# Conectar con la bbdd mediante pdo
#
# Retorna: La coneccion
#
# Código por Rodrigo Cano
	$servername = "localhost";
	$username = "root";
	$password = "rootroot";
	$dbname="pedidos";
	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	return $conn;
}
function limpiar_campo($campoformulario) {
  $campoformulario = trim($campoformulario); //elimina espacios en blanco por izquierda/derecha
  $campoformulario = stripslashes($campoformulario); //elimina la barra de escape "\", utilizada para escapar caracteres
  $campoformulario = htmlspecialchars($campoformulario);  
  return $campoformulario;
   
}
function Ejecutar($cadena){
# Función 'Ejecutar'. 
# Parámetros: 
# 	- $cadena 
#
#
# Funcionalidad:
# Ejecutar la cadena en la bbdd ej:select, update, insert.
#
# Retorna: True en caso de que hizo correctamente / False si hubo algun error en el proceso.
#
#  Código por Rodrigo Cano
	try {
	   $conn = Conect();
	    // set the PDO error mode to exception
	   $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	   $sql = $cadena;
	   $conn->exec($sql);
	   return true;
	    }
	catch(PDOException $e)
	    {
	    echo "Error: " . $e->getMessage()."<br>";
	    return false;
	    }
}
function Codigos($lista, $busqueda) {
# Función 'Codigos'. 
# Parámetros: 
# 	- $lista 
#		-$busqueda
#
# Funcionalidad:
# Buscar con un select un dato en concreto de limite 1
#
# Retorna: Un dato de la tabla / "" en caso de no encontrar
#
#  Código por Rodrigo Cano
	 $codigo="";
	try{
	   $conn = Conect();
	   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	   $stmt = $conn->prepare($busqueda);
	   $stmt->execute();
		// set the resulting array to associative
	   $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
	  
		foreach($stmt->fetchAll() as $row) {
	       $codigo=$row["$lista"];
	   }
	}
	catch(PDOException $e) {
	    echo "Error: " . $e->getMessage();
	}
	$conn = null;
	return $codigo;
}
function Lista($lista, $select) {
# Función 'Lista'. 
# Parámetros: 
# 	- $lista 
#		-$select
#
# Funcionalidad:
# Mostrar las opciones en una lista de una sola colunma
#
# Retorna:
#
#  Código por Rodrigo Cano
	try {
	    $conn = Conect();
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    $stmt = $conn->prepare($select);
	    $stmt->execute();
	
	    // set the resulting array to associative
	    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
	    
		 foreach($stmt->fetchAll() as $row) {
	        echo "<option>" . $row["$lista"]. "</option>";
	     }
	}
	catch(PDOException $e) {
	    echo "Error: " . $e->getMessage();
	}
	$conn = null;
}


function MostrarCesta($cesta)
{
# Función 'MostrarCesta'. 
# Parámetros: 
# 	- $cesta 
#	
#
# Funcionalidad:
# Muestra en una tabla el array cesta de dos columnas, el nombre del producto y la cantidad que pedimos
#
# Retorna:
#
#  Código por Rodrigo Cano
	echo "<h3>Cesta</h3>";
		echo "<table class='table table-bordered' border='1'>";
		echo "<tr>";
		echo "<th>Nombre del Producto</th><th>Cantidad</th>";
		echo "</tr>";
		foreach ($cesta as $NombreProducto => $cantidad) {
			echo "<tr>";
			echo "<td>$NombreProducto</td><td>$cantidad</td>";
			echo "</tr>";
		}
		echo "</table>";
}

?>
