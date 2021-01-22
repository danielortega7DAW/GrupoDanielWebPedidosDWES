
<?php

/*Código realizado por Lucas Fadavi
Fecha 21/01/2021*/

#Lucas Fadavi Solanilla


define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'rootroot');
define('DB_NAME', 'pedidos');
 

try{
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: Conexion fallida. " . $e->getMessage());
}

      
      
?>
