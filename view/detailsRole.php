<?php 
ob_start(); 
$nomrole = $requete_details->fetch();

?> 

<div class="enveloppe_listeform">
    <table class="liste_triple">
        <thead>
            <tr>
                <th>Interprète</th>
                <th>Film</th>
                <th>Sortie FR</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($requete_filmo->fetchAll() as $role){ ?>
                    <tr>
                        <td><a href="index.php?action=detailsActeur&id=<?= $role["id_acteur"]?>"><?= $role["nom_complet"]?></a></td>
                        <td><a href="index.php?action=detailsFilm&id=<?= $role["id_film"]?>"><?= $role["titre_film"]?></a></td>
                        <td><?= $role["Sortie_FR"]?></td>
                    </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php

$titre ="Liste des interprètes de ".$nomrole['nom_role'];
$titre_secondaire = "Liste des interprètes de ".$nomrole['nom_role'];
$contenu = ob_get_clean(); //on aspire tout ce qu'il y a entre ob_start et ob_get_clean et on le stocke dans une variable $contenu
require "view/template.php"; //on injecte le tableau dans le template "squelette"
//on aura dans template.php des variables qui vont accueillir les éléments provenant des vues
//dans chaque vue on donne une valeur à $titre et à $titre_secondaire car dans template.php on fera référence aux variables seulement
?>