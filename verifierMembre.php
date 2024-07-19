<?php
header('Content-Type: application/json');

// vérifier si le participant fait partie du membre du club
$nom = isset($_POST['nom']) ? $_POST['nom'] : 0;
$prenom = isset($_POST['prenom']) ? $_POST['prenom'] : 0;
$tournoiId1 = isset($_POST['tournoiId1']) ? $_POST['tournoiId1'] : 0;
$tournoiId2 = isset($_POST['tournoiId2']) ? $_POST['tournoiId2'] : 0;
$tournoiId3 = isset($_POST['tournoiId3']) ? $_POST['tournoiId3'] : 0;
$tournoiId4 = isset($_POST['tournoiId4']) ? $_POST['tournoiId4'] : 0;
$db = new SQLite3('petanqueLPP.db');
$db->exec("CREATE TABLE IF NOT EXISTS adherents (id INTEGER PRIMARY KEY, nom TEXT, prenom TEXT, email TEXT, date_inscription TEXT, matricule INTEGER)");
$db->exec("CREATE TABLE IF NOT EXISTS tournois (id INTEGER PRIMARY KEY, nom TEXT, date TEXT, time TEXT, nom_joueurs_max INT, type TEXT, etat INTEGER)");
$db->exec("CREATE TABLE IF NOT EXISTS participants (id INTEGER PRIMARY KEY, adherentId INTEGER, tournoiId1 INTEGER, tournoiId2 INTEGER, tournoiId3 INTEGER, tournoiId4 INTEGER)");
$query = "SELECT COUNT(*) FROM adherents WHERE nom = '$nom' AND prenom = '$prenom'";
$result = $db->query($query);
$row = $result->fetchArray(SQLITE3_ASSOC);
$count = $row['count'];
$response = array('membre' => true);

if ($count == 0) {
    $response['membre'] = false;
} else {
    $response['membre'] = true;
}

echo json_encode($response);
