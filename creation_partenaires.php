<?php
session_start();
require('BDD.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nom'])) {
        $sql = "INSERT INTO partenaires (partenaire_nom, partenaire_prenom) VALUES (:nom, :prenom)";
        $stmt = $bdd->prepare($sql);

        $stmt->execute([
            ':nom' => $_POST['nom'],
            ':prenom' => $_POST['prenom']
        ]);
        header("Location: " . $_SERVER['PHP_SELF']);
   } else {
        $sql = "DELETE FROM partenaires WHERE partenaire_id = :id";
        $stmt = $bdd->prepare($sql);
        $stmt->execute([
            ':id' => $_POST['id']
        ]);
   }
};

$sql = "SELECT * FROM partenaires";

$stmt = $bdd->query($sql); // Exécuter la requête
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creation des partenaires</title>
    <link rel="stylesheet" href="form.css">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-info-subtle text-light-mode">

    <div class="theme-toggle">
        <button id="theme-toggle-btn" class="btn position-absolute top-0 end-0">
            <span id="icon" class="icon">🌙</span> <!-- Icône de lune par défaut -->
        </button>
    </div>

    <div class="d-flex h-100 justify-content-around align-items-center rounded shadow p-4" >
        <div class="theme-div w-25 d-flex flex-column justify-content-center align-items-center rounded shadow bg-white p-4" > 
        <?php foreach ($results as $row): ?>

            <div class="d-flex w-100 flex-row align-items-center justify-content-between">
                <p><?php echo $row['partenaire_nom']; ?></p>
                <p><?php echo $row['partenaire_prenom']; ?></p>
                <form class="d-flex align-items-center justify-content-center" action="creation_partenaires.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $row['partenaire_id'];?>">
                    <input type="submit" class="btn btn-danger" value="Supprimer">
                </form>
            </div>

        <?php endforeach; ?>

        </div>

        <div class="theme-div w-25 d-flex flex-column justify-content-center align-items-center rounded shadow bg-white p-4">
            <form  action="creation_partenaires.php" method="POST">
                <label class="form-label" for="prenom">Prénom</label>
                <input class="form-control" type="text" name="prenom" placeholder="Prénom" required>
                
                <label class="form-label mt-3" for="nom">Nom</label>
                <input class="form-control" type="text" name="nom" placeholder="Nom" required>
                <input type="submit" class="btn btn-primary mt-3" value="Envoyer">
                <a href="accueil.php" class=" btn btn-dark mt-3">Accueil</a>
            </form>
            
        </div>
    </div>

    <script src="fonction.js"></script>
    <script src="bouton.js"></script>
</body>
</html>

