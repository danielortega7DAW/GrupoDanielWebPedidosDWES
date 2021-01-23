include_once 'conexion.php';

function comprobarAdmin($username, $passcode){
# Función 'comprobarAdmin'. 
# Parámetros: 
# 	- $username 
#	  - $passcode
#
# Funcionalidad:
# Comprobar que existe un registro en la tabla "admin" con ese $username y $passcode.
#
# Retorna: Los datos de la tabla "admin" / NULL si no existe el registro o ha ocurrido un error.
#
# Código por Raquel Alcázar Mesia

	global $conexion;

	try {
		$consulta = $conexion->prepare("SELECT * FROM admin WHERE username = :username");
		$consulta->bindParam(":username", $username);
		$consulta->execute();
		$datos = $consulta -> fetchAll(PDO::FETCH_ASSOC);

		if($datos!==null){
			for ($i=0; $i<count($datos); $i++){

				if($datos[$i]["passcode"]==$passcode){
					return $datos[$i];
				}
			}

			return null;
		}else{
			return null;
		}

	} catch (PDOException $ex) {
		echo "<p>Ha ocurrido un error al devolver los datos. <span style='color: red; font-weight: bold;'>". $ex->getMessage()."</span></p></br>";
		return null;
	}
}

function obtenerNombre($id){
# Función 'obtenerNombre'. 
# Parámetros: 
# 	- $id 
#
# Funcionalidad:
# Recuperar el nombre de usuario correspondiente al $id.
#
# Retorna: Los datos (username) de la tabla "admin" / NULL si no existe el registro o ha ocurrido un error
#
# Código por Raquel Alcázar Mesia

	global $conexion;

	try {
		$consulta = $conexion->prepare("SELECT username FROM admin WHERE id = :id");
		$consulta->bindParam(":id", $id);
		$consulta->execute();
		$datos = $consulta -> fetch(PDO::FETCH_ASSOC);

		return $datos;

	} catch (PDOException $ex) {
		echo "<p>Ha ocurrido un error al devolver los datos <span style='color: red; font-weight: bold;'>". $ex->getMessage()."</span></p></br>";
		return null;
	}
}
