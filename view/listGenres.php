<?php ob_start(); ?> 

<p class="compteur"><?= $requete->rowCount() ?> genres en base de données</p> <!-- "?=" est un raccourci pour "? php echo" -->

<div class="enveloppe_listeform">

<table class="liste_simple">
    <thead>
        <tr>
            <th>Genres</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($requete->fetchAll() as $genre){ ?>
                <tr>
                    <td><a href="index.php?action=detailsGenre&id=<?= $genre['id_genre']?>"><?= $genre["libelle_genre"]?></a></td>
                </tr>
        <?php } ?>
    </tbody>
</table>

<form action="index.php?action=addGenre" method="post" class ="formulaire">
    <h3>Ajouter un genre</h3>
    <p>
        <label>
            Intitulé du genre  : <br>
            <input type="text" name="libelle_genre" class="champ_txt">
        </label>
    <p>
        <input type="submit" name="submit" value="Valider" class="submit">
    </p>
    
</form>

<?php

$titre ="Liste des genres";
$titre_secondaire = "Liste des genres";
$contenu = ob_get_clean(); //on aspire tout ce qu'il y a entre ob_start et ob_get_clean et on le stocke dans une variable $contenu
require "view/template.php"; //on injecte le tableau dans le template "squelette"
//on aura dans template.php des variables qui vont accueillir les éléments provenant des vues
//dans chaque vue on donne une valeur à $titre et à $titre_secondaire car dans template.php on fera référence aux variables seulement
?>