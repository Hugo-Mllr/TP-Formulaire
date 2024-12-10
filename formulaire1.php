<?php
session_start();
require('BDD.php'); // Connexion à la base de données

// Traitement des données du formulaire lorsque la méthode POST est utilisée
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nb_partenaires'])) {
        $nb_partenaires = intval($_POST['nb_partenaires']); // Convertit la valeur en entier

        // Stocker la valeur dans la session
        $_SESSION['nb_partenaires'] = $nb_partenaires;

        // Redirection vers la page suivante (formulaire2.php)
        header("Location: formulaire2.php");
        exit();
    } 
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nombre de Partenaires</title>
    <link rel="stylesheet" href="mode.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-info-subtle">

    <div class="theme-toggle">
        <button id="theme-toggle-btn" class="btn btn-outline-secondary">
            <span id="icon" class="icon">🌙</span> <!-- Icône de lune par défaut -->
        </button>
    </div>

    <div class="d-flex justify-content-center align-items-center min-vh-100 ">
        <div class="w-25"> 
            <form action="formulaire1.php" method="POST" class="bg-white p-4 rounded shadow">
                <div class="mb-3">
                    <label for="nb_partenaires" class="form-label">Nombre de partenaires</label>
                    <input type="number" class="form-control" id="nb_partenaires" name="nb_partenaires" min="0" max="5" required>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="accueil.php" class="btn btn-dark">Accueil</a>
                    <button type="submit" class="btn btn-primary">Suivant</button>
                </div>
            </form>
        </div>
    </div>
    <script src="fonction.js"></script>
    <script src="bouton.js"></script>
</body>
</html>

