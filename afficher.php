<?php
session_start();
require_once 'BDD.php';

// Vérifier si un identifiant de contrat est passé en paramètre
if (!isset($_GET['contrat_id'])) {
    die("Aucun formulaire spécifié.");
}

// Récupérer les partenaires
$stmt = $bdd->prepare("SELECT partenaire_id, partenaire_nom, partenaire_prenom FROM partenaires");
$stmt->execute();
$partenaires = $stmt->fetchAll(PDO::FETCH_ASSOC);

$contrat_id = intval($_GET['contrat_id']);

// Récupérer le nom et le prénom de l'utilisateur connecté
if (!isset($_SESSION['nom']) || !isset($_SESSION['prenom'])) {
    // Si les informations ne sont pas dans la session, récupérer via la base de données
    $stmt = $bdd->prepare("
        SELECT c.nom, c.prenom
        FROM compte c
        INNER JOIN contrats ctr ON ctr.compte_id = c.compte_id
        WHERE ctr.contrat_id = ?
    ");
    $stmt->execute([$contrat_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['nom'] = $user['nom'];
        $_SESSION['prenom'] = $user['prenom'];
    } else {
        die("Erreur : utilisateur non trouvé.");
    }
}

$nom = htmlspecialchars($_SESSION['nom']);
$prenom = htmlspecialchars($_SESSION['prenom']);

// Requête pour récupérer les informations du contrat et des partenaires
$sql = "SELECT c.*, cp.partenaire_contribution, p.partenaire_nom, p.partenaire_prenom, comp.nom AS compte_nom, comp.prenom AS compte_prenom
        FROM contrats c
        LEFT JOIN contrat_partenaires cp ON c.contrat_id = cp.contrat_id
        LEFT JOIN partenaires p ON cp.partenaire_id = p.partenaire_id
        LEFT JOIN compte comp ON c.compte_id = comp.compte_id
        WHERE c.contrat_id = ?";
$stmt = $bdd->prepare($sql);
$stmt->execute([$contrat_id]);
$formulaire = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Vérifier si le contrat a été trouvé
if (empty($formulaire)) {
    die("Formulaire introuvable.");
}

// Extraire les informations du contrat
$contrat = $formulaire[0];
$contrat_date_jour = $contrat['contrat_date_jour'] ?? 'Non spécifié';
$contrat_lieu = $contrat['contrat_lieu'] ?? 'Non spécifié';
$contrat_nb_copies = $contrat['contrat_nb_copie'] ?? 0;
$contrat_nature = $contrat['contrat_nature'] ?? 'Non spécifié';
$contrat_name = $contrat['contrat_name'] ?? 'Non spécifié';
$contrat_adresse = $contrat['contrat_adresse'] ?? 'Non spécifié';
$contrat_date = $contrat['contrat_date'] ?? 'Non spécifié';
$contrat_repartition = $contrat['contrat_repartition'] ?? 'Non spécifié';
$contrat_modal_banc = $contrat['contrat_modal_banc'] ?? 'Non spécifié';
$contrat_clause_duree = $contrat['contrat_clause_duree'] ?? 'Non spécifié';
$contrat_juridiction = $contrat['contrat_juridiction'] ?? 'Non spécifié';
$contrat_nom_avocat = $contrat['contrat_nom_avocat'] ?? 'Non spécifié';


// Préparer les informations des partenaires et leurs contributions
$partenaires = [];
foreach ($formulaire as $row) {
    $partenaires[] = [
        'partenaire_nom' => $row['partenaire_nom'],
        'partenaire_prenom' => $row['partenaire_prenom'],
        'partenaire_contribution' => $row['partenaire_contribution']
    ];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrat de Partenariat Commercial</title>
    <link rel="stylesheet" href="afficher.css">
    <style>
        /* Masquer le bouton uniquement lors de l'impression */
        @media print {
            #printButton {
                display: none;
            }
        }
    </style>
<body>
    <h1>CONTRAT DE PARTENARIAT COMMERCIAL</h1>
    
    <button id="printButton">Imprimer cette page</button>
 
    <p>Ce contrat est fait ce jour <strong><?php echo $contrat_date_jour; ?></strong>, à <strong><?php echo $contrat_lieu; ?></strong> en <strong><?php echo $contrat_nb_copies; ?></strong> copies originales, entre</p>
    
    <ul>
        <strong>
            <?php foreach ($partenaires as $partenaire): ?>
                <li>
                    <?php echo htmlspecialchars($partenaire['partenaire_nom']) . ' ' . htmlspecialchars($partenaire['partenaire_prenom']); ?>
                </li>
            <?php endforeach; ?>
        </strong>
    </ul>

    <h2>1. NOM DU PARTENARIAT ET ACTIVITE</h2>
    
    <h3>1.1 Nature des activités:</h3>
    <p>Les Partenaires cités ci-dessus donnent leur accord d'être considérés comme des partenaires commerciaux pour les fins suivantes :</p>
    <p><strong><?php echo $contrat_nature; ?></strong></p>

    <h3>1.2 Nom:</h3>
    <p>Les Partenaires cités ci-dessus donnent leur accord, pour que le partenariat commercial soit exercé sous le nom:</p>
    <p><strong><?php echo $contrat_name; ?></strong></p>

    <h3>1.3 Adresse officielle:</h3>
    <p>Les Partenaires cités ci-dessus donnent leur accord pour que le siège du partenariat commercial soit:</p>
    <p><strong><?php echo $contrat_adresse; ?></strong></p>

    <h2>2. TERMES</h2>
    <p>2.1 Le partenariat commence le <strong><?php echo $contrat_date; ?></strong> et continue jusqu'à la fin de cet accord.</p>

    <h2>3. CONTRIBUTION AU PARTENARIAT</h2>
    <p>3.1 La contribution de chaque partenaire au capital listée ci-dessous se compose des éléments suivants :</p>

    <ul>
        <strong>
            <?php foreach ($partenaires as $partenaire): ?>
                <li>
                    <?php echo htmlspecialchars($partenaire['partenaire_nom']) . ' ' . htmlspecialchars($partenaire['partenaire_prenom']) . ' - Contribution: ' . number_format(htmlspecialchars($partenaire['partenaire_contribution']), 2, ',', ' ') . ' €'; ?>
                </li>
            <?php endforeach; ?>
        </strong>
    </ul>

    <h2>4. RÉPARTITION DES BÉNÉFICES ET DES PERTES</h2>
    <p>4.1 Les Partenaires se partageront les profits et les pertes du partenariat commercial de la manière suivante :</p>
    <p><strong><?php echo $contrat_repartition; ?></strong></p>
    <h2>5. PARTENAIRES ADDITIONNELS</h2>
    <p>5.1 Aucune personne ne peut être ajoutée en tant que partenaire et aucune autre activité ne peut être menée par le partenariat sans le consentement écrit de tous les partenaires.</p>

    <h2>6. MODALITÉS BANCAIRES ET TERMES FINANCIERS</h2>
    <p>6.1 Les Partenaires doivent avoir un compte bancaire au nom du partenariat sur lequel les chèques doivent être signés par au moins <strong><?php echo $contrat_modal_banc; ?></strong> des Partenaires.</p>
    <p>6.2 Les Partenaires doivent tenir une comptabilité complète du partenariat et la rendre disponible à tous les Partenaires à tout moment.</p>

    <h2>7. GESTION DES ACTIVITÉS DE PARTENARIAT</h2>
    <p>7.1 Chaque partenaire peut prendre part dans la gestion du partenariat.</p>
    <p>7.2 Tout désaccord qui intervient dans l'exploitation du partenariat, sera réglé par les partenaires détenant la majorité des parts du partenariat.</p>

    <h2>8. DÉPART D'UN PARTENAIRE COMMERCIAL</h2>
    <p>8.1 Si un partenaire se retire du partenariat commercial pour une raison quelconque, y compris le décès, les autres partenaires peuvent continuer à exploiter le partenariat sous le même nom.</p>
    <p>8.2 Le partenaire qui se retire est tenu de donner un préavis écrit d'au moins soixante (60) jours de son intention de se retirer et est tenu de vendre ses parts du partenariat commercial.</p>

    <h2>9. CLAUSE DE NON CONCURRENCE</h2>
    <p>9.1 Un partenaire qui se retire du partenariat ne doit pas s'engager directement ou indirectement dans une entreprise qui est ou serait en concurrence avec la nature des activités actuelles ou futures du partenariat pendant <?php echo $contrat_clause_duree; ?>.</p>

    <h2>10. MODIFICATION DE L’ACCORD DE PARTENARIAT</h2>
    <p>10.1 Ce contrat de partenariat commercial ne peut être modifié sans le consentement écrit de tous les partenaires.</p>

    <h2>11. DIVERS</h2>
    <p>11.1 Si une disposition ou une partie d'une disposition de la présente convention de partenariat commercial est non applicable pour une quelconque raison, elle sera dissociée sans affecter la validité du reste de la convention.</p>

    <h2>12. JURIDICTION</h2>
    <p>12.1 Le présent contrat de partenariat commercial est régi par les lois de l’État de <strong><?php echo $contrat_juridiction; ?></strong>.</p>

    <h3>Solennellement affirmé à <strong><?php echo $contrat_lieu; ?></strong></h3>
    <p>Daté de ce jour : <strong><?php echo $contrat_date_jour; ?></strong></p>

    <h3>Signé, validé et livré en présence de:</h3>
    <ul>
        <strong>
            <?php foreach ($partenaires as $partenaire): ?>
                <li>
                    <?php echo htmlspecialchars($partenaire['partenaire_nom']) . ' ' . htmlspecialchars($partenaire['partenaire_prenom']); ?>
                </li>
            <?php endforeach; ?>
        </strong>
    </ul>

    <p>Par moi: <strong><?php echo $nom; ?> <?php echo $prenom; ?></strong><br> Avocat : <strong><?php echo $contrat_nom_avocat; ?></strong></p>
    
    <script>
        // Ajouter un écouteur d'événement au bouton
        document.getElementById('printButton').addEventListener('click', function() {
            window.print(); // Appelle la fonction d'impression du navigateur
        });
    </script>
    <script src="fonction.js"></script>
</body>
</html>
