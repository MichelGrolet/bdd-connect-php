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
	<?php
        // changement du nom et du prenom dan la bdd
        if(isset($_POST['name']) || isset($_POST['surname'])){
            $prenom = $_POST['surname'];
            $nom = $_POST['name'];
            $id = $_SESSION['username'];
	        $bdd = new PDO('mysql:host=localhost;dbname=users;charset=utf8', 'root', '');
            $req = $bdd->prepare('UPDATE users SET surname = :surname, name = :name WHERE username = :id');
            $req->execute(array(
                'surname' => $prenom,
                'name' => $nom,
                'id' => $id
            ));
            $_SESSION['name'] = $nom;
            $_SESSION['surname'] = $prenom;
            echo "nom et prénom changés !";
            header('location: profil.php');
        }
	?>

	<form action="editprofil.php" method="post">
		<label for="name">Nouveau nom :</label><input type="text" name="name" placeholder="login" id="login" /><br />
		<label for="surname">Nouveau prenom :</label><input type="text" name="surname" placeholder="Mot de passe" id="motDePasse"/><br />
		<input type="submit" name="Modifier le profil" value="submit"/>
	</form>
</body>
</html>