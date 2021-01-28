<?php

    #Lucas Fadavi Solanilla

    /*Refactorizacion: se ha modulado mas el codigo en relacion a versiones anteriores.
    Se ha implementado una conexion global, para todo el programa y las funciones,
    Try y Catch añadidos para un posible tratamiento de errores futuro y 
    se han cuidado mucho mas los detalles esteticos*/

        //Para incluir las funciones
        include_once './funciones.php';
  
    try {

       //Obtengo las lineas
       $lineas = obtenerLineas();  
    
       if (!isset($_POST) || empty($_POST)) { 
           
     
        }else{
    
            $lineas = $_POST['lineas'];

            //select del codigo de producto
            $ln=consultarLineas($lineas);

            /*funcion que devuelve un Select multitabla para 
            mostrar la cantidad de la linea desc y los datos oportunos*/
            $sql1=consultarLineasPro($ln);
            
        }    
}catch(PDOException $e)
        {  
         echo "Se ha producido el siguiente Error : <br><br>" . $e->getMessage();
        }

if (!isset($_POST['stock'])) {
?>

<!DOCTYPE html> 
<HTML lang="es">
    <HEAD> 
        <TITLE> Disponibilidad de productos por linea </TITLE>
        <meta charset="utf-8">
        <meta name="author" content="Lucas Fadavi">
    </HEAD>
<BODY>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            <!--Deplegable de los productos-->
            <H1> Selecciona la linea </H1>
            Lineas de productos:   
            <select name="lineas">
                <?php foreach($lineas as $linea) : ?>
                    <option> <?php echo $linea ?> </option>
                <?php endforeach; ?>
            </select>
            </br>
            <br>
        
            <input type="submit" name="stock" value="Mostrar stock">

        </FORM>
 
</BODY>
</HTML>

<?php
}
//Cierro la conexion
$conexion = null;  
?>