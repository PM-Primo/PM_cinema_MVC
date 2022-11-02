<?php

use controller\CinemaController;

spl_autoload_register(function($class_name){
    include $class_name.'.php';
}); //On charge toutes les classes du projet

$ctrlCinema = new CinemaController();

if(isset($_GET["action"])){
    switch($_GET["action"]){

        case "listFilms" : $ctrlCinema->listFilms(); break;
        case "listActeurs" : $ctrlCinema->listActeurs(); break;
        case "listReals" : $ctrlCinema->listReals(); break;
        case "listGenres" : $ctrlCinema->listGenres(); break;
        case "listRoles" : $ctrlCinema->listRoles(); break;
        case "detailsFilm" : $ctrlCinema->detailsFilm($_GET["id"]); break;
        case "detailsReal" : $ctrlCinema->detailsReal($_GET["id"]); break;
        case "detailsActeur" : $ctrlCinema->detailsActeur($_GET["id"]); break;
        case "detailsGenre" : $ctrlCinema->detailsGenre($_GET["id"]); break;
        case "detailsRole" : $ctrlCinema->detailsRole($_GET["id"]);break;
        case "addGenre" : 
            if(isset($_POST["submit"])){
                $ctrlCinema->addGenre(filter_input(INPUT_POST, "libelle_genre", FILTER_SANITIZE_FULL_SPECIAL_CHARS)); 
            }
            break;
        case "addActeur" : 
            
            //peut-on le mettre ailleurs ?
            if (isset($_POST['acteur_real'])){
                $acteur_real=true;
            }
            else{
                $acteur_real=false;
            }
            
            $ctrlCinema->addActeur(
            filter_input(INPUT_POST, "nom_acteur", FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            filter_input(INPUT_POST, "prenom_acteur", FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            filter_input(INPUT_POST, "sexe_acteur", FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            $_POST['date_naissance_acteur'],
            $acteur_real    
            );
            break;
        case "addReal" : 
            
            //peut-on le mettre ailleurs ?
            if (isset($_POST['acteur_real'])){
                $acteur_real=true;
            }
            else{
                $acteur_real=false;
            }
            
            $ctrlCinema->addReal(
            filter_input(INPUT_POST, "nom_real", FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            filter_input(INPUT_POST, "prenom_real", FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            filter_input(INPUT_POST, "sexe_real", FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            $_POST['date_naissance_real'],
            $acteur_real    
            );
            break;
    
    }
}
else{
    $ctrlCinema->home();
}

?>