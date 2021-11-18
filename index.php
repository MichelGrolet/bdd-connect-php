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
<h1>Connection</h1>
<p>Pas de compte ? <a href="inscription.php">S'inscrire</a></p>
    <?php
    $bdd = new PDO('mysql:host=localhost;dbname=users;charset=utf8', 'root', '');
    if (isset($_POST['login'], $_POST['motDePasse'])) {
        $req = $bdd->prepare('SELECT * FROM USERS WHERE username = ? AND password = ?');
        $req->execute([$_POST['login'], $_POST['motDePasse']]);
        $donnees = $req->fetch(PDO::FETCH_ASSOC);
        if (!empty($donnees)) {
            echo "connecté, redirection sur votre profil...";
            $_SESSION['username'] = $donnees['username'];
            $_SESSION['name'] = $donnees['name'];
	        $_SESSION['surname'] = $donnees['surname'];
            // si resterConnecte est coché on crée un cookie avec les informations de connection
            if (isset($_POST['resterConnecte'])) {
                setcookie('username', $donnees['username'], time() + 365*24*3600, null, null, false, true);
                setcookie('password', $donnees['password'], time() + 365*24*3600, null, null, false, true);
            } else {
                if (isset($_COOKIE['username'], $_COOKIE['password'])) {
                    unset($_COOKIE['username'], $_COOKIE['password']);
                }
            }
            header('location: profil.php', true, 301);
        } else {
            echo '<p>Identifiants incorrects</p>';
        }
    } else {
	    echo '<p>Tous les champs sont obligatoires !</p>';
    }
    ?>

    <form action="index.php" method="post">
      <label for="login">Nom d'utilisateur</label><input type="text" name="login" value="<?php echo isset($_COOKIE['username'])? $_COOKIE['username'] : ''; ?>" placeholder="login" id="login" /><br />
      <label for="motDePasse">Mot de passe</label><input type="password" name="motDePasse" value="<?php echo isset($_COOKIE['password'])? $_COOKIE['password'] : ''; ?>" placeholder="Mot de passe" id="motDePasse"/><br />
      <label for="resterConnecte">Rester connecté ?</label><input type="checkbox" name="resterConnecte" id="resterConnecte" <?php echo isset($_COOKIE['username']) ? "checked" : "";?>/><br />
      <input type="submit" name="connexion" value="envoyer"/>
    </form>

    <p><strong>Ce site web utilise des cookies.</strong></p>
</body>
</html>