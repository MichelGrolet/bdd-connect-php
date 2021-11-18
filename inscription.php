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
<h1>Inscription</h1>
<p>Déjà inscrit ? <a href="index.php">Se connecter</a></p>
<?php
if (isset($_POST['login'], $_POST['motDePasse'], $_POST['motDePasse2'], $_POST['name'], $_POST['surname'])) {
	$bdd = new PDO('mysql:host=localhost;dbname=users;charset=utf8', 'root', '');
	$req = $bdd->prepare('SELECT * FROM USERS WHERE username = ?');
	$req->execute([$_POST['login']]);
	$donnees = $req->fetch(PDO::FETCH_ASSOC);
	if (!empty($donnees)) {
		echo "ce nom d'utilisateur existe déjà !";
		$_SESSION['username'] = $donnees['username'];
		$_SESSION['name'] = $donnees['name'];
		$_SESSION['surname'] = $donnees['surname'];
		header('location: profil.php', true, 301);
	} else {
		if ($_POST['motDePasse']!=$_POST['motDePasse2']) {
            echo "les mots de passe ne correspondent pas !";
        } else {
            $req = $bdd->prepare('INSERT INTO USERS(username, password, name, surname) VALUES(?, ?, ?, ?)');
            $req->execute([$_POST['login'], $_POST['motDePasse'], $_POST['name'], $_POST['surname']]);
            echo "inscription réussie !";
            $_SESSION['username'] = $_POST['login'];
            $_SESSION['name'] = $_POST['name'];
            $_SESSION['surname'] = $_POST['surname'];
            header('location: profil.php', true, 301);
        }
	}
}
?>

<form action="inscription.php" method="post">
	<label for="login">Nom d'utilisateur</label><input type="text" name="login" placeholder="login" id="login" /><br />
	<label for="motDePasse">Mot de passe</label><input type="password" name="motDePasse" placeholder="Mot de passe" id="motDePasse"/><br />
	<label for="motDePasse2">Confirmation du mot de passe</label><input type="password" name="motDePasse2" placeholder="Mot de passe" id="motDePasse2"/><br />
	<label for="surname">Prénom</label><input type="text" name="surname" placeholder="Prénom" id="surname"/><br />
	<label for="name">Nom</label><input type="text" name="name" placeholder="Nom" id="name"/><br />
	<input type="submit" name="inscription" value="envoyer"/>
</form>
</body>
</html>