<?php
//Conecta con la base de datos ($conexión)
    include 'configdbH.php'; 												//Include del archivo con los datos de conexión
	$conexion = new mysqli(SERVIDOR, USUARIO, PASSWORD, BBDD); 				//Conecta con la base de datos
    $conexion->set_charset("utf8"); 										//Usa juego caracteres UTF8
	
//Desactiva errores
	$controlador = new mysqli_driver();
    $controlador->report_mode = MYSQLI_REPORT_OFF;
	
//Variables
	$codigo=$_POST["codigo"];							//Recoge en la variable $codigo el codigo enviado desde el formulario de la pagina anterior
	$nombreJesuita=$_POST["njesuita"];					//Recoge en la variable $nombreJesuita el nombre del jesuita enviado desde el formulario de la pagina anterior
	
//Cadena de caracteres de la consulta sql	
	$sql="SELECT codigo, nombre FROM jesuita WHERE codigo = '".$codigo."' AND nombre = '".$nombreJesuita."';";					//Prepara la consulta
	//echo $sql;																												//Envía el contenido de la variable al navegador, o sea, muestra la información en el navegador
	$resultado=$conexion->query($sql);																							//Ejecuta la consulta sql y guarda el resultado de la ejecución en $resultado
	
//Existe el usuario??
	if ($resultado->num_rows == 0) {	
		echo 'Inicio de sesión incorrecto, vuelve a iniciar sesión <a href="./index.html">aquí</a>';					//Comprueba si el resultado de la ejecución de $sql ha devuelto 0 filas, en cuyo caso significará que no existe ningún nombre que tenga ese codigo asignado y viceversa
	} else {
		session_start();																								//Inicia sesión
		$fila=$resultado->fetch_array();																				//Convierte el resultado de la ejecucion de $sql en un array
		$_SESSION["njesuita"]=$fila["nombre"];																			//Guarda en sesión el nombre enviado desde el formulario de la pagina anterior
				//Cadena de caracteres de la consulta sql de lugares	
					$sql2="SELECT lugar FROM lugar;"; 																	//Consulta SQL que recoge todos los lugares (ciudades) de la tabla lugar
					//echo $sql;																						//Envía el contenido de la variable al navegador, o sea, muestra la información en el navegador
					$resultado2=$conexion->query($sql2);																//Ejecuta la consulta sql y guarda el resultado de la ejecución en $resultado2
				?>
	
				<!DOCTYPE html>																							
				<html>			
				<head>
					<meta charset="UTF-8">
					<title>Visita</title>
					<link rel="stylesheet" href="./Camino.css">
				</head>
				<body>
					<h1>Hola, <?php echo $_SESSION["njesuita"]?></h1>
					<form method="post" action="./guardarVisita.php">
						<label for="ciudad">Selecciona una ciudad:</label>
						<select id="ciudad" name="ciudad" required>
						<?php
							while($fila=$resultado2->fetch_array()){																	//Extrae todas las filas del resultado de ejecución de $sql2									
								echo '<option class="visita" value="'.$fila["lugar"].'">'.$fila["lugar"].'</option>';					//Muestra una fila de option por cada fila que se extraiga de la variable $resultado2
							}
						?>
						</select>
						<button type="submit">Registrar Visita</button>
					</form>
				</body>
				</html>
<?php
	}
?>