<?php
//Recoge la información del formulario
	session_start();
	$nombreJesuita=$_SESSION["njesuita"];
	$nombreCiudad=$_POST["ciudad"];
	
//Conecta con la base de datos ($conexión)
    include 'configdbH.php'; //include del archivo con los datos de conexión
	$conexion = new mysqli(SERVIDOR, USUARIO, PASSWORD, BBDD); //Conecta con la base de datos
    $conexion->set_charset("utf8"); //Usa juego caracteres UTF8
	//Desactiva errores
	$controlador = new mysqli_driver();
    $controlador->report_mode = MYSQLI_REPORT_OFF;
	
//Cadena de caracteres de la consulta sql	
	$sqlCogerIdJesuita="SELECT idJesuita FROM jesuita WHERE nombre = '".$nombreJesuita."';";
	$resultadoIdJesuita=$conexion->query($sqlCogerIdJesuita);
	$filaIdJesuita = $resultadoIdJesuita->fetch_array();
	$sqlCogerIpLugar="SELECT ip FROM lugar WHERE lugar = '".$nombreCiudad."';";
	$resultadoIpLugar=$conexion->query($sqlCogerIpLugar);
	$filaIpLugar = $resultadoIpLugar->fetch_array();
	$sql="INSERT INTO visita (idJesuita, ip) VALUES ('".$filaIdJesuita['idJesuita']."','".$filaIpLugar['ip']."');";
	
	echo $sql; //envía el contenido de la variable al navegador, o sea, muestra la información en el navegador
	
//Ejecuta la consulta
	$conexion->query($sql);
	if($conexion->affected_rows>0)
		echo "<h2>La visita ha sido guardada</h2>";
	else{
		echo '<h2>Algo ha fallado, <a href="./index.html">vuelve a intentarlo</a></h2>';
	}	

//Cierra la conexión
	$conexion->close();
?>