<?php
//Recoge la información del formulario
	session_start(); 															//Se inicia sesion para poder recoger el nombre de jesuita enviado en formularios anteriores
	$nombreJesuita=$_SESSION["njesuita"]; 										//Se guarda en nombreJesuita el nombre del jesuita proveniente de la sesion
	$nombreCiudad=$_POST["ciudad"]; 											//Se recoge del formulario anterior el nombre de la ciudad elegido
	
//Conecta con la base de datos ($conexión)
    include 'configdbH.php'; 													//include del archivo con los datos de conexión
	$conexion = new mysqli(SERVIDOR, USUARIO, PASSWORD, BBDD);					//Conecta con la base de datos
    $conexion->set_charset("utf8"); 											//Usa juego caracteres UTF8
//Desactiva errores
	$controlador = new mysqli_driver();
    $controlador->report_mode = MYSQLI_REPORT_OFF;
	
//Cadena de caracteres de la consulta sql	
	$sqlCogerIdJesuita="SELECT idJesuita FROM jesuita WHERE nombre = '".$nombreJesuita."';";										//SQL que devuelve el idJesuita que corresponda al nombre del jesuita
	$resultadoIdJesuita=$conexion->query($sqlCogerIdJesuita); 																		//ResultadoIdJesuita recoge el resultado de ejecutar el SQL de la linea anterior en la base de datos
	$filaIdJesuita = $resultadoIdJesuita->fetch_array(); 																			//Convierte el resultado del SQL ejecutado en un array
	$sqlCogerIpLugar="SELECT ip FROM lugar WHERE lugar = '".$nombreCiudad."';"; 													//SQL que devuelve la IP que corresponda al nombre de la ciudad
	$resultadoIpLugar=$conexion->query($sqlCogerIpLugar);																			//ResultadoIpLugar recoge el resultado de ejecutar el SQL de la linea anterior en la base de datos
	$filaIpLugar = $resultadoIpLugar->fetch_array();																				//Convierte el resultado del SQL ejecutado en un array
	$sql="INSERT INTO visita (idJesuita, ip) VALUES ('".$filaIdJesuita['idJesuita']."','".$filaIpLugar['ip']."');";					//SQL que inserta el idJesuita y la IP en la tabla visita
	//echo $sql; 																													//Envía el contenido de la variable al navegador, o sea, muestra la información en el navegador
	
//Ejecuta la consulta
	$conexion->query($sql);
	if($conexion->affected_rows==0)
		echo '<h2>Algo ha fallado, <a href="./index.html">vuelve a intentarlo</a></h2>';					//Mensaje que aparece en la pagina web cuando algo ha fallado al intentar insertar idJesuita y IP
	else{
		?>
		
		<!DOCTYPE html>
		<html lang="es">
			<head>
				<meta charset="UTF-8">
				<meta name="viewport" content="width=device-width, initial-scale=1.0">
				<title>Visita Guardada</title>
				<style>
					body {
						display: flex;
						justify-content: center;
						align-items: center;
						height: 100vh;
						background-color: #f0f8ff;
						font-family: Arial, sans-serif;
					}
					.container {
						background: white;
						padding: 20px 40px;
						border-radius: 10px;
						box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
						text-align: center;
						animation: fadeIn 1s ease-in-out;
					}
					@keyframes fadeIn {
						from { opacity: 0; transform: translateY(-10px); }
						to { opacity: 1; transform: translateY(0); }
					}
					.checkmark {
						color: #28a745;
						font-size: 50px;
					}
					h1 {
						color: #333;
						margin-top: 10px;
					}
				</style>
			</head>
			<body>
				<div class="container">
					<div class="checkmark">✔</div>
					<h1>La visita ha sido guardada</h1>
				</div>
			</body>
		</html>
<?php	
	}	
//Cierra la conexión
	$conexion->close();
?>