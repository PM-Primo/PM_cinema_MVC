<?php ob_start(); ?> 

<p>Il y a <?= $requete->rowCount() ?> films </p> <!-- "?=" est un raccourci pour "? php echo" -->

<table>
    <thead>
        <tr>
            <th>Titre</th>
            <th>Sortie FR</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($requete->fetchAll() as $film){ ?>
                <tr>
                    <td><a href="index.php?action=detailsFilm&id=<?= $film['id_film']?>"><?= $film["titre_film"]?></a></td>
                    <td><?= $film["Sortie_FR"]?></td>
                </tr>
        <?php } ?>
    </tbody>
</table>


<form action="index.php?action=addFilm" method="post">
    <p>Ajouter un film à la base de données</p>
    <p>
        <label>
            Titre du film : <br>
            <input type="text" name="titre_film">
        </label>
    </p>
    <p>
        <label>
            Réalisateur : <br>
            <select id="real_film" name="real_film">
                <!-- Créer une requête qui va chercher la liste des reals & leurs id & l'appeler ici avec un foreach -->
                <?php foreach($requete_reals->fetchAll() as $real){?>
                    <option value="<?= $real['id_realisateur'] ?>"><?= $real["nom_complet"]?></option>
                <?php } ?>
            </select>
        </label>
    </p>
    <p>
        <label>
            Genre(s) : <br>
            <select id="genres_film" name="genres_film[]" multiple>
            <?php foreach($requete_all_genres->fetchAll() as $genre){?>
                <option value="<?= $genre['id_genre'] ?>"><?= $genre["libelle_genre"]?></option>
            <?php } ?>
            </select>
        </label>
    </p>
    <p>
        <label>
            Durée du film (en minutes) : <br>
            <input type="number" name="duree_film" min="1">
        </label>
    </p>
    <p>
        <label>
            Date de sortie en France : <br>
            <input type="date" name="date_sortie_film">
        </label>
    </p>
    <p>
        <label>
            Note /5 : <br>
            <input type="number" name="note_film" min="0" max="5">
        </label>
    </p>
    <p>
        <label>
            Résumé du film : <br>
            <textarea id="resume_film" name="resume_film" rows="6" cols="60"></textarea>
        </label>
    </p>


    <input type="submit" name="submit" value="Valider">
    
</form>


<?php

$titre ="Liste des films";
$titre_secondaire = "Liste des films";
$contenu = ob_get_clean(); //on aspire tout ce qu'il y a entre ob_start et ob_get_clean et on le stocke dans une variable $contenu
require "view/template.php"; //on injecte le tableau dans le template "squelette"
//on aura dans template.php des variables qui vont accueillir les éléments provenant des vues
//dans chaque vue on donne une valeur à $titre et à $titre_secondaire car dans template.php on fera référence aux variables seulement
?>