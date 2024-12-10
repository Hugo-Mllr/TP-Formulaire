<?php
session_start(); // Démarre la session au début
require('BDD.php'); // Connexion à la base de données

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];

    // Requête pour vérifier si l'e-mail existe et récupérer les informations de l'utilisateur
    $stmt = $bdd->prepare("SELECT compte_id, mdp FROM compte WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérification du mot de passe
        if ($mdp === $utilisateur['mdp']) {
            // Récupérer le prénom de l'utilisateur
            $detailsUtilisateur = $bdd->prepare("SELECT prenom FROM compte WHERE compte_id = :compte_id");
            $detailsUtilisateur->execute(['compte_id' => $utilisateur['compte_id']]);
            $userDetails = $detailsUtilisateur->fetch(PDO::FETCH_ASSOC);

            // Connexion réussie : stockage des informations dans la session
            $_SESSION['compte_id'] = $utilisateur['compte_id'];
            $_SESSION['prenom'] = $userDetails['prenom'] ?? "Invité";

            // Redirection vers la page d'accueil
            header("Location: accueil.php");
            exit();
        } else {
            echo "<script>alert('Mot de passe incorrect');</script>";
        }
    } else {
        echo "<script>alert('Email non trouvé.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Connexion</title>
    <link rel="stylesheet" href="mode.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body class="bg-info-subtle text-light-mode">

    <div class="theme-toggle">
        <button id="theme-toggle-btn" class="btn btn-outline-secondary">
            <span id="icon" class="icon">🌙</span> <!-- Icône de lune par défaut -->
        </button>
    </div>

    <div class="d-flex h-100 justify-content-around align-items-center min-vh-100">
        <form class="w-25" action="index.php" method="POST">
            <div class="theme-div rounded shadow bg-white p-4">
                <h2>Connexion</h2>

                <label class="form-label" for="email">Email</label>   
                <input class="form-control mb-3" type="email" id="email" name="email" required>
                   
                <label class="form-label" for="mdp">Mot de passe</label>   
                <input class="form-control mb-3" type="password" id="mdp" name="mdp" required>

                <button type="submit" class="btn btn-success">Connexion</button>
                <p class="signup-text">Vous n'avez pas de compte ? <a href="creation compte.php">Créer un compte</a></p>
            </div>    
        </form>
    </div>

    <script src="bouton.js"></script>
</body>
</html>
