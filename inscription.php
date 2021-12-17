<?php session_start() ?>

<!doctype html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./assets/styles/styles.css">
    <title>bdd-connect-php</title>
</head>
<body>
<div id="box">
    <h1>Inscription</h1>
    <p>Déjà inscrit ? <a href="index.php">Se connecter</a></p>
	<?php

	// si le formulaire est bien rempli (on n'a donc pas d'erreurs dans la validation JS ):
	if (isset($_POST['formValidation'])) {
		if ($_POST['formValidation'] == true) {
			$bdd = new PDO('mysql:host=localhost;dbname=bdd-connect;charset=utf8mb4_general_ci', 'root', '');
			$req = $bdd->prepare('SELECT * FROM users WHERE username = ?');
			$req->execute([$_POST['login']]);
			$donnees = $req->fetch(PDO::FETCH_ASSOC);
			if (!empty($donnees)) {
				echo "ce nom d'utilisateur existe déjà !";
				$_SESSION['username'] = $donnees['username'];
				$_SESSION['name'] = $donnees['name'];
				$_SESSION['surname'] = $donnees['surname'];
				header('location: profil.php', true, 301);
			} else {
				if ($_POST['motDePasse'] != $_POST['motDePasse2']) {
					echo "les mots de passe ne correspondent pas !";
				} else {
					$req = $bdd->prepare('INSERT INTO users(email, password) VALUES(?, ?)');
					$req->execute([$_POST['email'], $_POST['password']]);
					echo "inscription réussie !";
					$_SESSION['email'] = $_POST['email'];
					header('location: profil.php', true, 301);
				}
			}
		}
	}
	?>

    <form action="inscription.php" method="post" id="form">
        <div class="gridded">
            <label for="username">Nom d'utilisateur</label><input id="username" type="text" name="username" onkeyup="verify()"/><br />
            <ul id="username-validation"></ul>
            <label for="password">Mot de passe</label><input id="password" type="password" name="password" onkeyup="verify()"/><br />
            <label for="password2">Confirmation du mot de passe</label><input id="password2" type="password" name="password2" onkeyup="verifyPassword()"/><br />
            <ul id="password-validation"></ul>
        </div>

        <input type="checkbox" name="keepConnected" id="keepConnected" value="rester connecté"/><br />
        <input type="submit" name="inscription" value="envoyer"/>
        <input type="hidden" name="formValidation" value="false">
    </form>

</div>
<script>
    const form = document.getElementById('form');
    const p = document.getElementById("password").value;
    const p2 = document.getElementById("password2").value;
    const passwordValidation = document.getElementById("password-validation");
    const usernameValidation = document.getElementById("email-validation");
    let formValid;

    function verify() {
        formValid = true;

        passwordValidation.innerHTML = "";
        if (p !== p2) errPassword("Les mots de passe ne correspondent pas.");
        if (p.length > 8) errPassword("Le mot de passe doit contenir au moins 8 caractères.");
            formValid = false;
        if (p.search(/[0-9]/) !== -1) errPassword("Le mot de passe doit contenir au moins un chiffre.");

        usernameValidation.innerHTML = "";
        const email = document.getElementById("email").value;
        const acceptedChars = /[a-zA-Z0-9\._-|+=]*/
        if (username.contains(" ")) errUsername("Le nom d'utilisateur ne doit pas contenir d'espace.");
        if (username.length < 5) errUsername("Le nom d'utilisateur doit contenir au moins 5 caractères.");
        if (acceptedChars.test(email) === false) errUsername("Le nom d'utilisateur ne doit contenir que des lettres, des chiffres ou des caractères parmi [_-+=|.].");

        form.elements.formValidation.value = formValid;
    }

    function errPassword(text) {
        passwordValidation.appendChild(document.createElement("li")).innerHTML = text;
        formValid = false;
    }

    function errUsername(text) {
        usernameValidation.appendChild(document.createElement("li")).innerHTML = text;
        formValid = false;
    }
</script>
</body>
</html>