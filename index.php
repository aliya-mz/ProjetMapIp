<?php
/*
Projet : Honeypot
Date : Mars 2021
Auteur : Aliya Myaz
Description : page principale du projet, où la map indiquant les positions des adresses ip est affichée
*/

//inclure le fichier de fonctions
require 'fonctions.php';

$valider = FILTER_INPUT(INPUT_POST, "valider", FILTER_SANITIZE_STRING);
$adresse = FILTER_INPUT(INPUT_POST, "adresse", FILTER_SANITIZE_STRING);

//Executer le programme permettant de récupérer et traiter les données du fichier log
if($valider){
  $fichierLog = UploadFichier();
  $infosAttaques = ExecuterProgramme($fichierLog["name"]);
  echo $fichierLog["name"];
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset=UTF-8>
        <title>Accueil</title>
        <link href="css/style.css" rel="stylesheet" type="text/css"/>
        <script src="fonctions.js" type="tex/javascript"></script>
        <!--Leaflet-->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
    </head>
    <body onload="RecupererLocation(infosAttaques)">
    <script src="fonctions.js"></script>
      <main>
        <div id="divMenu">
          <form method="POST" action="index.php">
            <input type="file" colspan="2" name="fichier" accept=".log"/>    
            <button type="submit" name="valider" value="valider">Valider</button>
            <div id="divInfos">
              <?php 
              AfficherInfos();
              ?>
            </div>
          </form>          
        </div>

        <?php
        //Affichage de la map https://leafletjs.com/        
        ?>
        <!--Map-->
        <div id="mapid" class="leaflet-container leaflet-touch leaflet-retina leaflet-fade-anim leaflet-grab leaflet-touch-drag leaflet-touch-zoom"></div>

        <script>  
        //Map
        var mymap = L.map('mapid').setView([51.505, -0.09], 13);

        function ShowMap(){	
          //affichage de la map
          L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiYWxkb3JhbCIsImEiOiJja213MWpoeGwwYWtlMnV1dGllYjQ4Y3Y1In0.1Z59U9T8LvXeEV9eA9CKvg', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                maxZoom: 18,
                id: 'mapbox/streets-v11',
                tileSize: 512,
                zoomOffset: -1,
                accessToken: 'pk.eyJ1IjoiYWxkb3JhbCIsImEiOiJja213MWpoeGwwYWtlMnV1dGllYjQ4Y3Y1In0.1Z59U9T8LvXeEV9eA9CKvg'
            }).addTo(mymap);
        }

        // /!\ Le script n'est pas inclus, donc je l'ai copié au-dessus /!\
        ShowMap();
        </script>
      </main>
    </body>
</html>