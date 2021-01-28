<!DOCTYPE html> 
<HTML lang="es">
    <HEAD> 
        <TITLE> Disponibilidad de productos por linea </TITLE>
        <meta charset="utf-8">
        <meta name="author" content="DanielOrtega">
    </HEAD>
    <BODY>
<?php
        include_once 'funcionesDani.php';
        $pdo=connectDBpedidos();
  
    try {

       $productos = obtenerStock($pdo);  
    
       if (!isset($_POST) || empty($_POST)) { 
           
?>            
    
      <form name='cantidad' action='pe_consprodstock.php' method='POST'>
            <H1> Selecciona el producto </H1>
            Productos:   
            <select name="productos">
                <?php foreach($productos as $producto) : ?>
                    <option> <?php echo $producto ?> </option>
                <?php endforeach; ?>
            </select>
            </br>
            <br>
        
            <input type="submit" value="Mostrar stock">

        </FORM>

<?php        
        }else{
    
            $seleccionado=$_POST['productos'];
			$seleccionado=substr($seleccionado, 0, 4);//Recorto el string por si hubiese problemas por los espacios
			echo $seleccionado."<br>";
			
			/*No sé si usar una variable dentro de una secuencia es posible y por eso da error*/
	       /*El error consiste en que siempre muestra que el stock es 0, supongo que no detecta bien la variable*/
			$sql="SELECT quantityInStock FROM products WHERE productName LIKE '".$seleccionado."%'";
			$uwu=$pdo->exec($sql);
			echo $uwu;
			
        }    
    }catch(PDOException $e)
        {  
         echo "Se ha producido el siguiente Error : <br><br>" . $e->getMessage();
        }

        $pdo = null;   
         
?>
</BODY>
</HTML>
