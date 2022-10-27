<?php

namespace Controller;
use Model\Connect;

class CinemaController{

    // Lister les films
    public function listFilms() {

        $pdo = Connect::seConnecter(); // "::" est comme "->" mais pour des éléments statiques et non des instances de classe
        $requete = $pdo->query("
            SELECT titre_film, date_sortie_film
            FROM film
        ");

        require "view/listFilms.php";

    }


}







?>