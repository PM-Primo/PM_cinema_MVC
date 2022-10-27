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

    }
}
else{
    $ctrlCinema->home();
}

?>