<?php 
ob_start(); 
$filminfos = $requete_details->fetch();

?> 

<ul>
    <li>Réal. : <a href="index.php?action=detailsReal&id=<?= $filminfos['id_realisateur']?>"><?= $filminfos['Réalisateur']?><a></li>
    <li>Durée : <?= $filminfos['duree']?></li>
    <li>Genre(s) : 
        <?php
            $strGenre = ""; 
            foreach($requete_genres->fetchAll() as $genre){
                $strGenre.="<a href='index.php?action=detailsGenre&id=".$genre['id_genre']."'>".$genre["libelle_genre"]."</a> / ";
            } 
            echo substr($strGenre, 0, -3) ?> 
    </li>

    <li>Sortie FR : <?= $filminfos['Sortie_FR']?></li>
    <li>Note : <?= $filminfos['note_film']?>/5</li>
    <li>Synopsis : <?= $filminfos['resume_film']?></li>
</ul>

<h2>Distribution de <?= $filminfos['titre_film']?></h2>

<table>
    <thead>
        <tr>
            <th>Rôle</th>
            <th>Interprète</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($requete_casting->fetchAll() as $role){ ?>
                <tr>
                    <td><?= $role["nom_role"]?></td>
                    <td><a href="index.php?action=detailsActeur&id=<?=$role["id_acteur"]?>"><?= $role["interprete"]?></a></td>
                </tr>
        <?php } ?>
    </tbody>
</table>

<?php

$titre ="Détails du film ".$filminfos['titre_film'];
$titre_secondaire = "Détails du film ".$filminfos['titre_film'];
$contenu = ob_get_clean(); //on aspire tout ce qu'il y a entre ob_start et ob_get_clean et on le stocke dans une variable $contenu
require "view/template.php"; //on injecte le tableau dans le template "squelette"
//on aura dans template.php des variables qui vont accueillir les éléments provenant des vues
//dans chaque vue on donne une valeur à $titre et à $titre_secondaire car dans template.php on fera référence aux variables seulement
?>