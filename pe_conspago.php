<?php 

//Inicio la sesion
session_start();

//Esto es para chequear si el usuario sigue logeado o existe una sesion
if (!isset($_SESSION["usuario"]) || $_SESSION["usuario"] === false) {
  exit("No estas logeado");
  
}

   #Lucas Fadavi Solanilla

    /*Refactorizacion: se ha modulado mas el codigo en relacion a versiones anteriores.
    Se ha implementado una conexion global, para todo el programa y las funciones,
    Try y Catch añadidos para un posible tratamiento de errores futuro y 
    se han cuidado mucho mas los detalles esteticos*/

     //Para incluir las funciones
     include_once './funciones.php';

try{

    if (!isset($_POST) || empty($_POST)) { 

       
    }else{

        if (empty($_POST['inicio']) && empty($_POST['fin']) && isset($_POST)) { 

            $id = $_SESSION["usuario"];
            
            //Funcion que muestra la consulta sql sin necesidad de introducir fechas   
            $sql1=consultarHistorico($id);

            }else{

                $id = $_SESSION["usuario"];
                $inicio = $_POST['inicio'];
                $fin = $_POST['fin'];


                if($inicio > $fin){ 
                    
                        echo "<span style='color:red'; font-weight:bold;>¡La fecha de inicio tiene que ser menor a la fecha de fin!. </span>";
                        
                    } else{
        
                        //Funcion que muestra la consulta sql sobre las fechas indicadas    
                        $sql=consultarFechaPagos($id, $inicio, $fin);

                    }
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
        <TITLE> Consulta tus compras  </TITLE>
        <meta charset="utf-8">
        <meta name="author" content="Lucas Fadavi">     
    </HEAD>
<BODY>
    
    
    <h4 id="logeado">Hola <?php $id = $_SESSION["usuario"]; $datos = obtenerNombre($id); echo $datos['username']; ?> </h4>

    <div id="consulta">

     <H1> Consulta tus compras </h1>
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