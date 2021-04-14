<?php
/*
Projet : Honeypot
Date : Mars 2021
Auteur : Aliya Myaz
Description : fonctions php du projet
*/

define("ERREUR_DONNEE", "donnée inconnue");

function UploadFichier(){
    $fichier = $_FILES["fichier"];
    //Déplacer depuis le répertoire temporaire
    move_uploaded_file($fichier['tmp_name'],'./uploads/'.$fichier['name']);
    return $fichier;
}

//Processus de traitement et affichage des informations 
function ExecuterProgramme($adresse){
    //Lire le fichier
    $fichier = (LireFichier($adresse));
    //Appeler la fonction qui sépare les informations récupérées 
    $informations = SeparerInfos($fichier);
    //Analyser les données pour obtenir le nombre d'appel pour chaque ip
    $informations = AnalyserDonnees($informations);
    //Récupérer les coordonéées géographiques grâce à l'API
    $informations = RecupererLocationIp($informations);

    //Afficher les visiteurs sur la map
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

//Sectionner les infos des logs et retourner le tableau
function SeparerInfos($ficherLog){
    //récupérer chaque ligne séparément
    $lignes = explode("\n", $ficherLog);

    $infosClassees = [];
    $infoslignesClassees = [];
    $compteur = 0;
    //récupérer dans chaque ligne chaque information séparément 
    foreach ($lignes as $ligne){
        //ip
        $info = explode(" ", $ligne);
        $infosClassees[0] = $info[0];

        //date
        if(array_key_exists(2,explode("-", $ligne))){      
            if(array_key_exists(1,explode(" ", explode("-", $ligne)[2]))){
                $info = str_replace("[", "", explode(" ", explode("-", $ligne)[2])[1]);
                if($info == ""){
                    $info = ERREUR_DONNEE;
                }
            }
            else{
                $info = ERREUR_DONNEE;
            }
        }
        else{
            $info = ERREUR_DONNEE;
        }
        $infosClassees[1] = $info;

        //Url demandée
        if(array_key_exists(1, explode("HTTP/", $ligne))){
            if(array_key_exists(0,explode(" ", explode("HTTP/", $ligne)[1]))){
                $info = explode(" ", explode("HTTP/", $ligne)[1])[0];
                if($info == ""){
                    $info = ERREUR_DONNEE;
                }
            }
            else{
                $info = ERREUR_DONNEE;
            }
        }
        else{
            $info = ERREUR_DONNEE;
        }        
        $infosClassees[2] = $info;

        //code retour HTTP
        if(array_key_exists(1,explode("HTTP/", $ligne))){
            if(array_key_exists(1,explode(" ", explode("HTTP/", $ligne)[1]))){
                $info = explode(" ", explode("HTTP/", $ligne)[1])[1];
                if($info == ""){
                    $info = ERREUR_DONNEE;
                }
            }
            else{
                $info = ERREUR_DONNEE;
            }
        }
        else{
            $info = ERREUR_DONNEE;
        }   
        $infosClassees[3] = $info;

        //Type d'agent
        if(array_key_exists(3, explode("-", $ligne))){
            if(array_key_exists(0,explode("/", explode("-", $ligne)[3]))){
                $info = str_replace("\" \"", "", explode("/", explode("-", $ligne)[3])[0]);
                if($info == ""){
                    $info = ERREUR_DONNEE;
                }
            }
            else{
                $info = ERREUR_DONNEE;
            }
        }
        else{
            $info = ERREUR_DONNEE;
        }   
        $infosClassees[4] = $info;

        //nb itérations
        $infosClassees[5] = 1;

        $infoslignesClassees[$compteur] = $infosClassees;
        $compteur += 1;
    }  
    
    return $infoslignesClassees;
}  

//Compter le nombre de répétion pour chaque adresse ip du tableau
function AnalyserDonnees($informations){
    //enregistrer la première attaque dans le tableau
    $infosAnalysees[0] = $informations[0];
    
    //parcourir toutes les autres ip
    for($i = 1; $i < count($informations); $i++){
        $tailleListe = count($infosAnalysees);
        //vérifier s'il existe déjà une attaque avec cette adresse IP
        $dejaExistante = false;
        for($j = 0; $j < $tailleListe; $j++){
            //ce n'est pas la première fois qu'on trouve l'ip dans "informations"
            if($informations[$i][0] == $infosAnalysees[$j][0]){
                //enregistrer les infos concernant cette ip dans la case du doublon déjà existant
                $nbIterations = $infosAnalysees[$j][5];
                $infosAnalysees[$j] = $informations[$i];
                $infosAnalysees[$j][5] = $nbIterations + 1;
                $dejaExistante = true;
                break;
            }
        }
        if (!$dejaExistante){
            //sinon, enregistrer les infos de l'ip dans une nouvelle case
            $infosAnalysees[$tailleListe] = $informations[$i];
        }
    }
    return $infosAnalysees;
}

//Appeler l'api de ipinfo pour récupérer les coordonnées géographiques de chaque adresse ip
function RecupererLocationIp($informations){
    //Appeler l'API
    foreach($informations as $information){
        $pays = "";
        $ville = "";
        $latitude = 0;
        $longitude = 0;

        $url = "https://ipinfo.io/".$information[0]."?token=d8756d314f72ea";
        $result = file_get_contents($url);
        $infosLoc = json_decode($result, true);

        var_dump($infosLoc);

        //apparemment il trouve pas les index suivants alors qu'ils existent
        $pays = $infosLoc["country"];
        $ville = $infosLoc["city"];
        $latitude = explode(",",$infosLoc["loc"])[0];
        $longitude = explode(",",$infosLoc["loc"])[1];

        //enregistrer les informations
        $information[6] = $pays;
        $information[7] = $ville;
        $information[8] = $latitude;
        $information[9] = $longitude;
    }
    
    var_dump($informations);
    return $informations;
}

//Formater les informations pour les afficher dans la popup 
function FormatageInfo($informations){
    $formate = [];

    for($i = 1; $i < count($informations); $i++){
        $formate[$i] = " Lieu : ".$informations[7].", ".$informations[6];
    }

    //var_dump($formate);
    return $formate;
}