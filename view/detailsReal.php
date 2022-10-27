<?php 
ob_start(); 
$realinfos = $requete_details->fetch();

?> 

<ul>
    <li>Nom complet : <?= $realinfos['nom_complet']?></li>
    <li>Genre : <?= $realinfos['sexe']?></li>
    <li>Date de naissance : <?= $realinfos['naissance']?></li>
</ul>


<h2> Filmographie de <?= $realinfos['nom_complet']?> (réal.)</h2>

<table>
    <thead>
        <tr>
            <th>Film</th>
            <th>Sortie FR</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($requete_filmo->fetchAll() as $film){ ?>
                <tr>
                    <td><a href="index.php?action=detailsFilm&id=<?= $film["id_film"]?>"><?= $film["titre_film"]?></a></td>
                    <td><?= $film["Sortie_FR"]?></td>
                </tr>
        <?php } ?>
    </tbody>
</table>

<?php

$titre ="Biographie de ".$realinfos['nom_complet'];
$titre_secondaire = "Biographie de ".$realinfos['nom_complet'];
$contenu = ob_get_clean(); //on aspire tout ce qu'il y a entre ob_start et ob_get_clean et on le stocke dans une variable $contenu
require "view/template.php"; //on injecte le tableau dans le template "squelette"
//on aura dans template.php des variables qui vont accueillir les éléments provenant des vues
//dans chaque vue on donne une valeur à $titre et à $titre_secondaire car dans template.php on fera référence aux variables seulement
?>