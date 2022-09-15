<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>juego</title>
    <link rel="stylesheet" type="text/css" href="./css/resetCSS.css" media="all">
    <link rel="stylesheet" type="text/css" href="./css/stylePortada.css" media="all">
    <link rel="stylesheet" type="text/css" href="./css/style.css" media="all">;
    <link href="https://fonts.googleapis.com/css?family=Share+Tech+Mono&display=swap" rel="stylesheet">
    <script type="text/javascript" src="js/jsWork2.js"></script> 
    <?php 
          if(isset($_POST['isSelected'])){
              if($_POST['isSelected'] == "false"){
              }else if($_POST['isSelected'] == "true"){
                echo  '<link rel="stylesheet" type="text/css" href="./css/styleDaltonico.css" media="all">';
              }
           }else{
                echo  '<link rel="stylesheet" type="text/css" href="./css/style.css" media="all">';
           } 
     ?>
  </head>

  <body>

    <div id="fondo">

      <img src="./img/pantalla.png" alt="fondo_pantalla">

      <div id="pantalla-texto">
        <div id="efecto"></div>

        <div class="opcionesExtra">
          <label class="checkbox-inline">
            <form action=<?php echo $_SERVER["PHP_SELF"] ?>  method ="post" id="formDaltonic">
              <input id="daltonico"  onclick="changeDaltonic()" 
                                  <?php 
                                        if(isset($_POST['isSelected'])){
                                            if($_POST['isSelected'] == "true"){
                                              echo "checked";
                                            }
                                         }
                                  ?> 
              type="checkbox" data-toggle="toggle" name="daltonico"> Daltonico
              <input type="text" id="isSelected" name="isSelected" hidden>

            </form>
          </label>
          <br>
          <label class="checkbox-inline">
            <input id="extremo" type="checkbox" data-toggle="toggle"> Extremo
          </label>
        </div>

        <H1 id="titulo_principal">TERMINAL FALLOUT</H1>

        <div class="opciones">

          <form id="formDificultad" method="post" action="html/index.php">
          <div class="opcion1">
                <div class="juegar">
                  <a>JUGAR</a>
                </div>
                <div class="niveles">
                  <a onclick="eleccionDificultad(this)" id="facil">FÁCIL</a>
                  <a onclick="eleccionDificultad(this)" id="normal">NORMAL</a>
                  <a onclick="eleccionDificultad(this)" id="dificil">DIFÍCIL</a>
                  <input type="text" hidden id="dificultadElegida" name="dificultadElegida" />
                  <input type="text" hidden id="colorDaltonico" name="colorDaltonico" value=

                    <?php 
                    if(isset($_POST['isSelected'])){
                      echo $_POST['isSelected']; 
                    }

                    ?> 
                  />
                </div>
            </div>
          </form>

          <form method="post" id="formRanking" action="html/ranking.php">
            <div id="opcion2">
              <a onclick="goRanking()">RANKING</a>
              <input type="text" hidden id="colorDaltonicoRanking" name="colorDaltonicoRanking" value=
                                                                                    <?php 
                                                                                      if(isset($_POST['isSelected'])){
                                                                                        echo $_POST['isSelected']; 
                                                                                      }
                                                                                    ?> 
                                                                                  />
            </div>
          </form>

        </div>

      </div> <!-- div pantalla-texto -->
      <div class="efectosSonido">

        <audio id="audios" autoplay loop>
          <source src="../sonido/pc.mp3" type="audio/mp3">
        </audio>

        <button onclick="sonidosMute()" type="button"> MUTE </button>

    </div> <!-- div fondo -->
  </body>
</html>

<?php
	$data = file_get_contents("resources/dataPlayers.json");

	$arry = json_decode($data,true);

 ?>
