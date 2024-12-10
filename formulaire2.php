<?php
session_start();
require('BDD.php'); // Connexion à la base de données

// Récupérer les partenaires
$stmt = $bdd->prepare("SELECT partenaire_id, partenaire_nom, partenaire_prenom FROM partenaires");
$stmt->execute();
$partenaires = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Traitement des données du formulaire lorsque la méthode POST est utilisée
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
    $compte_id = $_SESSION['compte_id']; // ID de l'utilisateur connecté

    try {
        // Préparer l'insertion dans la table `contrats`
        $stmtContrat = $bdd->prepare( "INSERT INTO contrats 
            (compte_id, contrat_nature, contrat_name, contrat_adresse, contrat_date, contrat_repartition, 
            contrat_clause_duree, contrat_juridiction, contrat_lieu, contrat_nom_avocat, contrat_date_jour, contrat_nb_copie, contrat_modal_banc) 
            VALUES 
            (:compte_id, :contrat_nature, :contrat_name, :contrat_adresse, :contrat_date, :contrat_repartition, 
            :contrat_clause_duree, :contrat_juridiction, :contrat_lieu, :contrat_nom_avocat, :contrat_date_jour, :contrat_nb_copie, :contrat_modal_banc)");
        
        $stmtContrat->execute([
            ':compte_id' => $compte_id,
            ':contrat_nature' => $contrat_nature,
            ':contrat_name' => $contrat_name,
            ':contrat_adresse' => $contrat_adresse,
            ':contrat_date' => $contrat_date,
            ':contrat_repartition' => $contrat_repartition,
            ':contrat_clause_duree' => $contrat_clause_duree,
            ':contrat_juridiction' => $contrat_juridiction,
            ':contrat_lieu' => $contrat_lieu,
            ':contrat_nom_avocat' => $contrat_nom_avocat,
            ':contrat_date_jour' => $contrat_date_jour, 
            ':contrat_nb_copie' => $contrat_nb_copie,    
            ':contrat_modal_banc' => $contrat_modal_banc
        ]);

        // Récupérer l'ID du contrat nouvellement inséré
        $contrat_id = $bdd->lastInsertId();

        // Traiter chaque partenaire soumis
        $nbPartenaires = $_SESSION['nb_partenaires'];
        $stmtPartenaire = $bdd->prepare("INSERT INTO contrat_partenaires (contrat_id, partenaire_id, partenaire_contribution) 
                                         VALUES (:contrat_id, :partenaire_id, :partenaire_contribution)");
        
        for ($i = 0; $i < $nbPartenaires; $i++) {
            $partenaire_id = $_POST["partenaire_nom_$i"] ?? null; // ID du partenaire
            $partenaire_contribution = $_POST["contribution_$i"] ?? null; // Contribution du partenaire

            if ($partenaire_id && $partenaire_contribution) {
                $stmtPartenaire->execute([
                    ':contrat_id' => $contrat_id,
                    ':partenaire_id' => $partenaire_id,
                    ':partenaire_contribution' => $partenaire_contribution
                ]);
            }
        }

        // Définir un message d'alerte dans la session
        $_SESSION['alert'] = "Formulaire envoyé avec succès !";

        // Redirection après l'enregistrement réussi
        header("Location: accueil.php");
        exit();
    } catch (PDOException $e) {
        // Gérer les erreurs de connexion ou d'insertion
        echo "Erreur : " . $e->getMessage();
    }
}
?>



<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire2</title>
    <link rel="stylesheet" href="form.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .hidden {
        display: none;
    }
    </style>
    <link rel="stylesheet" href="mode.css">
</head>
<body class="bg-info-subtle text-light-mode">

    <div class="theme-toggle">
        <button id="theme-toggle-btn" class="btn btn-outline-secondary">
            <span id="icon" class="icon">🌙</span> <!-- Icône de lune par défaut -->
        </button>
    </div>

    <div class="d-flex h-100 justify-content-around align-items-center">
        <form class="w-25 rounded" action="formulaire2.php" method="POST">
             <!-- Premier sous-div avec 3 champs -->
            <div id="div1" class="theme-div rounded shadow bg-white p-4 text-light-mode">
                <label class="form-label" for="contrat_date_jour">Date du jour</label>
                <input class="form-control mb-3" type="text" id="contrat_date_jour" name="contrat_date_jour" readonly>

                <label class="form-label" for="contrat_nature">Nature du Contrat</label>
                <input class="form-control mb-3" type="text" id="contrat_nature" name="contrat_nature" required>

                <label class="form-label" for="contrat_name">Nom du Contrat</label>
                <input class="form-control mb-3" type="text" id="contrat_name" name="contrat_name" required>

                <label class="form-label" for="contrat_adresse">Adresse du Contrat</label>
                <input class="form-control mb-3" type="text" id="contrat_adresse" name="contrat_adresse" required>

                <a href="formulaire1.php" class="btn btn-dark mb-3">Retour</a>
                <button type="button" id="btnToDiv2" class="btn btn-secondary mb-3">Suivant</button>
            </div>

            <!-- Deuxième sous-div avec 3 champs -->
            <div id="div2" class="theme-div hidden rounded shadow bg-white p-4 text-light-mode">
                <label class="form-label" for="contrat_nb_copie">Nombre de copie</label>
                <input class="form-control mb-3" type="number" id="contrat_nb_copie" name="contrat_nb_copie" required>

                <label class="form-label" for="contrat_date">Date du Contrat</label>
                <input class="form-control mb-3" type="date" id="contrat_date" name="contrat_date" required>

                <label class="form-label" for="contrat_repartition">Répartition</label>
                <input class="form-control mb-3" type="text" id="contrat_repartition" name="contrat_repartition" required>

                <label class="form-label" for="contrat_clause_duree">Durée de la clause de non concurrence</label>
                <input class="form-control mb-3" type="text" id="contrat_clause_duree" name="contrat_clause_duree" required>

                <button type="button" id="btnToDiv1" class="btn btn-secondary mb-3">Précédent</button>
                <button type="button" id="btnToDiv3" class="btn btn-secondary mb-3">Suivant</button>
            </div>

            <!-- Troisième sous-div avec 4 champs -->
            <div id="div3" class="theme-div hidden rounded shadow bg-white p-4 text-light-mode">
                <label class="form-label" for="contrat_juridiction">Juridiction</label>
                <input class="form-control mb-3" type="text" id="contrat_juridiction" name="contrat_juridiction" required>

                <label class="form-label" for="contrat_lieu">Lieu</label>
                <input class="form-control mb-3" type="text" id="contrat_lieu" name="contrat_lieu" required>

                <label class="form-label" for="contrat_nom_avocat">Nom de l'Avocat</label>
                <input class="form-control mb-3" type="text" id="contrat_nom_avocat" name="contrat_nom_avocat" required>

                <label class="form-label" for="contrat_modal_banc">Modalités bancaires</label>
                <input class="form-control mb-3" type="number" id="contrat_modal_banc" name="contrat_modal_banc" required>

                <button type="button" id="btnToDiv2Back" class="btn btn-secondary mb-3">Précédent</button>
                <button type="button" id="btnToDiv4" class="btn btn-secondary mb-3">Suivant</button>
            </div>

            <!-- Quatrième sous-div avec les infos des partenaires -->
            <div id="div4" class="theme-div hidden rounded shadow bg-white p-4 text-light-mode">
                <?php for ($i = 0; $i < $_SESSION['nb_partenaires']; $i++): ?>
                    <div class="mb-3">
                        <label for="partenaire_nom_<?php echo $i; ?>">Nom du partenaire <?php echo $i + 1; ?></label>
                        <select class="form-select mb-3" name="partenaire_nom_<?php echo $i; ?>" required>
                            <?php foreach ($partenaires as $partenaire): ?>
                                <option value="<?php echo $partenaire['partenaire_id']; ?>">
                                    <?php echo htmlspecialchars($partenaire['partenaire_nom'] . " " . $partenaire['partenaire_prenom']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <label for="contribution_<?php echo $i; ?>">Contribution du partenaire <?php echo $i + 1; ?></label>
                        <input type="number" class="form-control" id="contribution_<?php echo $i; ?>" name="contribution_<?php echo $i; ?>" required>
                    </div>
                <?php endfor; ?>
                <button type="button" id="btnToDiv3Back" class="btn btn-secondary mb-3">Précédent</button>
                <button type="submit" class="btn btn-primary mb-3">Soumettre</button>
            </div>
        </form>
    </div>
    <script>
        // Fonction pour changer de div
        function switchDiv(hideDiv, showDiv) {
            document.getElementById(hideDiv).classList.add('hidden'); // Cache le div actuel
            document.getElementById(showDiv).classList.remove('hidden'); // Montre le div suivant
        }

        // Boutons pour naviguer entre les divs
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

        document.getElementById('btnToDiv4').addEventListener('click', () => {
            switchDiv('div3', 'div4');
        });

        document.getElementById('btnToDiv3Back').addEventListener('click', () => {
            switchDiv('div4', 'div3');
        });

    </script>
    <script src="fonction.js"></script>
    <script src="bouton.js"></script>
</body>
</html>

