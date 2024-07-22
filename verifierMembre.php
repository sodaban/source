<?php
// Récupère les valeurs passées en paramètres dans l'URL
$nom = isset($_GET['nom']) ? $_GET['nom'] : '';
$prenom = isset($_GET['prenom']) ? $_GET['prenom'] : '';


// vérifie si le membre existe
error_log("Vérification de l'existence du membre : $nom $prenom");

// Connexion à la base de données SQLite
$db = new SQLite3('petanqueLPP.db');

// Requête pour vérifier si le membre existe
$query = "SELECT COUNT(*) FROM adherents WHERE LOWER(nom) = LOWER(:nom) AND LOWER(prenom) = LOWER(:prenom)";
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

