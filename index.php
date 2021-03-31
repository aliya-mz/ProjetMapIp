<?php
/*
Projet : Honeypot
Date : Mars 2021
Auteur : Aliya Myaz
Description : page principale du projet, où la map indiquant les positions des adresses ip est affichée
*/

//inclure le fichier de fonctions
require 'fonctions.php';

//Executer le programme permettant de traiter et afficher les données
ExecuterProgramme("access.log");

$infosAttaques
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
        <?php
        //Affichage de la map https://leafletjs.com/        
        ?>
        <!--Map-->
        <div id="mapid" class="leaflet-container leaflet-touch leaflet-retina leaflet-fade-anim leaflet-grab leaflet-touch-drag leaflet-touch-zoom"></div>
        <script>  
          ShowMap();
        </script>
      </main>
    </body>
</html>