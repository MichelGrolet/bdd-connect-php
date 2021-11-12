<?php

$bdd = new PDO(
	'mysql:host=localhost;dbname=users;charset=utf8',
	'root',
	''
);

if (isset($_POST['login'], $_POST['motDePasse'])) {
	$req = $bdd->prepare('SELECT name, surname FROM USERS WHERE username = ? AND password = ?');
	$req->execute([$_POST['login'], $_POST['motDePasse']]);
	$donnees = $req->fetchAll(PDO::FETCH_ASSOC);
	if (!empty($donnees)) {
		echo "connecté";
	} else {
        echo "mauvais mdp";
    }
}

?>
<form action="connection.php" method="post">
  <label for="login">Login</label><input type="text" name="login" value="<?php echo isset($_COOKIE['login'])? $_COOKIE['login'] : ''; ?>" placeholder="login" id="login" /><br />
  <label for="motDePasse">Mot de passe</label><input type="password" name="motDePasse" value="<?php echo isset($_COOKIE['motDePasse'])? $_COOKIE['motDePasse'] : ''; ?>" placeholder="Mot de passe" id="motDePasse"/><br />
  <label for="resterConnecte">Rester connecté ?</label><input type="checkbox" name="resterConnecte" id="resterConnecte" <?php echo isset($_COOKIE['login']) ? "checked" : "";?>/><br />
  <input type="hidden" name="token_connexion" value="<?php echo $_SESSION['token'];?>" />
  <input type="submit" name="connexion" value="envoyer"/>
</form>