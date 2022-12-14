<?php ob_start(); ?> 

<p class="compteur"><?= $requete->rowCount() ?> realisateurs(trices) en base de données</p> <!-- "?=" est un raccourci pour "? php echo" -->

<div class="enveloppe_listeform">

    <table class="liste">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Date de naissance</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($requete->fetchAll() as $real){ ?>
                    <tr>
                        <td><a href="index.php?action=detailsReal&id=<?= $real['id_realisateur']?>"><?= $real["nom_complet"]?></a></td>
                        <td class="dates"><?= $real["date_naiss_real"]?></td>
                    </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Formulaire d'ajout des réalisateurs.trices -->

    <form action="index.php?action=addReal" method="post" class="formulaire">
        <h3>Ajouter un(e) réalisateur(trice) à la base de données</h3>
        <p>
            <label>
                Nom : <br>
                <input type="text" name="nom_real" class="champ_txt">
            </label>
        </p>
        <p>
            <label>
                Prénom : <br>
                <input type="text" name="prenom_real" class="champ_txt">
            </label>
        </p>
        <p>
            <label>
                Genre : <br>
                <select id="sexe_acteur" name="sexe_real" class="champ_txt">
                    <option value="Homme">Homme</option>
                    <option value="Femme">Femme</option>
                    <option value="Autre">Autre</option>
                </select>
            </label>
        </p>
        <p>
            <label>
                Date de naissance : <br>
                <input type="date" name="date_naissance_real" class="champ_txt">
            </label>
        </p>
        <p>
            <label class="case_cocher">
                <input type="checkbox" id="acteur_real" name="acteur_real" >
                <label for="acteur_real">Ce(tte) réalisateur(trice) est également acteur(trice)</label>
            </label>
        </p>

        <div class="submit_wrapper">
            <input type="submit" name="submit" value="Valider" class="submit">
        </div>        
    </form>

</div>

<?php

$titre ="Liste des réalisateurs(trices)";
$titre_secondaire = "Liste des réalisateurs(trices)";
$contenu = ob_get_clean(); //on aspire tout ce qu'il y a entre ob_start et ob_get_clean et on le stocke dans une variable $contenu
require "view/template.php"; //on injecte le tableau dans le template "squelette"
//on aura dans template.php des variables qui vont accueillir les éléments provenant des vues
//dans chaque vue on donne une valeur à $titre et à $titre_secondaire car dans template.php on fera référence aux variables seulement
?>