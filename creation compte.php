<?php
session_start(); // Assurez-vous que la session est démarrée
require_once('BDD.php'); // Inclusion de la connexion à la BDD

if(isset($_POST['ok'])){
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];

    // Vérifier si l'email existe déjà
    $check = $bdd->prepare("SELECT * FROM compte WHERE email = :email");
    $check->execute(array("email" => $email));
    if($check->rowCount() > 0){
        echo "<script>alert('Cet email est déjà utilisé !');</script>";
    } else {
        // Insérer l'utilisateur
        $requete = $bdd->prepare("INSERT INTO compte (nom, prenom, email, mdp) VALUES (:nom, :prenom, :email, :mdp)");
        $requete->execute(array(
            "nom" => $nom,
            "prenom" => $prenom,
            "email" => $email,
            "mdp" => $mdp,
        ));

        // Récupérer l'ID de l'utilisateur nouvellement inséré
        $id_user = $bdd->lastInsertId();

        // Stocker l'ID de l'utilisateur et le prenom dans la session
        $_SESSION['compte_id'] = $compte_id;
        $_SESSION['prenom'] = $prenom;
        $_SESSION['nom'] = $nom;

        header("Location: index.php");
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création de compte</title>
    <link rel="stylesheet" href="mode.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body class="bg-info-subtle">
    
    <div class="theme-toggle">
        <button id="theme-toggle-btn" class="btn btn-outline-secondary">
            <span id="icon" class="icon">🌙</span> <!-- Icône de lune par défaut -->
        </button>
    </div>

    <div class="d-flex h-100 justify-content-around align-items-center min-vh-100 ">
        <form class="w-25" action="creation compte.php" method="POST">
            <div class="theme-div rounded shadow bg-white p-4 ">
                <h2>Créer un compte</h2>

                <label class="form-label" for="nom">Nom</label>
                <input class="form-control mb-3 type="text" id="nom" name="nom" required>

                <label class="form-label" for="prenom">Prénom</label>
                <input class="form-control mb-3 type="text" id="prenom" name="prenom" required>

                <label class="form-label" for="email">Email</label>
                <input class="form-control mb-3 type="email" id="email" name="email" required>

                <label class="form-label" for="mdp">Mot de passe</label>
                <input class="form-control mb-3 type="password" id="mdp" name="mdp" required>

                <button type="submit" class="btn btn-success" name="ok">Créer un compte</button>
                <p class="signup-text">Vous avez déjà un compte ? <a href="index.php">Se connecter</a></p>
            </div>
            
        </form>
    </div>
    <script src="bouton.js"></script>
    <script src="fonction.js"></script>
</body>
</html>
