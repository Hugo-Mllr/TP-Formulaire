<?php
session_start();
require('BDD.php'); // Connexion à la base de données

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['compte_id'])) {
    header("Location: index.php");
    exit();
}

// Vérifie si le contrat_id est fourni
if (!isset($_GET['contrat_id']) || empty($_GET['contrat_id'])) {
    $_SESSION['alert'] = "Aucun formulaire sélectionné pour suppression.";
    header("Location: accueil.php");
    exit();
}

$contrat_id = intval($_GET['contrat_id']);
$compte_id = intval($_SESSION['compte_id']);

try {
    // Début de la transaction
    $bdd->beginTransaction();

    // Vérifie si le contrat appartient bien à l'utilisateur connecté
    $stmt = $bdd->prepare("SELECT * FROM contrats WHERE contrat_id = :contrat_id AND compte_id = :compte_id");
    $stmt->execute(['contrat_id' => $contrat_id, 'compte_id' => $compte_id]);
    $contrat = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$contrat) {
        $_SESSION['alert'] = "Vous n'êtes pas autorisé à supprimer ce formulaire.";
        $bdd->rollBack();
        header("Location: accueil.php");
        exit();
    }

    // Supprime les enregistrements associés dans contrat_partenaires
    $stmt = $bdd->prepare("DELETE FROM contrat_partenaires WHERE contrat_id = :contrat_id");
    $stmt->execute(['contrat_id' => $contrat_id]);

    // Supprime le contrat lui-même
    $stmt = $bdd->prepare("DELETE FROM contrats WHERE contrat_id = :contrat_id");
    $stmt->execute(['contrat_id' => $contrat_id]);

    // Commit de la transaction
    $bdd->commit();

    $_SESSION['alert'] = "Formulaire supprimé avec succès.";
} catch (Exception $e) {
    // En cas d'erreur, rollback de la transaction
    $bdd->rollBack();
    $_SESSION['alert'] = "Erreur lors de la suppression du formulaire : " . $e->getMessage();
}

// Redirection vers l'accueil
header("Location: accueil.php");
exit();
?>
