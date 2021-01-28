<?php 

 #Lucas Fadavi Solanilla

     /*Refactorizacion: 
    -Codigo mas modulado en relación a versiones anteriores.
    -Se ha implementado una conexion global para todo el programa y las funciones.
    -Try y Catch añadidos para un posible tratamiento de errores futuro. 
    -Detalles esteticos mas cuidados*/


        //Para incluir las funciones
        include_once './funciones.php';
      
try{

    if (!isset($_POST) || empty($_POST)) { 

       
    }else{

        $inicio = $_POST['inicio'];
        $fin = $_POST['fin'];

        //Compruebo que la fecha de inicio no sea mayor que la de fin
        if($inicio > $fin){

            echo "<span style='color:red'; font-weight:bold;>¡La fecha de inicio tiene que ser menor a la fecha de fin!. </span>";
            
            } else {

                //Funcion que muestra la consulta sql sobre las fechas indicadas
                $sql=consultarFechaVentas($inicio, $fin);

            }
    }
}catch(PDOException $e)
    {  
        echo "Se ha producido el siguiente Error : <br><br>" . $e->getMessage();
    }
 
if (!isset($_POST['consultar'])) {
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
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                
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
<?php
}
//Cierro la conexion
$conexion = null;  
?>
