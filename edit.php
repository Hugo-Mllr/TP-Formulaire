<?php 
session_start();
require('BDD.php'); // Connexion à la base de données


// Vérifier si un ID de contrat est passé dans l'URL
if (isset($_GET['contrat_id'])) {
    $contrat_id = $_GET['contrat_id'];
} elseif (isset($_SESSION['compte_id'])) {
    // Récupérer l'ID du contrat le plus récent pour l'utilisateur connecté
    $compte_id = $_SESSION['compte_id'];
    $stmt = $bdd->prepare("SELECT contrat_id FROM contrats WHERE compte_id = :compte_id ORDER BY contrat_date DESC LIMIT 1");
    $stmt->bindParam(':compte_id', $compte_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $contrat_id = $result['contrat_id'];
        echo "L'ID du contrat est : " . $contrat_id;
    } else {
        die("Aucun contrat trouvé pour cet utilisateur.");
    }
} else {
    die("ID du contrat non spécifié.");
}

// Récupérer les détails du contrat pour préremplir le formulaire
$stmt = $bdd->prepare("SELECT * FROM contrats WHERE contrat_id = :contrat_id AND compte_id = :compte_id");
$stmt->execute([':contrat_id' => $contrat_id, ':compte_id' => $_SESSION['compte_id']]);
$contrat = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$contrat) {
    die("Contrat non trouvé ou accès non autorisé.");
}

// Exemple de mise à jour des détails du contrat
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $contrat_nature = $_POST['contrat_nature'];
    $contrat_name = $_POST['contrat_name'];
    $contrat_adresse = $_POST['contrat_adresse'];
    $contrat_date = $_POST['contrat_date'];
    $contrat_repartition = $_POST['contrat_repartition'];
    $contrat_clause_duree = $_POST['contrat_clause_duree'];
    $contrat_juridiction = $_POST['contrat_juridiction'];
    $contrat_lieu = $_POST['contrat_lieu'];
    $contrat_nom_avocat = $_POST['contrat_nom_avocat'];
    $contrat_date_jour = $_POST['contrat_date_jour'];
    $contrat_nb_copie = $_POST['contrat_nb_copie'];
    $contrat_modal_banc = $_POST['contrat_modal_banc'];

    // Vérifier que tous les champs nécessaires sont remplis
    if (empty($contrat_nature) || empty($contrat_name) || empty($contrat_adresse) || empty($contrat_date) ||
        empty($contrat_repartition) || empty($contrat_clause_duree) || empty($contrat_juridiction) || 
        empty($contrat_lieu) || empty($contrat_nom_avocat) || empty($contrat_date_jour) || 
        empty($contrat_nb_copie) || empty($contrat_modal_banc)) {
        die("Veuillez remplir tous les champs du formulaire.");
    }
    
    $stmtUpdate = $bdd->prepare("UPDATE contrats SET contrat_nature = :contrat_nature, contrat_name = :contrat_name, contrat_adresse = :contrat_adresse, contrat_date = :contrat_date, contrat_repartition = :contrat_repartition, contrat_clause_duree = :contrat_clause_duree, contrat_juridiction = :contrat_juridiction, contrat_lieu = :contrat_lieu, contrat_nom_avocat = :contrat_nom_avocat, contrat_date_jour = :contrat_date_jour, contrat_nb_copie = :contrat_nb_copie, contrat_modal_banc = :contrat_modal_banc 
    WHERE contrat_id = :contrat_id AND compte_id = :compte_id");
    
    $stmtUpdate->bindParam(':contrat_nature', $contrat_nature, PDO::PARAM_STR);
    $stmtUpdate->bindParam(':contrat_name', $contrat_name, PDO::PARAM_STR);
    $stmtUpdate->bindParam(':contrat_adresse', $contrat_adresse, PDO::PARAM_STR);
    $stmtUpdate->bindParam(':contrat_date', $contrat_date, PDO::PARAM_STR);
    $stmtUpdate->bindParam(':contrat_repartition', $contrat_repartition, PDO::PARAM_STR);
    $stmtUpdate->bindParam(':contrat_clause_duree', $contrat_clause_duree, PDO::PARAM_STR);
    $stmtUpdate->bindParam(':contrat_juridiction', $contrat_juridiction, PDO::PARAM_STR);
    $stmtUpdate->bindParam(':contrat_lieu', $contrat_lieu, PDO::PARAM_STR);
    $stmtUpdate->bindParam(':contrat_nom_avocat', $contrat_nom_avocat, PDO::PARAM_STR);
    $stmtUpdate->bindParam(':contrat_date_jour', $contrat_date_jour, PDO::PARAM_STR);
    $stmtUpdate->bindParam(':contrat_nb_copie', $contrat_nb_copie, PDO::PARAM_INT);
    $stmtUpdate->bindParam(':contrat_modal_banc', $contrat_modal_banc, PDO::PARAM_STR);
    $stmtUpdate->bindParam(':contrat_id', $contrat_id, PDO::PARAM_INT);
    $stmtUpdate->bindParam(':compte_id', $_SESSION['compte_id'], PDO::PARAM_INT);
    
    if ($stmtUpdate->execute()) {
        echo "<script>alert('Le contrat a été mis à jour avec succès.');</script>";
    } else {
        $errorInfo = $stmtUpdate->errorInfo();
        die("Erreur lors de la mise à jour du contrat : " . $errorInfo[2]);
    }
}
?>




<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Contrat</title>
    <link rel="stylesheet" href="mode.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>
<body class="bg-info-subtle">

    <div class="theme-toggle">
        <button id="theme-toggle-btn" class="btn btn-outline-secondary">
            <span id="icon" class="icon">🌙</span> <!-- Icône de lune par défaut -->
        </button>
    </div>

    <div class="d-flex h-100 justify-content-around align-items-center">
        <form class="w-50" action="edit.php?contrat_id=<?php echo $contrat_id; ?>" method="POST">
            
            <!-- Premier sous-div avec 4 champs -->
            <div id="div1" class="theme-div rounded shadow bg-white p-4">
                <label class="form-label" for="contrat_date_jour">Date du jour</label>
                <input class="form-control mb-3" type="text" id="contrat_date_jour" name="contrat_date_jour" value="<?php echo htmlspecialchars($contrat['contrat_date_jour']); ?>" readonly>

                <label class="form-label" for="contrat_nature">Nature du Contrat</label>
                <input class="form-control mb-3" type="text" id="contrat_nature" name="contrat_nature" value="<?php echo htmlspecialchars($contrat['contrat_nature']); ?>" required>

                <label class="form-label" for="contrat_name">Nom du Contrat</label>
                <input class="form-control mb-3" type="text" id="contrat_name" name="contrat_name" value="<?php echo htmlspecialchars($contrat['contrat_name']); ?>" required>

                <label class="form-label" for="contrat_adresse">Adresse du Contrat</label>
                <input class="form-control mb-3" type="text" id="contrat_adresse" name="contrat_adresse" value="<?php echo htmlspecialchars($contrat['contrat_adresse']); ?>" required>

                <a href="accueil.php" class="btn btn-Dark mb-3">Accueil</a>
                <button type="button" id="btnToDiv2" class="btn btn-secondary mb-3">Suivant</button>
            </div>

            <!-- Deuxième sous-div avec 4 champs -->
            <div id="div2" class="theme-div hidden rounded shadow bg-white p-4">
                <label class="form-label" for="contrat_nb_copie">Nombre de copie</label>
                <input class="form-control mb-3" type="number" id="contrat_nb_copie" name="contrat_nb_copie" value="<?php echo htmlspecialchars($contrat['contrat_nb_copie']); ?>" required>

                <label class="form-label" for="contrat_date">Date du Contrat</label>
                <input class="form-control mb-3" type="date" id="contrat_date" name="contrat_date" value="<?php echo htmlspecialchars($contrat['contrat_date']); ?>" required>

                <label class="form-label" for="contrat_repartition">Répartition</label>
                <input class="form-control mb-3" type="text" id="contrat_repartition" name="contrat_repartition" value="<?php echo htmlspecialchars($contrat['contrat_repartition']); ?>" required>

                <label class="form-label" for="contrat_clause_duree">Durée de la clause de non concurrence</label>
                <input class="form-control mb-3" type="text" id="contrat_clause_duree" name="contrat_clause_duree" value="<?php echo htmlspecialchars($contrat['contrat_clause_duree']); ?>" required>

                <button type="button" id="btnToDiv1" class="btn btn-secondary mb-3">Précédent</button>
                <button type="button" id="btnToDiv3" class="btn btn-secondary mb-3">Suivant</button>
            </div>

            <!-- Troisième sous-div avec 4 champs -->
            <div id="div3" class="theme-div hidden rounded shadow bg-white p-4">
                <label class="form-label" for="contrat_juridiction">Juridiction</label>
                <input class="form-control mb-3" type="text" id="contrat_juridiction" name="contrat_juridiction" value="<?php echo htmlspecialchars($contrat['contrat_juridiction']); ?>" required>

                <label class="form-label" for="contrat_lieu">Lieu</label>
                <input class="form-control mb-3" type="text" id="contrat_lieu" name="contrat_lieu" value="<?php echo htmlspecialchars($contrat['contrat_lieu']); ?>" required>

                <label class="form-label" for="contrat_nom_avocat">Nom de l'Avocat</label>
                <input class="form-control mb-3" type="text" id="contrat_nom_avocat" name="contrat_nom_avocat" value="<?php echo htmlspecialchars($contrat['contrat_nom_avocat']); ?>" required>

                <label class="form-label" for="contrat_modal_banc">Modalités bancaires</label>
                <input class="form-control mb-3" type="number" id="contrat_modal_banc" name="contrat_modal_banc" value="<?php echo htmlspecialchars($contrat['contrat_modal_banc']); ?>" required>

                <button type="button" id="btnToDiv2Back" class="btn btn-secondary mb-3">Précédent</button>
                <button type="submit" class="btn btn-primary mb-3">Soumettre</button>
            </div>  
</div>

    <script>
        // Fonction pour changer de div
        function switchDiv(hideDiv, showDiv) {
            document.getElementById(hideDiv).classList.add('hidden'); // Cache le div actuel
            document.getElementById(showDiv).classList.remove('hidden'); // Affiche le div suivant
        }

        // Gestion des boutons pour naviguer entre les divs
        document.getElementById('btnToDiv2').addEventListener('click', () => {
            switchDiv('div1', 'div2');
        });

        document.getElementById('btnToDiv1').addEventListener('click', () => {
            switchDiv('div2', 'div1');
        });

        document.getElementById('btnToDiv3').addEventListener('click', () => {
            switchDiv('div2', 'div3');
        });

        document.getElementById('btnToDiv2Back').addEventListener('click', () => {
            switchDiv('div3', 'div2');
        });

        // Récupération de la date du jour
        const today = new Date();
        const day = today.getDate().toString().padStart(2, '0');
        const month = (today.getMonth() + 1).toString().padStart(2, '0');
        const year = today.getFullYear();
        const formattedDate = `${day}/${month}/${year}`;
        document.getElementById('contrat_date_jour').value = formattedDate;
    </script>

    <script src="fonction.js"></script>
    <script src="bouton.js"></script>
</body>
</html>
