<?php

echo'<title> Consulta las ventas </title>';

#Lucas Fadavi Solanilla

        //Para incluir la conexion de la base de datos si usamos el config.php
        //include_once './config.php';
        
        //Para incluir las funciones
        include_once './funcionespedidos.php';
        //Conexion de la base de datos
        $pdo=connectDBpedidos();

//Paso de paramotros $_POST
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $inicio = $_POST['inicio'];
    $fin = $_POST['fin'];

        //Compruebo que la fecha de inicio no sea mayor que la de fin
        if($inicio > $fin){
            echo "<p style='color:red';>¡La fecha de inicio tiene que ser menor a la fecha de fin!. </p>";
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
                                foreach($sql->fetchAll() as $row) {
                                    echo "<tr><td style='border: 2px solid green'>".$row['nombre']."</td>";
                                    echo "<td style='border: 2px solid crimson'>".$row['cantidad']."</td>";
                                    echo "<td style='border: 2px solid royalblue'>".$row['fecha']."</td></tr>";
                                }
                                echo "</table></center>";
            }
}
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