<?php

namespace Controller;
use Model\Connect;

class CinemaController{

    // Page d'accueil
    public function home() {
        require "view/home.php";
    }


    // Lister les films
    public function listFilms() {

        $pdo = Connect::seConnecter(); // "::" est comme "->" mais pour des éléments statiques et non des instances de classe
        $requete = $pdo->query("
            SELECT titre_film, date_format(date_sortie_film,'%d/%m/%Y') AS 'Sortie_FR', id_film
            FROM film
            ORDER BY date_sortie_film DESC
        ");

        $requete_reals = $pdo->query("
        SELECT CONCAT(p.prenom, ' ', p.nom) as 'nom_complet', id_realisateur
        FROM realisateur r 
        INNER JOIN personne p ON r.id_personne = p.id_personne
        ORDER BY p.nom ASC
        ");

        $requete_all_genres = $pdo->query("
        SELECT libelle_genre, id_genre
        FROM genre
        ORDER BY libelle_genre ASC
        ");

        require "view/listFilms.php";
    }

    // Lister les acteurs
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

    // Lister les réalisateurs
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

    // Lister les genres
    public function listGenres() {

        $pdo = Connect::seConnecter(); 
        $requete = $pdo->query("
            SELECT libelle_genre, id_genre
            FROM genre
            ORDER BY libelle_genre ASC
        ");
        require "view/listGenres.php";
    }

    // Lister les Rôles
    public function listRoles() {

        $pdo = Connect::seConnecter(); 
        $requete = $pdo->query("
            SELECT r.nom_role, r.id_role
            FROM role r
            ORDER BY r.nom_role
        ");
        require "view/listRoles.php";
    }

    // Infos & casting d'un film
    public function detailsFilm($id) {

        $pdo = Connect::seConnecter(); 

        $requete_details = $pdo->prepare("
            SELECT f.titre_film, date_format(sec_to_time(f.duree_film*60), '%Hh%i') AS duree, 
            date_format(f.date_sortie_film,'%d/%m/%Y') AS 'Sortie_FR', f.note_film, f.resume_film, 
            CONCAT (p.prenom,' ' ,p.nom) AS 'Réalisateur', r.id_realisateur, f.id_film
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

        $requete_genres = $pdo->prepare("
        SELECT g.libelle_genre, cg.id_genre
        FROM categoriser_genre cg
        INNER JOIN genre g ON cg.id_genre = g.id_genre
        WHERE cg.id_film = :id
        ");
        $requete_genres->execute(["id"=> $id]);


        require "view/detailsFilm.php";
    }

    // Infos & filmographie d'un réal
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

    // Infos & filmographie d'un acteur
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

    // Liste des films d'un genre
    public function detailsGenre($id) {

        $pdo = Connect::seConnecter(); 

        $requete_details = $pdo->prepare("
        SELECT libelle_genre
        FROM genre g
        WHERE g.id_genre = :id
        ");
        $requete_details->execute(["id"=> $id]);

        $requete_filmo = $pdo->prepare("
        SELECT f.titre_film, cg.id_film, date_format(f.date_sortie_film,'%d/%m/%Y') AS 'Sortie_FR'
        FROM categoriser_genre cg
        INNER JOIN film f ON cg.id_film = f.id_film
        WHERE cg.id_genre = :id
        ORDER BY f.date_sortie_film DESC
        ");
        $requete_filmo->execute(["id"=> $id]);

        require "view/detailsGenre.php";
    }

    // Liste des acteurs ayant joué un rôle & films correspondants
    public function detailsRole($id) {

        $pdo = Connect::seConnecter(); 

        $requete_details = $pdo->prepare("
        SELECT r.nom_role
        FROM role r
        WHERE r.id_role = :id
        ");
        $requete_details->execute(["id"=> $id]);

        $requete_filmo = $pdo->prepare("
        SELECT CONCAT(p.prenom, ' ', p.nom) AS 'nom_complet', f.titre_film, date_format(f.date_sortie_film,'%Y') AS 'Sortie_FR', a.id_acteur, f.id_film
        FROM interpreter i
        INNER JOIN acteur a ON i.id_acteur = a.id_acteur
        INNER JOIN personne p ON a.id_personne = p.id_personne
        INNER JOIN film f ON i.id_film = f.id_film
        WHERE i.id_role = :id
        ORDER BY f.date_sortie_film DESC
        ");
        $requete_filmo->execute(["id"=> $id]);

        require "view/detailsRole.php";
    }

    // Ajouter un nouveau Genre
    public function addGenre($libelle_genre){

        if($libelle_genre){
            $pdo = Connect::seConnecter();
            
            $requete = $pdo->prepare("
            INSERT INTO genre (libelle_genre)
            VALUES (:lib)
            ");

            $requete->execute(["lib"=> $libelle_genre]);
        }

        header("Location:index.php?action=listGenres");
        
    }

    // public function validateDate($date, $format = 'Y-m-d'){
    //     $d = DateTime::createFromFormat($format, $date);
    //     return $d && $d->format($format) === $date;
    // }

    //FONCTION VALIDATEDATE NE FONCTIONNE PAS ! A VERIFIER

    //Ajouter une nouvelle personne : est appelée dans la création d'acteur ou de réalisateur
    public function newPersonne($nom, $prenom, $sexe, $date_naissance){
        $pdo = Connect::seConnecter();

            //Requête pour créer la personne
            $requete_personne = $pdo->prepare("
            INSERT INTO personne (nom, prenom, sexe, date_naissance)
            VALUES (:nom, :prenom, :sexe, :date)
            ");
            $requete_personne->execute(["nom"=> $nom, "prenom" => $prenom, "sexe"=>$sexe, "date" =>$date_naissance]);

            //Requête pour rechercher l'id personne du nouvel acteur
            $requete_personne_id = $pdo->prepare("
            SELECT p.id_personne
            FROM personne p 
            WHERE p.nom = :nom
            AND p.prenom = :prenom
            AND p.date_naissance = :date
            ");
            $requete_personne_id->execute(["nom"=> $nom, "prenom" => $prenom, "date" =>$date_naissance]);
            $id_personne = $requete_personne_id->fetch();
            return $id_personne[0]; 
    }

    // Ajouter un nouvel Acteur
    public function addActeur($nom_acteur, $prenom_acteur, $sexe_acteur, $date_naissance_acteur, $acteur_real){

        if($nom_acteur && $prenom_acteur && $sexe_acteur && $date_naissance_acteur){
            $pdo = Connect::seConnecter();

            //Appel à la fonction de création de personne
            $id_personne = $this->newPersonne($nom_acteur, $prenom_acteur, $sexe_acteur, $date_naissance_acteur);

            //Requête pour associer la personne à un id acteur
            $requete_acteur = $pdo->prepare("
            INSERT INTO acteur (id_personne)
            VALUES (:idpers)
            ");
            $requete_acteur->execute(["idpers"=> $id_personne]);

            // IF la case est cochée : requête pour associer la personne à un id réalisateur
            if($acteur_real){
                $requete_real = $pdo->prepare("
                INSERT INTO realisateur (id_personne)
                VALUES (:idpers)
                ");
                $requete_real->execute(["idpers"=> $id_personne]);
            };
        }
        header("Location:index.php?action=listActeurs");
    }

    // Ajouter un nouveau Real
    public function addReal($nom_real, $prenom_real, $sexe_real, $date_naissance_real, $acteur_real ){

        if($nom_real && $prenom_real && $sexe_real && $date_naissance_real){
            $pdo = Connect::seConnecter();

            //Appel à la fonction de création de personne
            $id_personne = $this->newPersonne($nom_real, $prenom_real, $sexe_real, $date_naissance_real);

            //Requête pour associer la personne à un id acteur
            $requete_real = $pdo->prepare("
            INSERT INTO realisateur (id_personne)
            VALUES (:idpers)
            ");
            $requete_real->execute(["idpers"=> $id_personne]);

            // IF la case est cochée : requête pour associer la personne à un id acteur
            if($acteur_real){
                $requete_real = $pdo->prepare("
                INSERT INTO acteur (id_personne)
                VALUES (:idpers)
                ");
                $requete_real->execute(["idpers"=> $id_personne]);
            }
        }
        header("Location:index.php?action=listReals");
    }

    public function addFilm($titre_film, $duree_film, $date_sortie_film, $note_film, $resume_film, $real_film, $genres_film){
        if($titre_film && $duree_film && $date_sortie_film && $note_film && $real_film && $genres_film){
            $pdo = Connect::seConnecter();

            $requete_film = $pdo->prepare("
            INSERT INTO film(titre_film, duree_film, date_sortie_film, note_film, resume_film, id_realisateur)
            VALUES (:titre, :duree, :datesortie, :note, :resume, :idreal)
            ");
            $requete_film->execute(["titre"=> $titre_film, "duree" => $duree_film, "datesortie" => $date_sortie_film, "note"=>$note_film, "resume" =>$resume_film, "idreal"=>$real_film ]);
        
            $requete_idfilm = $pdo->prepare("
            SELECT id_film
            FROM film
            WHERE titre_film = :titre
            AND date_sortie_film = :date
            ");
            $requete_idfilm->execute(["titre"=> $titre_film, "date" => $date_sortie_film]);
            $id_film = $requete_idfilm->fetch();
            $id_film = $id_film[0];
            // var_dump($genres_film);
            // die;

            foreach($genres_film as $id_genre){
                $requete_genres = $pdo->prepare("
                INSERT INTO categoriser_genre (id_film, id_genre)
                VALUES (:idfilm, :idgenre) 
                ");
                $requete_genres->execute(["idfilm" => $id_film, "idgenre" => $id_genre]);
            }

        }
        
        header("Location:index.php?action=listFilms");
    }


}



?>