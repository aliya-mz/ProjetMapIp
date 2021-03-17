<?php
/*
Projet : Honeypot
Date : Mars 2021
Auteur : Aliya Myaz
Description : fonctions php du projet
*/

//Processus de traitement et affichage des informations 
function ExecuterProgramme(){
    //Lire le fichier
    $fichier = (LireFichier("access.log"));
    //Appeler la fonction qui sépare les informations récupérées 
    $informations = SeparerInfos($fichier);
    //Analyser les données pour obtenir le nombre d'appel pour chaque ip
    $informations = AnalyserDonnees($informations);
    //Récupérer les coordonéées géographiques grâce à l'API
    $informations = RecupererLocationIp($informations);
    //Afficher les visiteurs sur la map
    AfficherVisiteur($informations);
}

//Lire le fichier log
function LireFichier($adresse){
    $ressource = fopen($adresse, "rb");
    $fichier = fread($ressource, filesize($adresse));
    fclose($ressource);

    //vérifier conformité fichier
    //[]
}

//Sectionner les infos des logs et retourner le tableau
function SeparerInfos($ficherLog){
    /*
    RECUPERER :
    adresse IP source,
    date d'accès,
    URL de la ressource demandée(ex: /index.html),
    code de retour HTTP du serveur web (ex: 200, 404, 403, etc),
    type d'agent sur le système distant (ex: chrome, firefox, safari, etc).
    */

    //récupérer chaque ligne
    $infosLignes = array();

    foreach ($infosLignes as $ligne){
        $infosLigne = explode(" ", $ligne);

        //enrgistrer ces infos dans le tableau qui contient tout

    }  
    return [];
}  

//Compter le nombre de répétion pour chaque adresse ip du tableau
function AnalyserDonnees($informations){
    //garder les infos de la dernière attaque à cette adresse ip

    return[];
}





//A PARTIR DU 24.03.2021

//Appeler l'api de ipinfo pour récupérer les coordonnées géographiques de chaque adresse ip
function RecupererLocationIp($informations){
    //https://ipinfo.io/
    return[];
}

//afficher les visiteurs sur la map
function AfficherVisiteur(){
    //récupérer les coordonnées avec l'adresse IP grâce à l'API

    //placer le tableau de coordonnées sur la map leaflet
}