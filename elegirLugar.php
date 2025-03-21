<?php
//Conecta con la base de datos ($conexión)
    include 'configdbH.php'; //include del archivo con los datos de conexión
	$conexion = new mysqli(SERVIDOR, USUARIO, PASSWORD, BBDD); //Conecta con la base de datos
    $conexion->set_charset("utf8"); //Usa juego caracteres UTF8
	//Desactiva errores
	$controlador = new mysqli_driver();
    $controlador->report_mode = MYSQLI_REPORT_OFF;
//Cadena de caracteres de la consulta sql	
	$sql="SELECT lugar FROM lugar;"; //Prepara la consulta
	//echo $sql;	//Para probar
	$resultado=$conexion->query($sql);	//Ejecuta la consulta sql
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
		<input type="hidden" id="ip" name="ip" value="192.168.1.1">
        <label for="ciudad">Selecciona una ciudad:</label>
        <select id="ciudad" name="ciudad" required>
		<?php
			while($fila=$resultado->fetch_array()){
				echo '<option class="visita" value="'.$fila["lugar"].'">'.$fila["lugar"].'</option>';
			}
		?>
        </select>
        <button type="submit">Registrar Visita</button>
    </form>
</body>
</html>