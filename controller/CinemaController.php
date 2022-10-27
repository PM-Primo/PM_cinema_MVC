<?php

namespace Controller;
use Model\Connect;

class CinemaController{

    // Lister les films
    public function listFilms() {

        $pdo = Connect::seConnecter(); // "::" est comme "->" mais pour des éléments statiques et non des instances de classe
        $requete = $pdo->query("
            SELECT titre_film, date_format(date_sortie_film,'%d/%m/%Y') AS 'Sortie_FR'
            FROM film
        ");
        require "view/listFilms.php";
    }

    public function listActeurs() {

        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
            SELECT CONCAT(p.prenom, ' ', p.nom) as 'nom_complet', date_format(p.date_naissance,'%d/%m/%Y') AS 'date_naiss_act'
            FROM acteur a 
            INNER JOIN personne p ON a.id_personne = p.id_personne
        ");
        require "view/listActeurs.php";
    }

    public function listReals() {

        $pdo = Connect::seConnecter(); 
        $requete = $pdo->query("
            SELECT CONCAT(p.prenom, ' ', p.nom) as 'nom_complet', date_format(p.date_naissance,'%d/%m/%Y') AS 'date_naiss_real'
            FROM realisateur r 
            INNER JOIN personne p ON r.id_personne = p.id_personne
        ");
        require "view/listReals.php";
    }

    public function home() {
        require "view/home.php";
    }


}







?>