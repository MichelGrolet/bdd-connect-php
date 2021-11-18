<?php session_start() ?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>bdd-connect-php</title>
</head>
<body>
<h1>Bienvenue, <?php echo $_SESSION['username'] ?></h1>
<ul>
    <li>Prénom : <?php echo $_SESSION['surname'] ?></li>
    <li>Nom : <?php echo $_SESSION['name'] ?></li>
</ul>

<a href="editprofil.php">Éditer mon profil</a>
<a href="logout.php">Se déconnecter</a>

</body>
</html>