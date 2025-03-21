<?php
//Conecta con la base de datos ($conexión)
    include 'configdbH.php'; //include del archivo con los datos de conexión
	$conexion = new mysqli(SERVIDOR, USUARIO, PASSWORD, BBDD); //Conecta con la base de datos
    $conexion->set_charset("utf8"); //Usa juego caracteres UTF8
	//Desactiva errores
	$controlador = new mysqli_driver();
    $controlador->report_mode = MYSQLI_REPORT_OFF;
//Cadena de caracteres de la consulta sql	
	$sql="INSERT INTO visita ('idJesuita','ip') VALUES ('".$_SESSION['njesuita']."','".$_POST['ip']."');"; //Prepara la consulta
	//echo $sql;	//Para probar
	$resultado=$conexion->query($sql);	//Ejecuta la consulta sql
	if ($resultado === TRUE) {
		echo "Visita guardada";
	} else {
		echo "Algo ha fallado";
	}
?>