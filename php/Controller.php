
<?php
	define('CARACTERES_TOTALES','390');
	define('SIMBOLOS',devolverArrayEspeciales());
	define('SIMBOAYUDA', generateHelps());
	function devolverArrayEspeciales(){
		return 	$arr_especiales=['!' , '"' , '$' , '%' , '/'  , '=' , '?' , '|' , '#' , '>','*' ];
	}

	function obtenerPalabrasConSimbolitos($dificultad){
		$a =  CARACTERES_TOTALES;
		$array = leerArchivo($dificultad);
		$palabras_elegidas = eleccionPalabras($array,$dificultad);
		
		$lista_ID=creacionID($palabras_elegidas,SIMBOAYUDA, $dificultad);
		$simbolosString = creacionStringBase();
		$stringFinal = stringFinal($palabras_elegidas,$simbolosString, $lista_ID);
		$stringFinalConAyudas= stringFinal(SIMBOAYUDA,$stringFinal, $lista_ID);
		$string= correcionEspacios($stringFinalConAyudas,$dificultad);
		return $string;
	}
	function leerArchivo($dificultad){
		if ($dificultad=='facil'){
			$ruta='../resources/diccionari_paraules.txt';
		}else{
			$ruta='../resources/diccionari_paraules_normal.txt';
		}
		
		return $arr_palabras = file($ruta);
	}
	function devolverDificultad($dificultad){
		if ($dificultad=='facil') {
			$num_palabras=6;
		}elseif ($dificultad=='normal') {
			$num_palabras=7;
		}else{
			$num_palabras=12;
		}
		return $num_palabras;
	}

	function eleccionPalabras($arr_palabras,$dificultad){
		if ($dificultad=='facil') {
			$num_palabras=6;
		}elseif ($dificultad=='normal') {
			$num_palabras=7;
		}else{
			$num_palabras=12;
		}

		$arr_eleccion_palabra_indice=[];
		$arr_palabras_elegidas=[];
		$i=0;
		$size_array_palabras=count($arr_palabras)-1;
		while ($i<$num_palabras){
			$random_index=rand(0,$size_array_palabras);
			if (in_array($random_index, $arr_eleccion_palabra_indice)) {
				while (in_array($random_index, $arr_eleccion_palabra_indice)) {
					$random_index=rand(0,$size_array_palabras);
					}
			}
			$arr_eleccion_palabra_indice[] = $random_index;
			$arr_palabras_elegidas[]= $arr_palabras[$random_index];
			$i=$i+1;
		}
		return $arr_palabras_elegidas;
	}
	function creacionStringBase(){
		$string = '';
		for ($a=0; $a < CARACTERES_TOTALES ; $a++) {
			//$caracter=htmlspecialchars(array_rand(SIMBOLOS),ENT_QUOTES);
			$caracter=array_rand(SIMBOLOS);
			$string=$string.SIMBOLOS[$caracter];
		}
		return $string;
	}
	function creacionID($arr_palabras_elegidas,$arrayAyuda){
		$array_ID=[];
		for ($a=0; $a <count($arr_palabras_elegidas) ; $a++) {
			$base='pal'.$a;
			$array_ID[]=$base;
		}
		for ($i=0; $i < count($arrayAyuda); $i++) {
			$ayuda='ayuda'.$i;
			$array_ID[]=$ayuda;
		}
		return $array_ID;
	}
	
	function stringFinal($arr_palabras_elegidas,$string,$lista_ID){
		$random_posicion=0;
		$size_array_elegidas=count($arr_palabras_elegidas);

		
		
		

		for ($y=0; $y < $size_array_elegidas; $y++){
			$no_es_simbolo=0;
			$size_palabra=strlen($arr_palabras_elegidas[$y]);
			$random_posicion=rand(1,CARACTERES_TOTALES-$size_palabra);
			
			

			$arr_split=str_split(substr($string, $random_posicion-1,$size_palabra+2));
			foreach ($arr_split as $caracter) {
				if (!in_array($caracter, SIMBOLOS)) {
					$no_es_simbolo=$no_es_simbolo+1;
				}
			}
			$palabra=$arr_palabras_elegidas[$y];
			if ($no_es_simbolo==0) {
				//$string=substr_replace($string, "<span id='".$lista_ID[$y]."' onClick='comprobar_pal(this.id)'>".$palabra."</span>",$random_posicion,$size_palabra );
				$string=substr_replace($string , $palabra, $random_posicion,$size_palabra );
				
			}else{
				$y-=1;
			}
		}


		$string=preg_replace('/\s+/','',$string);
		$string = preg_replace("/(spanid)/", "span id", $string);
		$string = preg_replace("/(on)/", " on", $string);

		

		return $string;
	}
	function getPalabraCorrecta(){
	}


	function generateHelps(){
		$simbolos = ['%','=','|','#'];
		$simbolosOpenClose = array("{","(","<","[");
		$ayudas = 3;
		$helps = array();

		for($k=0; $k  < $ayudas ; $k++){
			$size = rand(1,10);
			$help = '';
			$inicio = $simbolosOpenClose[rand(0,count($simbolosOpenClose)-1)];
			for ($i=0; $i  < $size ; $i++) {
				if($i == 0){
					$help .= $inicio;
					$help .= $simbolos[rand(0,count($simbolos)-1)];

				}

				if ($i == $size-1) {
					switch ($inicio) {
					    case "{":
							$help .= "}";
					        break;
					    case "(":
							$help .= ")";
					        break;
					    case "<":
							$help .= ">";
					        break;
					    case "[":
							$help .= "]";
					    	break;
					}
				}
				if($i != 0 & $i != $size-1){
					$help .= $simbolos[rand(0,count($simbolos)-1)];
				}
			}
			array_push($helps, $help);
		}
		return $helps;
		
	}
	function correcionEspacios($string,$dificultad){
		if ($dificultad=='dificil') {
			$string .= '$%!$=%';
		}
		return $string;
	}
?>