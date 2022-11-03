<?php

use controller\CinemaController;

spl_autoload_register(function($class_name){
    include $class_name.'.php';
}); //On charge toutes les classes du projet

$ctrlCinema = new CinemaController();

if(isset($_GET["id"])){
    $id=$_GET["id"];
}

if(isset($_GET["action"])){
    switch($_GET["action"]){

        case "listFilms" : $ctrlCinema->listFilms(); break;
        case "listActeurs" : $ctrlCinema->listActeurs(); break;
        case "listReals" : $ctrlCinema->listReals(); break;
        case "listGenres" : $ctrlCinema->listGenres(); break;
        case "listRoles" : $ctrlCinema->listRoles(); break;
        case "detailsFilm" : $ctrlCinema->detailsFilm($id); break;
        case "detailsReal" : $ctrlCinema->detailsReal($id); break;
        case "detailsActeur" : $ctrlCinema->detailsActeur($id); break;
        case "detailsGenre" : $ctrlCinema->detailsGenre($id); break;
        case "detailsRole" : $ctrlCinema->detailsRole($id); break;
        case "addGenre" : $ctrlCinema->addGenre(); break;             
        case "addActeur" : $ctrlCinema->addActeur(); break;
        case "addReal" : $ctrlCinema->addReal(); break;
        case "addFilm" : $ctrlCinema->addFilm(); break;
    }
}
else{
    $ctrlCinema->home();
}

?>