<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href = "public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <title><?= $titre ?></title>
</head>
<body>
    <nav>
    <ul>
        <li><a href="index.php?action=listFilms">Films</a></li>
        <li><a href="index.php?action=listActeurs">Acteurs</a></li>
        <li><a href="index.php?action=listReals">Réalisateurs</a></li>
        <li><a href="index.php?action=listGenres">Genres</a></li>
        <li><a href="index.php?action=listRoles">Rôles</a></li>

    </ul>
    </nav>    
    <div id="wrapper">
        <main>
            <div id="contenu">
                <h1>PDO Cinema</h1>
                <h2><?= $titre_secondaire ?></h2>
                <?= $contenu ?>
            </div>
        </main>
    </div>
</body>
</html>