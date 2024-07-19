<?php
// Récupère les valeurs postées
$nom = isset($_POST['nom']) ? $_POST['nom'] : '';
$prenom = isset($_POST['prenom']) ? $_POST['prenom'] : '';

// Connexion à la base de données SQLite
$db = new SQLite3('petanqueLPP.db');

// Requête pour vérifier si le membre existe
$query = "SELECT COUNT(*) FROM adherents WHERE nom = :nom AND prenom = :prenom";
$stmt = $db->prepare($query);
$stmt->bindValue(':nom', $nom, SQLITE3_TEXT);
$stmt->bindValue(':prenom', $prenom, SQLITE3_TEXT);
$result = $stmt->execute();
$row = $result->fetchArray(SQLITE3_ASSOC);

// Crée la réponse JSON
error_log("Membre trouvé : " . $row['COUNT(*)']);
$response = array('membre' => ($row['COUNT(*)'] > 0));

// Définit le type de contenu comme JSON
header('Content-Type: application/json');

// Retourne la réponse au format JSON
echo json_encode($response);
?>

