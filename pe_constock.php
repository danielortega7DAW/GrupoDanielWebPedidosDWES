<!DOCTYPE html> 
<HTML lang="es">
    <HEAD> 
        <TITLE> Disponibilidad de productos por linea </TITLE>
        <meta charset="utf-8">
        <meta name="author" content="Lucas Fadavi">
    </HEAD>
    <BODY>
<?php

    #Lucas Fadavi Solanilla

       //Para incluir la conexion de la base de datos si usamos el config.php
        //include_once './config.php';
        //Para incluir las funciones
        include_once './funcionesLucas.php';

        //Conexion de la base de datos
        $pdo=connectDBpedidos();
  
    try {

       //Obtengo las lineas
       $lineas = obtenerLineas($pdo);  
    
       if (!isset($_POST) || empty($_POST)) { 
           
?>            
    
      <form name='cantidad' action='pe_constock.php' method='POST'>

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
        
            <input type="submit" value="Mostrar stock">

        </FORM>

<?php        
        }else{
    
            $lineas = $_POST['lineas'];

            //select del codigo de producto
            $sql=consultarLineas($pdo, $lineas);

            foreach($sql->fetchAll() as $row) {
                $ln=$row["linea"];   
             
            }
            //Select multitabla para mostrar la cantidad de la linea desc y los datos oportunos
            $sql1=consultarLineasPro($pdo, $ln);
            
            echo "<H1>Cantidad disponible de unidades:</H1>";
            /*Muestro la cantidad de unidades disponibles de esa linea de producto*/
            if($sql1->rowCount() != 0){ //si rowCount devuelve 0 no hay resultados disponibles
                foreach($sql1->fetchAll() as $row) {
                 
                    echo "El producto " .$row["nombre"]. " dispone de <strong>" .$row["cantidad"]. "</strong> unidades.<br>";
                }
            }else{
                echo "Esta linea no dispone de productos";
           } 
        }    
    }catch(PDOException $e)
        {  
         echo "Se ha producido el siguiente Error : <br><br>" . $e->getMessage();
        }

        //Cierro la conexion
        $pdo = null;   
         
?>
</BODY>
</HTML>