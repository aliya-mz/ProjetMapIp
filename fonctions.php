<?php
/*
Projet : Honeypot
Date : Mars 2021
Auteur : Aliya Myaz
Description : fonctions php du projet
*/

define("ERREUR_DONNEE", "donnée inconnue");

//Processus de traitement et affichage des informations 
function ExecuterProgramme(){
    //Lire le fichier
    $fichier = (LireFichier("access.log"));
    /*
    //Appeler la fonction qui sépare les informations récupérées 
    $informations = SeparerInfos($fichier);
    //Analyser les données pour obtenir le nombre d'appel pour chaque ip
    $informations = AnalyserDonnees($informations);
    //Récupérer les coordonéées géographiques grâce à l'API
    $informations = RecupererLocationIp($informations);
    //Afficher les visiteurs sur la map
    AfficherVisiteur($informations);*/
}

//Lire le fichier log - ok (sauv verification type fichier)
function LireFichier($adresse){
    $ressource = fopen($adresse, "rb");
    $fichier = fread($ressource, filesize($adresse));
    fclose($ressource);

    //vérifier conformité fichier
    //[]

    return $fichier;
}

/*
//Sectionner les infos des logs et retourner le tableau - ok
function SeparerInfos($ficherLog){
    var_dump($ficherLog);

    //récupérer chaque ligne séparément
    $lignes = explode("\n", $ficherLog);

    $infosClassees = [];
    //récupérer dans chaque ligne chaque information séparément 
    foreach ($lignes as $ligne){
        //enrgistrer ces infos dans le tableau qui contient tout

        //ip
        $info = explode(" ", $ligne);
        $infosClassees[0] = $info[0];

        //date
        if(!empty(explode(" ", explode("-", $ligne)[2])[1])){            
            $info = str_replace("[", "", explode(" ", explode("-", $ligne)[2])[1]);
            if($info == ""){
                $info = ERREUR_DONNEE;
            }
        }
        else{
            $info = ERREUR_DONNEE;
        }
        $infosClassees[1] = $info;

        //Url demandée
        if(!empty(explode(" ", explode("HTTP/", $ligne)[1])[0])){
            $info = explode(" ", explode("HTTP/", $ligne)[1])[0];
            if($info == ""){
                $info = ERREUR_DONNEE;
            }
        }
        else{
            $info = ERREUR_DONNEE;
        }        
        $infosClassees[2] = $info;

        //code retour HTTP
        if(!empty(explode(" ", explode("HTTP/", $ligne)[1])[1])){
            $info = explode(" ", explode("HTTP/", $ligne)[1])[1];
            if($info == ""){
                $info = ERREUR_DONNEE;
            }
        }
        else{
            $info = ERREUR_DONNEE;
        }   
        $infosClassees[3] = $info;

        //Type d'agent
        if(!empty(explode("/", explode("-", $ligne)[3])[0])){
            $info = str_replace("\" \"", "", explode("/", explode("-", $ligne)[3])[0]);
            if($info == ""){
                $info = ERREUR_DONNEE;
            }
        }
        else{
            $info = ERREUR_DONNEE;
        }   
        $infosClassees[4] = $info;        

        var_dump($infosClassees);
    }  
    return $infosClassees;
}  
*/
//Compter le nombre de répétion pour chaque adresse ip du tableau - ok
function AnalyserDonnees($informations){
    //enregistrer la première attaque dans le tableau
    $infosAnalysees[0] = $informations[0];

    //parcourir toutes les autres ip
    for($i = 1; $i <= count($informations); $i++){        
        //vérifier s'il existe déjà une attaque avec cette adresse IP
        for($j = 0; $j <= count($infosAnalysees); $j++){
            //ce n'est pas la première fois qu'on trouve l'ip dans "informations"
            if($informations[$i][0] == $informations[$j][0]){
                //enregistrer les infos concernant cette ip dans la case du doublon déjà existant
                $infosAnalysees[$j] = $informations[$i];
            }
            else{
                //sinon, enregistrer les infos de l'ip dans une nouvelle case
                $infosAnalysees[count($infosAnalysees)] = $informations[$i];
            }
        }
    }

    return $infosAnalysees;
}

//Appeler l'api de ipinfo pour récupérer les coordonnées géographiques de chaque adresse ip
function RecupererLocationIp($informations){
    //https://ipinfo.io/


    return[];
}

//afficher les visiteurs sur la map
function AfficherVisiteur(){
    /*
    COULEURS DES MARQUEURS
    [1,5] -> vert
    [6,10] -> orange
    >10 -> rouge
    */

    //récupérer les coordonnées avec l'adresse IP grâce à l'API

    //placer le tableau de coordonnées sur la map leaflet
}