<?php ob_start(); ?> 

<p>Il y a <?= $requete->rowCount() ?> realisateurs.trices </p> <!-- "?=" est un raccourci pour "? php echo" -->

<table>
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
                    <td><?= $real["date_naiss_real"]?></td>
                </tr>
        <?php } ?>
    </tbody>
</table>

<?php

$titre ="Liste des réalisateurs.trices";
$titre_secondaire = "Liste des réalisateurs.trices";
$contenu = ob_get_clean(); //on aspire tout ce qu'il y a entre ob_start et ob_get_clean et on le stocke dans une variable $contenu
require "view/template.php"; //on injecte le tableau dans le template "squelette"
//on aura dans template.php des variables qui vont accueillir les éléments provenant des vues
//dans chaque vue on donne une valeur à $titre et à $titre_secondaire car dans template.php on fera référence aux variables seulement
?>