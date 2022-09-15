<?php
    session_start();
    echo $_POST['daltonico'];
	if(isset($_POST["nombre"]) and isset($_POST["tiempo"]) and isset($_POST["intentos"])){
		$dif = "";
		if($_POST["dificultad"] == 'facil'){
			$dif = 'C';
		}else if($_POST["dificultad"] == 'normal'){
			$dif = 'B';
		}else if($_POST["dificultad"] == 'dificil'){
			$dif = 'A';
		}
		
		$_SESSION['nombre'] = $_POST["nombre"];
		$datosRanking = obtenerDatos();
		$jugador = array('nombre'     => $_POST["nombre"],
						 'fallos'     => $_POST["intentos"],
						 'tiempo' 	  => $_POST["tiempo"],
						 'dificultad' => $dif);


		array_push($datosRanking,$jugador);

		$datosOrdenados = array_orderby($datosRanking,'dificultad',SORT_ASC,'fallos',SORT_ASC,'tiempo',SORT_ASC, 'nombre',SORT_ASC);
		$json_string = json_encode($datosOrdenados,JSON_PRETTY_PRINT);
		$file = '../resources/dataPlayers.json';
		file_put_contents($file, $json_string);
	}



	function obtenerDatos(){
		$data = file_get_contents("../resources/dataPlayers.json");

		if($data == ""){
			return array();
		}
		return json_decode($data,true);
		}

function array_orderby() {
    $args = func_get_args();
    $data = array_shift($args);
    foreach ($args as $n => $field) {
        if (is_string($field)) {
            $tmp = array();
            foreach ($data as $key => $row)
                $tmp[$key] = $row[$field];
            $args[$n] = $tmp;
            }
    }
    $args[] = &$data;
    call_user_func_array('array_multisort', $args);
    return array_pop($args);
	}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>cargando datos</title>
		<link rel="stylesheet" type="text/css" href="../css/resetCSS.css" media="all">
		<link rel="stylesheet" type="text/css" href="../css/style.css" media="all">
		<link rel="stylesheet" type="text/css" href="../css/styleDatos.css" media="all">
		    <?php 
          if(isset($_POST['daltonico'])){
              if($_POST['daltonico'] == "true"){
                echo  '<link rel="stylesheet" type="text/css" href="../css/styleDaltonico.css" media="all">';
              }
           }else{
                echo  '<link rel="stylesheet" type="text/css" href="../css/style.css" media="all">';
           } 
     ?>
		<meta http-equiv="Refresh" content="2;url=../html/ranking.php">
	</head>
	<body>
		<div id="fondo">

      <img src="../img/pantalla.png" alt="fondo_pantalla">
			<div id="pantalla-texto">
				<div id="efecto"></div>
				<div id="cargaDatos">
					<p>GUARDANDO DATOS EN EL FICHERO</p>
					<p class="textDatos">Gracias por jugar</p>
				</div>
			</div>
		</div>
 </body>
</html>
