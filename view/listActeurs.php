<?php ob_start(); ?> 

<p>Il y a <?= $requete->rowCount() ?> acteurs.trices </p> <!-- "?=" est un raccourci pour "? php echo" -->

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
                    <td><?= $acteur["nom_complet"]?></td>
                    <td><?= $acteur["date_naiss_act"]?></td>
                </tr>
        <?php } ?>
    </tbody>
</table>

<?php

$titre ="Liste des films";
$titre_secondaire = "Liste des films";
$contenu = ob_get_clean(); //on aspire tout ce qu'il y a entre ob_start et ob_get_clean et on le stocke dans une variable $contenu
require "view/template.php"; //on injecte le tableau dans le template "squelette"
//on aura dans template.php des variables qui vont accueillir les éléments provenant des vues
//dans chaque vue on donne une valeur à $titre et à $titre_secondaire car dans template.php on fera référence aux variables seulement
?>