<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>03-Consulta de Pedidos</title>
    <style>
        table, tr, th, td{border:1px solid black; border-collapse:collapse; text-align: center;}
        #desc{font-weight: bold; font-size:14pt;}
        .estado{color:ForestGreen;};
    </style>
    <!-- <link rel="stylesheet" href="../bootstrap.min.css"> -->
</head>
<body>


<?php

  #Javier Gonzalez
    include_once 'funciones.php';
    //$conn = conexionBBDD();


    try {
    
        if (!isset($_POST) || empty($_POST)) {

            $customerNumberArray=obtenerClientesNum($conexion);
?>
        <h1 class="text-center"> CONSULTA DE PEDIDOS </h1>
            <form id="product-form" name="formulario" action="pe_consped.php" method="post" class="card-body">
                <div>Numero de Cliente:
                    <select name="cliente">
                        <?php foreach($customerNumberArray as $customer) : ?>
                            <option> <?php echo $customer ?> </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <input type="submit" name="submit" value="Consultar" class="btn btn-warning disabled">
            </form>    
        <br>
<?php
        }else{ 

                $customerNumber = ($_POST['cliente']);
                getInfoPedidoCliente($conexion, $customerNumber);

            }
        }

    catch(PDOException $e)
        {  
            echo $stmt . "<br>" . $e->getMessage();
        }

    $conexion = null;
    
?>






</body>
</html>
