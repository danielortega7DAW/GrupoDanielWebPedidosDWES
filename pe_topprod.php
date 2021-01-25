<?php echo'<title> Consulta las ventas </title>';

#Lucas Fadavi Solanilla

/*Version depurada 25/01/21

#Se ha añadido un try/catch por si en un futuro se realizara tratamiento de errores
#Se ha contemplado la posibilidad de que no existan registros entre dos fechas concretas

*/ 

        //Para incluir la conexion de la base de datos si usamos el config.php
        //include_once './config.php';
        
        //Para incluir las funciones
        include_once './funcionesLucas.php';
        //Conexion de la base de datos
        $pdo=connectDBpedidos();
try{

    if (!isset($_POST) || empty($_POST)) { 

       
    }else{

        //Paso de parametros $_POST
        $inicio = $_POST['inicio'];
        $fin = $_POST['fin'];

            //Compruebo que la fecha de inicio no sea mayor que la de fin
            if($inicio > $fin){
                echo "<span style='color:red'; font-weight:bold;>¡La fecha de inicio tiene que ser menor a la fecha de fin!. </span>";
                } else {

                    //Creo una tabla con css
                    echo "<body style='background-color:whitesmoke';></body>";
                    echo "<center><table border='3px' style='font-family: Comic Sans MS; text-align: center; box-shadow: 2px 2px 2px gray;'>";
                    echo "<tr><td style='border: 2px solid green'><b>Nombre Producto</b></td>";
                    echo "<td style='border: 2px solid crimson'><b>Cantidad</b></td>";
                    echo "<td style='border: 2px solid royalblue'><b>Fecha</b></td></tr>";

                        //Funcion que me muestra la consulta sql sobre las fechas indicadas
                        $sql=consultarFechaVentas($pdo, $inicio, $fin);

                                    //Muestro la tabla de productos vendidos con css
                                    echo "<H1>Productos vendidos:</H1>"; 
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
                    }
        }
}catch(PDOException $e)
    {  
        echo "Se ha producido el siguiente Error : <br><br>" . $e->getMessage();
    }

//Cierro la conexion
$pdo = null;   
?>
<!DOCTYPE html> 
<HTML lang="es">
    <HEAD> 
        <TITLE> Consulta las ventas  </TITLE>
        <meta charset="utf-8">
        <meta name="author" content="Lucas Fadavi">     
    </HEAD>
<BODY>
    
    <!--Lucas Fadavi Solanilla-->

    <div id="consulta">

     <H1> Consultar ventas </h1>
        <form name='consulta' action='pe_topprod.php' method='POST'>
                
                Fecha inicio:
                <input type='date' id='inicio' name='inicio' size=15  value=""><br>
                Fecha fin:
                <input type='date' id='fin' name='fin' size=15 value=""><br>
            <br>
                <input type="submit" id="consultar" name="consultar" value="Consultar">
           
        </form>
    </div>  
</BODY>
</HTML>