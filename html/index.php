<?php
    session_start();
    if(isset($_SESSION['nombre'])){
      $nombre =  $_SESSION['nombre'];
    }else{
      $nombre = '';
    }

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>juego</title>
     <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link rel="stylesheet" type="text/css" href="../css/resetCSS.css" media="all">
    <link rel="stylesheet" type="text/css" href="../css/style.css" media="all">
    <link href="https://fonts.googleapis.com/css?family=Share+Tech+Mono&display=swap" rel="stylesheet">
        <?php 
          if(isset($_POST['colorDaltonico'])){
             if($_POST['colorDaltonico'] == "true"){
                echo  '<link rel="stylesheet" type="text/css" href="../css/styleDaltonico.css" media="all">';
              }
           }else{
                echo "hola";
                echo  '<link rel="stylesheet" type="text/css" href="../css/style.css" media="all">';
           } 
     ?>
    <script type="text/javascript" src="../js/jsWork2.js"></script>



    <?php
      include '../php/Controller.php';
      //print_r(array_values(generateHelps())) ;

      $dificultad=$_POST['dificultadElegida'];
      $array_palabras = obtenerPalabrasConSimbolitos($dificultad); // esto es un string
      $listaCaracter = str_split($array_palabras); // esto es una array
      $decode = html_entity_decode($array_palabras);
      // echo $array_palabras;
     ?>
  </head>

  <body onload="cronoInicio()">
    <p id="dificultadChoose" hidden><?php echo $dificultad ?></p>
    <div id="fondo">
      <!-- <div id="efecto"></div> -->
      <img src="../img/pantalla.png" alt="fondo_pantalla">

        <!-- El div (pantalla-texto) es para encajar todo el texto que aparece en la pantalla del juego sin que se vea fuera de sitio -->

        <div id="pantalla-texto">
          <div id="efecto"></div>
          <!-- El div (info_vidas) es para mostrar tanto la información de la cabecera como las vidas restantes que le quedan al jugador -->
          <div id="info_vidas">
            <p class='typing' id="info_juego">ROBCO INDUSTRIES (TN) TERMILINK PROTOCOL ENTER PASSWORD NOW</p>
            <div id="vidas_crono">
              <p class='typing' id="intentos">4 ATTEMPT(S) LEFT:  <span>[]</span>  <span>[]</span> <span>[]</span> <span>[]</span></p>
              <p id="tiempoCrono"> <span id="minutos">0</span>:<span id="segundos">00</span> </p>
            </div>
            <hr id="filete">
          </div>

          <!-- El div (juego) es para encajar todo los elementos jugables juntos -->
          <div id="juego">
            <!-- El div (caracteres) es para poner todos los caracteres y palabras que contendra el juego -->
            <div class="codigo">
              <div class="typing">
              <?php
                for ($i=0; $i < 32; $i++) {
                  $num = rand(10,99);
                  echo "Ex0$num&nbsp <br>";
                }
              ?>
              </div>
            </div>
            <div class='buentrabajo' >
              <div id='vaultboywin'>
                <img src="https://media.giphy.com/media/SHT4S1lOyAbaa6UvQZ/giphy.gif" alt="AnimacionGANADO" >
              </div>
              <div id='vaultboyloss'>
                <img src="https://media.giphy.com/media/IbUkU9LrDgx9uEctjD/giphy.gif" alt="AnimacionPERDIDO">
              </div>
              <div id='easter_egg'>
                <img src="https://i.imgur.com/LbvX2iy.png" alt="AnimacionEasterEgg">

              </div>
              

            </div>
            <div class="caracteres">
              <?php
              $num_palabras=devolverDificultad($dificultad);
              $array_ID=[];
              for ($a=0; $a <$num_palabras; $a++) {
                $base='pal'.$a;
                $array_ID[]=$base;

              }
              
                $palabraCorrecta = $array_ID[rand(0,$num_palabras-1)];
                $listaSimbolos=devolverArrayEspeciales();

                $contador=0;
                $contadorInterno=0;
                $contadorID=0;
                $contadorAyuda=0;
                $contadorInternoAyuda=0;
                $fila = 1;
                $hayPalabra = 0;
                $guardado="";
                $size_palabras=0;
                $helps = SIMBOAYUDA;
                $arraySinPalabras = array();
                $posicionDeLasAyudas=array();
                $listaSimbolosProhibidos=['(',')','[',']','{','}','>'];

                if ($num_palabras==6) {
                  $size_palabras=5;
                }else{
                  $size_palabras=7;
                }
                
                foreach ($listaCaracter as $caracter ) {
                    $caracter_modificado=html_entity_decode($caracter);
                    if (!in_array($caracter_modificado, $listaSimbolos) && !in_array($caracter_modificado, $listaSimbolosProhibidos) && $caracter_modificado!='<' ) {
                      $hayPalabra = 1;
                      if ($contadorInterno==0) {
                         $guardado .= "<span id='".$array_ID[$contadorID]."' onClick='comprobar_pal(this,".$palabraCorrecta.",\"$nombre\")'>".$caracter_modificado;
                        $contadorInterno+=1;
                      }
                      elseif ($contadorInterno==$size_palabras-1) {
                         $guardado .= $caracter_modificado."</span>";
                        $contadorInterno=0;
                        $contadorID+=1;

                      }else{
                         $guardado .= $caracter_modificado;
                         $contadorInterno+=1;
                      }

                    }elseif ($caracter_modificado=='(' || $caracter_modificado=='[' || $caracter_modificado=='{' || $caracter_modificado=='<') {
                        $guardado .= "<span onClick='ayuda(".$palabraCorrecta.")'>".$caracter_modificado;

                  
                    }
                    elseif ($caracter_modificado==')' || $caracter_modificado==']' || $caracter_modificado=='}' || $caracter_modificado=='>') {
                        $guardado .= $caracter_modificado."</span>";

                  
                    }
                    else{
                       $guardado .= $caracter_modificado;
                    }


                    $contador+=1;
                  
                  if ($contador%12==0) {
                    if($hayPalabra != 1){
                      array_push($arraySinPalabras, $fila);
                    }
                    $fila++;
                    $hayPalabra = 0;
                    $guardado .= "</br>";
                  }

                }
                $apariciones=substr_count($guardado, '*');
                for ($h=0; $h < $apariciones ; $h++) { 
                  $sustitucion=array_rand($listaSimbolosProhibidos);
                  $guardado=str_replace('*',$listaSimbolosProhibidos[$sustitucion],$guardado);
                }
                
                echo "<div class='typing'>".$guardado."</div>";

              ?>

            </div>
            <!-- El div (mensajes) es para los mensajes de ayuda al hacer pulsar una palabra -->
            <!-- La class (mensaje) es para estructurar el tamaño de cada mensaje -->
            <div id="mensajes">
              <div id="divblink">
                 <p>> </p><p class="blink">█</p>
              </div>
              <div class="mensaje">
                <p class="mensajeFallo"></p>
              </div>
              <div class="mensaje">
                <p class="mensajeFallo"></p>
              </div>
              <div class="mensaje">
                <p class="mensajeFallo"></p>
              </div>
              <div class="mensaje">
                <p class="mensajeFallo"></p>
              </div>
              <div class="mensaje">
                <p iclass="mensajeFallo"></p>
              </div>
              <div class="mensaje">
                <p class="mensajeFallo"></p>
              </div>

            </div>


          </div> <!-- div juego -->
          <a href="#" onclick="easterEgg()" class="myButton">DO NOT PRESS</a>
        </div> <!-- div pantalla-texto -->

        

        <div class="efectosSonido">

          <audio id="audios" autoplay loop>
            <source src="../sonido/pc.mp3" type="audio/mp3">
          </audio>
          <button onclick="sonidosMute()" type="button"> MUTE </button>

        </div>

        <div class="resolucion-peque">
          <p>RESOLUCIÓN DE LA PANTALLA DEMASIADO PEQUEÑA</p>
        </div>
    </div> <!-- div fondo -->

    <form method="post" id="dataRanking" action="../php/WriteData.php" hidden>
      <input type="text" id="player" name="nombre">
      <input type="text" id="time" name="tiempo">
      <input type="text" id="try" name="intentos">
      <input type="text" id="dificultadChoosed" name="dificultad" value=<?php echo $dificultad ?>>
      <input type="text" id="daltonico" name="daltonico" value=
                                                          <?php 
                                                                if(isset($_POST['colorDaltonico'])){
                                                                      echo $_POST['colorDaltonico'];
                                                                    }
                                                                 
                                                          ?> 
      <input type="submit" name="sendData" name="guardarDatos">
    </form>
  </body>
</html>


