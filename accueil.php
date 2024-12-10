<?php
session_start(); // Démarre la session
require('BDD.php'); // Connexion à la base de données


// Vérifie si l'utilisateur est connecté
if (isset($_SESSION['compte_id'])) {
    $compte_id = $_SESSION['compte_id'];

    // Charger le prénom associé au compte
    $stmt = $bdd->prepare("SELECT prenom FROM compte WHERE compte_id = :compte_id");
    $stmt->execute(['compte_id' => $compte_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $prenom = $result['prenom'] ?? "Invité"; // Par défaut, "Invité" si aucun prénom trouvé
    $_SESSION['prenom'] = $prenom; // Mettez à jour la session si nécessaire
} else {
    header("Location: index.php"); // Redirige vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}

// Récupérer les formulaires liés à l'utilisateur connecté
$stmt = $bdd->prepare("SELECT * FROM contrats WHERE compte_id = :compte_id");
$stmt->execute(['compte_id' => $compte_id]);
$formulaires = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'Accueil</title>
    <link rel="stylesheet" href="mode.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-info-subtle text-light-mode">

    <div class="theme-toggle">
        <button id="theme-toggle-btn" class="btn btn-outline-secondary">
            <span id="icon" class="icon">🌙</span> <!-- Icône de lune par défaut -->
        </button>
    </div>

    <!-- Bouton "Se déconnecter" en haut à gauche -->
    <div class="position-absolute top-0 start-0 m-3">
        <form action="index.php" method="get" style="display: inline;">
            <input type="submit" class="btn btn-dark" value="Se déconnecter">
        </form>
    </div>

    <?php
        if (isset($_SESSION['alert'])) {
            echo "
            <div id='alertMessage' class='alert alert-success' style='position:fixed; top:10px; right:10px; z-index:1000;'>
                " . htmlspecialchars($_SESSION['alert']) . "
            </div>
            <script>
                // Attendre 2 secondes (2000 ms) avant de cacher le message
                setTimeout(function() {
                    var alertElement = document.getElementById('alertMessage');
                    if (alertElement) {
                        alertElement.style.display = 'none';
                    }
                }, 2000);
            </script>";
            unset($_SESSION['alert']); // Supprimer le message après affichage
        }
    ?>

    <!-- Contenu principal centré -->
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div id="custom-element" class="align-items-center rounded shadow bg-white p-4">
            <h1>Bonjour <?php echo $prenom; ?> !</h1>
            <br>
            <form action="formulaire1.php" method="get" style="display: inline;">
                <input type="submit" class="btn btn-secondary mb-3" value="Nouveau formulaire">
            </form>
            <form action="creation_partenaires.php" method="get" style="display: inline;">
                <input type="submit" class="btn btn-secondary mb-3" value="Mes partenaires">
            </form>

            <h2>Vos Formulaires</h2>
            <ul style="list-style: none; padding: 0;">
                <?php if (!empty($formulaires)): ?>
                    <?php foreach ($formulaires as $index => $formulaire): ?>
                        <li class="d-flex align-items-center justify-content-between mb-2">
                            <!-- Nom du formulaire -->
                            <span>Formulaire <?php echo $index + 1; ?> </span>

                            <!-- Tiret séparateur -->
                            <span class="mx-2">-</span>

                            <!-- Boutons d'action -->
                            <div class="d-flex gap-2">
                                <!-- Formulaire pour "Voir" -->
                                <form action="afficher.php" method="GET" style="display: inline;">
                                    <input type="hidden" name="contrat_id" value="<?php echo $formulaire['contrat_id']; ?>">
                                    <input type="submit" class="btn btn-success btn-sm" value="Afficher">
                                </form>

                                <!-- Formulaire pour "Modifier" -->
                                <form action="edit.php" method="GET" style="display: inline;">
                                    <input type="hidden" name="contrat_id" value="<?php echo $formulaire['contrat_id']; ?>">
                                    <input type="submit" class="btn btn-warning btn-sm" value="Modifier">
                                </form>

                                <!-- Formulaire pour "Supprimer" -->
                                <form action="delete.php" method="GET" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce formulaire ?');">
                                    <input type="hidden" name="contrat_id" value="<?php echo $formulaire['contrat_id']; ?>">
                                    <input type="submit" class="btn btn-danger btn-sm" value="Supprimer">
                                </form>
                            </div>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Vous n'avez aucun formulaire</p>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <!-- Lien vers Bootstrap JS (facultatif) -->
    <script src="bouton.js"></script>
    <script src="fonction.js" ></script>
</body>
</html>
