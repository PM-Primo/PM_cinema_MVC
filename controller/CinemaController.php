<?php

namespace Controller;
use Model\Connect;

class CinemaController{

    // Lister les films
    public function listFilms() {

        $pdo = Connect::seConnecter(); // "::" est comme "->" mais pour des éléments statiques et non des instances de classe
        $requete = $pdo->query("
            SELECT titre_film, date_format(date_sortie_film,'%d/%m/%Y') AS 'Sortie_FR', id_film
            FROM film
            ORDER BY date_sortie_film DESC
        ");
        require "view/listFilms.php";
    }

    public function listActeurs() {

        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
            SELECT CONCAT(p.prenom, ' ', p.nom) as 'nom_complet', date_format(p.date_naissance,'%d/%m/%Y') AS 'date_naiss_act', a.id_acteur
            FROM acteur a 
            INNER JOIN personne p ON a.id_personne = p.id_personne
            ORDER BY p.nom ASC
        ");
        require "view/listActeurs.php";
    }

    public function listReals() {

        $pdo = Connect::seConnecter(); 
        $requete = $pdo->query("
            SELECT CONCAT(p.prenom, ' ', p.nom) as 'nom_complet', date_format(p.date_naissance,'%d/%m/%Y') AS 'date_naiss_real', id_realisateur
            FROM realisateur r 
            INNER JOIN personne p ON r.id_personne = p.id_personne
            ORDER BY p.nom ASC
        ");
        require "view/listReals.php";
    }

    public function listGenres() {

        $pdo = Connect::seConnecter(); 
        $requete = $pdo->query("
            SELECT libelle_genre
            FROM genre
            ORDER BY libelle_genre ASC
        ");
        require "view/listGenres.php";
    }

    public function listRoles() {

        $pdo = Connect::seConnecter(); 
        $requete = $pdo->query("
            SELECT r.nom_role, CONCAT(p.prenom, ' ', p.nom) AS 'Acteur'
            FROM interpreter i
            INNER JOIN role r ON i.id_role = r.id_role
            INNER JOIN acteur a ON i.id_acteur = a.id_acteur
            INNER JOIN personne p ON a.id_personne = p.id_personne
            ORDER BY r.nom_role
        ");
        require "view/listRoles.php";
    }

    public function detailsFilm($id) {

        $pdo = Connect::seConnecter(); 
        $requete_details = $pdo->prepare("
            SELECT f.titre_film, date_format(sec_to_time(f.duree_film*60), '%Hh%i') AS duree, 
            date_format(f.date_sortie_film,'%d/%m/%Y') AS 'Sortie_FR', f.note_film, f.resume_film, 
            CONCAT (p.prenom,' ' ,p.nom) AS 'Réalisateur', r.id_realisateur
            FROM film f 
            INNER JOIN realisateur r ON f.id_realisateur = r.id_realisateur
            INNER JOIN personne p ON p.id_personne = r.id_personne
            WHERE id_film = :id
        ");
        $requete_details->execute(["id"=> $id]);

        $requete_casting = $pdo->prepare("
            SELECT r.nom_role, CONCAT(p.prenom, ' ' , p.nom) AS 'interprete', i.id_acteur
            FROM interpreter i 
            INNER JOIN acteur a ON i.id_acteur = a.id_acteur
            INNER JOIN personne p ON a.id_personne = p.id_personne
            INNER JOIN role r ON i.id_role = r.id_role
            WHERE i.id_film = :id
        ");
        $requete_casting->execute(["id"=> $id]);


        require "view/detailsFilm.php";
    }

    public function detailsReal($id) {

        $pdo = Connect::seConnecter(); 
        $requete_details = $pdo->prepare("
            SELECT CONCAT(p.prenom, ' ', p.nom) as 'nom_complet', p.sexe, 
            DATE_FORMAT(p.date_naissance,'%d/%m/%Y') AS 'naissance'
            FROM realisateur r 
            INNER JOIN personne p ON r.id_personne = p.id_personne
            WHERE r.id_realisateur = :id
        ");
        $requete_details->execute(["id"=> $id]);

        $requete_filmo = $pdo->prepare("
            SELECT f.titre_film, date_format(f.date_sortie_film,'%Y') AS 'Sortie_FR', f.id_film
            FROM film f
            WHERE f.id_realisateur = :id
            ORDER BY f.date_sortie_film DESC
        ");
        $requete_filmo->execute(["id"=> $id]);

        require "view/detailsReal.php";
    }

    public function detailsActeur($id) {

        $pdo = Connect::seConnecter(); 
        $requete_details = $pdo->prepare("
            SELECT CONCAT(p.prenom, ' ', p.nom) as 'nom_complet', p.sexe, 
            DATE_FORMAT(p.date_naissance,'%d/%m/%Y') AS 'naissance'
            FROM acteur a 
            INNER JOIN personne p ON a.id_personne = p.id_personne
            WHERE a.id_acteur = :id
        ");
        $requete_details->execute(["id"=> $id]);

        $requete_filmo = $pdo->prepare("
        SELECT f.titre_film, date_format(f.date_sortie_film,'%Y') AS 'Sortie_FR', f.id_film
        FROM interpreter i
        INNER JOIN film f ON i.id_film = f.id_film
        WHERE i.id_acteur = :id
        ORDER BY f.date_sortie_film DESC
        ");
        $requete_filmo->execute(["id"=> $id]);

        require "view/detailsActeur.php";
    }

    public function home() {
        require "view/home.php";
    }


}







?>