<?php ob_start(); ?> 

<p class="compteur"><?= $requete->rowCount() ?> acteurs.trices en base de données</p> <!-- "?=" est un raccourci pour "? php echo" -->

<!-- affichage de la liste des acteurs.trices -->

<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Date de naissance</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($requete->fetchAll() as $acteur){ ?>
                <tr>
                    <td><a href="index.php?action=detailsActeur&id=<?= $acteur['id_acteur']?>"><?= $acteur["nom_complet"]?></a></td>
                    <td><?= $acteur["date_naiss_act"]?></td>
                </tr>
        <?php } ?>
    </tbody>
</table>

<!-- Formulaire d'ajout des acteurs.trices -->

<form action="index.php?action=addActeur" method="post">
    <p>Ajouter un.e acteur.trice à la base de données</p>
    <p>
        <label>
            Nom : <br>
            <input type="text" name="nom_acteur">
        </label>
    </p>
    <p>
        <label>
            Prénom : <br>
            <input type="text" name="prenom_acteur">
        </label>
    </p>
    <p>
        <label>
            Genre : <br>
            <select id="sexe_acteur" name="sexe_acteur">
                <option value="Homme">Homme</option>
                <option value="Femme">Femme</option>
                <option value="Autre">Autre</option>
            </select>
        </label>
    </p>
    <p>
        <label>
            Date de naissance : <br>
            <input type="date" name="date_naissance_acteur">
        </label>
    </p>
    <p>
        <label>
            <input type="checkbox" id="acteur_real" name="acteur_real">
            <label for="acteur_real">Cet.te acteur.trice est également réalisateur.trice</label>
        </label>
    </p>

    <input type="submit" name="submit" value="Valider">
    
</form>


<?php

$titre ="Liste des acteurs.trices";
$titre_secondaire = "Liste des acteurs.trices";
$contenu = ob_get_clean(); //on aspire tout ce qu'il y a entre ob_start et ob_get_clean et on le stocke dans une variable $contenu
require "view/template.php"; //on injecte le tableau dans le template "squelette"
//on aura dans template.php des variables qui vont accueillir les éléments provenant des vues
//dans chaque vue on donne une valeur à $titre et à $titre_secondaire car dans template.php on fera référence aux variables seulement
?>