<!DOCTYPE html> 
<HTML lang="es">
    <HEAD> 
        <TITLE> Disponibilidad de productos por linea </TITLE>
        <meta charset="utf-8">
        <meta name="author" content="DanielOrtega">
    </HEAD>
    <BODY>
<?php
        include_once 'funciones.php';
    
    try {
	    
       	$productos = obtenerStock($conexion);  
    
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
			//$seleccionado=substr($seleccionado, 0, 4);//Recorto el string por si hubiese problemas por los espacios
			//echo $seleccionado."<br>";
			
			/*No sé si usar una variable dentro de una secuencia es posible y por eso da error*/
	       /*El error consiste en que siempre muestra que el stock es 0, supongo que no detecta bien la variable*/
           $uwu = $conexion->prepare("SELECT quantityInStock, productname FROM products WHERE productName LIKE '".$seleccionado."%'");
            //$uwu=$conexion->exec($sql);
            $uwu->execute();
			//echo $uwu;
            foreach($uwu->fetchAll() as $row) {
                echo "El producto  " .$row["productname"]. " dispone de <strong>" .$row["quantityInStock"]. "</strong> unidades.<br>";
            
            
            }
            /*Modificaciones:
                He comentado el substr porque al reducir el nombre del producto seleccionaba varios
                productos que tenian esa cadena de string en comun.
                he añadido un prepare al select.
                muestro los resultados con un bucle "que igual se puede omitir ya que solo deberia
                devolver un resultado o eso entiendo"
                he modificado el parametro que se le pasa a las funciones $pdo 
                por una conexion directa mediante el archivo conexion.php que 
                se incluye en las funciones.
                
		*/
        }    
    }catch(PDOException $e)
        {  
         echo "Se ha producido el siguiente Error : <br><br>" . $e->getMessage();
        }

        $pdo = null;   
         
?>
</BODY>
</HTML>
