<?php

include_once 'conexion.php';

function comprobarAdmin($username, $passcode){
# Función 'comprobarAdmin'. 
# Parámetros: 
# 	- $username 
#	  - $passcode
#
# Funcionalidad:
# Comprobar que existe un registro en la tabla "admin" con ese $username y $passcode.
#
# Retorna: Los datos de la tabla "admin" / NULL si no existe el registro o ha ocurrido un error.
#
# Código por Raquel Alcázar Mesia

	global $conexion;

	try {
		$consulta = $conexion->prepare("SELECT * FROM admin WHERE username = :username");
		$consulta->bindParam(":username", $username);
		$consulta->execute();
		$datos = $consulta -> fetchAll(PDO::FETCH_ASSOC);

		if($datos!==null){
			for ($i=0; $i<count($datos); $i++){

				if($datos[$i]["passcode"]==$passcode){
					return $datos[$i];
				}
			}

			return null;
		}else{
			return null;
		}

	} catch (PDOException $ex) {
		echo "<p>Ha ocurrido un error al devolver los datos. <span style='color: red; font-weight: bold;'>". $ex->getMessage()."</span></p></br>";
		return null;
	}
}

function obtenerNombre($id){
# Función 'obtenerNombre'. 
# Parámetros: 
# 	- $id 
#
# Funcionalidad:
# Recuperar el nombre de usuario correspondiente al $id.
#
# Retorna: Los datos (username) de la tabla "admin" / NULL si no existe el registro o ha ocurrido un error
#
# Código por Raquel Alcázar Mesia

	global $conexion;

	try {
		$consulta = $conexion->prepare("SELECT username FROM admin WHERE id = :id");
		$consulta->bindParam(":id", $id);
		$consulta->execute();
		$datos = $consulta -> fetch(PDO::FETCH_ASSOC);

		return $datos;

	} catch (PDOException $ex) {
		echo "<p>Ha ocurrido un error al devolver los datos <span style='color: red; font-weight: bold;'>". $ex->getMessage()."</span></p></br>";
		return null;
	}
}

function obtenerLineas() {
# Función : obtenerLineas
# Parametros: ninguno
# Funcionalidad: 
# muestra los productos en un desplegable
# Estructuras utilizadas array, bucle, select
#
# retorna: ($lineas) Son los datos de la tabla products (productCode, productLine)
#
# Código realizado por Lucas Fadavi
#
# Fecha 21/01/2021    

    global $conexion;

    $lineas = array();
    
    $sql = "SELECT productCode, productline FROM products group by productline";

    foreach ($conexion->query($sql) as $row) {
            $lineas[]=$row['productline'];   
    
    }
    return $lineas;
} 



function consultarLineas($lineas){
# Función : consultarLineas
# Parametros: 
# -$lineas
# Funcionalidad: 
# Recorre los valores del select de la tabla productos y devolver la linea correspondiente
# Estructuras utilizadas array, bucle, select
#
# retorna: ($ln) la linea que corresponde a la seleccionada por el usuario
#
# Código realizado por Lucas Fadavi
#
# Fecha 22/01/2021    

    global $conexion;

    $sql = $conexion->prepare("SELECT productline as linea FROM products where productline = :lineas ");
        $sql->bindParam(':lineas', $lineas);
        $sql->execute();

        foreach($sql->fetchAll() as $row) {
            $ln=$row["linea"];   
         
        }

           return $ln;                 

}


function consultarLineasPro($ln){
# Función : consultarLineasPro
# Parametros: 
# -$ln
# Funcionalidad: 
# Muestra una tabla con todos los productos de una linea determinada
# Estructuras utilizadas array, bucle, select
#
# retorna: ($sql1) devuelve toda la informacion solicitada acerca de los productos de la linea seleccionada
#
# Código realizado por Lucas Fadavi
#
# Fecha 22/01/2021


    global $conexion;

    echo "<H1>Cantidad disponible de unidades</H1>";
    echo "<body style='background-color:whitesmoke'></body>";
    echo "<center><table border='3px' style='font-family: Comic Sans MS; text-align: center; box-shadow: 2px 2px 2px gray;'>";
    echo "<tr><th style='border: 2px solid navy; background-color:navy; color:white;'>Nombre Producto</th>";
    echo "<th style='border: 2px solid navy; background-color:navy; color:white;'>Cantidad</th></tr>";
    
    $sql1 = $conexion->prepare("SELECT products.productCode as codigo, productlines.productline as linea, 
        products.productName as nombre, products.quantityinstock as cantidad FROM productlines join products 
            on productlines.productline=products.productline where productlines.productline = :linea order by cantidad desc");
                $sql1->bindParam(':linea', $ln);
                $sql1->execute();

           /*Muestro la cantidad de unidades disponibles de esa linea de producto*/
           if($sql1->rowCount() != 0){ //si rowCount devuelve 0 no hay resultados disponibles
            foreach($sql1->fetchAll() as $row) {
             
                echo "<tr><td style='border: 2px solid blue'>".$row['nombre']."</td>";
                echo "<td style='border: 2px solid gold'>".$row['cantidad']."</td>";
                
            }
                echo "</table></center>";
            }else{
                echo "Esta linea no dispone de productos";
            }         

        return $sql1;                 

}



function consultarFechaVentas($inicio, $fin){
# Función : consultarFechaVentas
# Parametros: 
# -$inicio 
# -$fin
# Funcionalidad: 
# Muestra una tabla con todas las ventas realizadas entre las fechas indicadas
# Estructuras utilizadas array, bucle, select
#
# retorna: ($sql) devuelve toda la informacion solicitada acerca de las ventas realizadas 
# entre las indicadas.
#
# Código realizado por Lucas Fadavi
#
# Fecha 22/01/2021

      global $conexion; 

      //Creo una tabla con css
      echo "<body style='background-color:whitesmoke';></body>";
      echo "<center><table border='3px' style='font-family: Comic Sans MS; text-align: center; box-shadow: 2px 2px 2px gray;'>";
      echo "<tr><th style='border: 2px solid green'>Nombre Producto</th>";
      echo "<th style='border: 2px solid crimson'>Cantidad</th>";
      echo "<th style='border: 2px solid royalblue'>Fecha</th></tr>";

        $sql = $conexion->prepare("SELECT orderdetails.productcode as codigo, products.productname as nombre, orders.orderdate as fecha, orderdetails.quantityordered as cantidad from 
            orders JOIN orderdetails ON orders.ordernumber = orderdetails.ordernumber join products 
                on products.productcode=orderdetails.productcode where orders.orderdate >= :inicio  
                    AND orders.orderdate <= :fin order by orderdate limit 25");
                    $sql->bindParam(':inicio', $inicio);
                    $sql->bindParam(':fin', $fin);
                    $sql->execute();

                        //Muestro la tabla de productos vendidos con css
                        echo "<H1>Productos vendidos</H1>"; 
                        if($sql->rowCount() != 0){ //si rowCount devuelve 0 no hay resultados disponibles       
                            foreach($sql->fetchAll() as $row) {
                                echo "<tr><td style='border: 2px solid green'>".$row['nombre']."</td>";
                                echo "<td style='border: 2px solid crimson'>".$row['cantidad']."</td>";
                                echo "<td style='border: 2px solid royalblue'>".$row['fecha']."</td></tr>";
                                }
                                echo "</table></center>";
                        }else{
                            echo "<span style='color:red'; font-weight:bold;>No se han vendido productos entre esas fechas.</span>";
                    } 

           return $sql;                 

}


function consultarFechaPagos($id, $inicio, $fin){
# Función : consultarFechaPagos
# Parametros: 
# -$id 
# -$inicio 
# -$fin
# Funcionalidad: 
# Muestra una tabla con los pagos realizados entre las fechas indicadas
# Estructuras utilizadas array, bucle, select
#
# retorna: ($sql) devuelve toda la informacion solicitada acerca de los pagos realizados 
# entre las indicadas que son: el numeropedido, total y la fecha.
#
# Código realizado por Lucas Fadavi
#
# Fecha 26/01/2021
    

    global $conexion; 

    echo "<center><table border='3px' style='font-family: Comic Sans MS; text-align: center; box-shadow: 4px 4px 4px gray;'>";
    echo "<tr><th style='border: 2px solid red'>Numero de pedido</th>";
    echo "<th style='border: 2px solid green'>Importe total</th>";
    echo "<th style='border: 2px solid blue'>Fecha</th></tr>";

    $sql = $conexion->prepare("SELECT customerNumber as numeroconsumidor, amount as total, paymentDate as fecha, checkNumber as numeropedido
    from payments where CustomerNumber = :id and paymentDate >= :inicio  AND paymentDate <= :fin  Order by paymentDate");
        $sql->bindParam(':id', $id);
        $sql->bindParam(':inicio', $inicio);
        $sql->bindParam(':fin', $fin);
        $sql->execute();
        
        if($sql->rowCount() != 0){ //si rowCount devuelve 0 no hay resultados disponibles       
            foreach($sql->fetchAll() as $row) {
                echo "<tr><td style='border: 2px solid red'>".$row['numeropedido']."</td>";
                echo "<td style='border: 2px solid green'>".$row['total']."</td>";
                echo "<td style='border: 2px solid blue'>".$row['fecha']."</td></tr>";
            
            }
    echo "</table></center>";
    }else{
        
        echo "<span style='color:red'; font-weight:bold;>No has realizado ningun pago entre esas fechas.</span>";
    }


        return $sql;                 
}


function consultarHistorico($id){
# Función : consultarHistorico
# Parametros: 
# -$id 
#
# Funcionalidad: 
# Muestra una tabla con todo el historial de pagos del usuario sin necesidad de indicar fechas
# Estructuras utilizadas array, bucle, select
#
# retorna: ($sql1) devuelve toda la informacion solicitada acerca de todos los pagos realizados 
# por el usuario que son: el checknumber, amount y paymentdate.
#
# Código realizado por Lucas Fadavi
#
# Fecha 26/01/2021    

   global $conexion;

    echo "<center><table border='3px' style='font-family: Comic Sans MS; text-align: center; box-shadow: 4px 4px 4px gray;'>";
    echo "<tr><th style='border: 2px solid red'>Numero de pedido</th>";
    echo "<th style='border: 2px solid green'>Importe total</th>";
    echo "<th style='border: 2px solid blue'>Fecha</th></tr>";

    $sql1 = $conexion->prepare("SELECT checknumber, amount, paymentdate from payments where CustomerNumber = :id ");
        $sql1->bindParam(':id', $id);
        $sql1->execute();
        foreach($sql1->fetchAll() as $row) {
            echo "<tr><td style='border: 2px solid red'>".$row['checknumber']."</td>";
            echo "<td style='border: 2px solid green'>".$row['amount']."</td>";
            echo "<td style='border: 2px solid blue'>".$row['paymentdate']."</td></tr>";
        
        }
   echo "</table></center>";

        return $sql1;

}

?>
