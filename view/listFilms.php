<?php ob_start(); ?> 

<p class="compteur"><?= $requete->rowCount() ?> films en base de données </p> <!-- "?=" est un raccourci pour "? php echo" -->
<div class="enveloppe_listefilms">
    <table class="liste_films">
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
                        <td class ="dates"><?= $film["Sortie_FR"]?></td>
                    </tr>
            <?php } ?>
        </tbody>
    </table>


    <form action="index.php?action=addFilm" method="post" class="formulaire_films">
        <h3>Ajouter un film à la base de données</h3>
        <p>
            <label>
                Titre du film :
                <input type="text" name="titre_film" class="champ_txt">
            </label>
        </p>
        <p>
            <label>
                Réalisateur :
                <select id="real_film" name="real_film" class="champ_txt">
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
                <select id="genres_film" name="genres_film[]" class="champ_txt" multiple >
                <?php foreach($requete_all_genres->fetchAll() as $genre){?>
                    <option value="<?= $genre['id_genre'] ?>"><?= $genre["libelle_genre"]?></option>
                <?php } ?>
                </select>
            </label>
        </p>
        <p>
            <label>
                Durée du film (en minutes) : 
                <input type="number" name="duree_film" min="1" class="champ_txt">
            </label>
        </p>
        <p>
            <label>
                Date de sortie en France : 
                <input type="date" name="date_sortie_film" class="champ_txt">
            </label>
        </p>
        <p>
            <label>
                Note /5 : 
                <input type="number" name="note_film" min="0" max="5" class="champ_txt">
            </label>
        </p>
        <p>
            <label>
                Résumé du film : <br>
                <textarea id="resume_film" name="resume_film" rows="6" class="champ_txt"></textarea>
            </label>
        </p>

        <div class="submit_wrapper">
            <input type="submit" name="submit" value="Valider" class="submit">
        </div>
        
    </form>

</div>


<?php

$titre ="Liste des films";
$titre_secondaire = "Liste des films";
$contenu = ob_get_clean(); //on aspire tout ce qu'il y a entre ob_start et ob_get_clean et on le stocke dans une variable $contenu
require "view/template.php"; //on injecte le tableau dans le template "squelette"
//on aura dans template.php des variables qui vont accueillir les éléments provenant des vues
//dans chaque vue on donne une valeur à $titre et à $titre_secondaire car dans template.php on fera référence aux variables seulement
?>