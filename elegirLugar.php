<?php
//Conecta con la base de datos ($conexión)
	//echo 'Inicio de sesion correcto, procede a elegir tu cuidad <a href="./elegirLugar.php">aquí</a>';
    include 'configdbH.php'; //include del archivo con los datos de conexión
	$conexion = new mysqli(SERVIDOR, USUARIO, PASSWORD, BBDD); //Conecta con la base de datos
    $conexion->set_charset("utf8"); //Usa juego caracteres UTF8
	//Desactiva errores
	$controlador = new mysqli_driver();
    $controlador->report_mode = MYSQLI_REPORT_OFF;
//Variables
	$codigo=$_POST["codigo"];
	$nombreJesuita=$_POST["njesuita"];
//Cadena de caracteres de la consulta sql	
	$sql="SELECT codigo, nombre FROM jesuita WHERE codigo = '".$codigo."' AND nombre = '".$nombreJesuita."';"; //Prepara la consulta
	//echo $sql;	//Para probar
	$resultado=$conexion->query($sql);	//Ejecuta la consulta sql
//Existe el usuario??
	if ($resultado->num_rows == 0) {
		echo 'Inicio de sesión incorrecto, vuelve a iniciar sesión <a href="./index.html">aquí</a>';
	} else {
		session_start();
		$fila=$resultado->fetch_array();
		$_SESSION["njesuita"]=$fila["nombre"];
				//Cadena de caracteres de la consulta sql de lugares	
					$sql2="SELECT lugar FROM lugar;"; //Prepara la consulta
					//echo $sql;	//Para probar
					$resultado2=$conexion->query($sql2);	//Ejecuta la consulta sql
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
							while($fila=$resultado2->fetch_array()){
								echo '<option class="visita" value="'.$fila["lugar"].'">'.$fila["lugar"].'</option>';
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