<HTML>
    <HEAD> <TITLE> Funciones webpedidos </TITLE>
     <meta charset="utf-8">   
    </HEAD>
    <BODY>
<?php

#Lucas Fadavi Solanilla

#Función : connectDBpedidos
#
#Funcionalidad conecta con la base de datos
#
#Parametros: ninguno
#
#Estructuras variables pdo
#
#retorna: $pdo
#
#Código realizado por Lucas Fadavi
#
#Fecha 22/01/2021
function connectDBpedidos(){
    $servername = "localhost";
    $username = "root";
    $password = "rootroot";
    $dbname = "pedidos";
    
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        return $pdo;
}


#Función : obtenerLineas
#
#Funcionalidad muestra los productos en un desplegable
#
#Parametros: $pdo
#
#Estructuras utilizadas array, bucle, select
#
#retorna: $lineas
#
#Código realizado por Lucas Fadavi
#
#Fecha 21/01/2021
function obtenerLineas($pdo) {
    $lineas = array();
    
    $sql = "SELECT productCode, productline FROM products group by productline";

    foreach ($pdo->query($sql) as $row) {
            $lineas[]=$row['productline'];   
    
    }
    return $lineas;
} 


#Función : consultarLineas
#
#Funcionalidad muestra las lineas de productos
#
#Parametros: $pdo, $lineas
#
#Estructuras utilizadas bindParam, select
#
#retorna: $sql
#
#Código realizado por Lucas Fadavi
#
#Fecha 22/01/2021
function consultarLineas($pdo, $lineas){

    $pdo=connectDBpedidos();

    $sql = $pdo->prepare("SELECT productline as linea FROM products where productline = :lineas ");
        $sql->bindParam(':lineas', $lineas);
        $sql->execute();

           return $sql;                 

}

#Función : consultarLineasPro
#
#Funcionalidad muestra las compras realizadas entre dos fechas
#
#Parametros: $pdo, $Ln
#
#Estructuras utilizadas bindParam, select
#
#retorna: $sql1
#
#Código realizado por Lucas Fadavi
#
#Fecha 22/01/2021
function consultarLineasPro($pdo, $ln){

    $pdo=connectDBpedidos();

    $sql1 = $pdo->prepare("SELECT products.productCode as codigo, productlines.productline as linea, 
        products.productName as nombre, products.quantityinstock as cantidad FROM productlines join products 
            on productlines.productline=products.productline where productlines.productline = :linea order by cantidad desc");
                $sql1->bindParam(':linea', $ln);
                $sql1->execute();

           return $sql1;                 

}


#Función : consultarFechaVentas
#
#Funcionalidad muestra las compras realizadas entre dos fechas
#
#Parametros: $pdo, $inicio, $fin
#
#Estructuras utilizadas bindParam, select
#
#retorna: $sql
#
#Código realizado por Lucas Fadavi
#
#Fecha 22/01/2021
function consultarFechaVentas($pdo, $inicio, $fin){

    $pdo=connectDBpedidos();

        $sql = $pdo->prepare("SELECT orderdetails.productcode as codigo, products.productname as nombre, orders.orderdate as fecha, orderdetails.quantityordered as cantidad from 
            orders JOIN orderdetails ON orders.ordernumber = orderdetails.ordernumber join products 
                on products.productcode=orderdetails.productcode where orders.orderdate >= :inicio  
                    AND orders.orderdate <= :fin order by orderdate limit 25");
                        $sql->bindParam(':inicio', $inicio);
                        $sql->bindParam(':fin', $fin);
                        $sql->execute();

           return $sql;                 

}
?>
</BODY>
</HTML>