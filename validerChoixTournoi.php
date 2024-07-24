<?php
// Connexion à la base de données SQLite
$db = new SQLite3('petanqueLPP.db');

// Récupération de l'ID de l'adhérent
$adherent_id = isset($_GET['adherent_id']) ? (int)$_GET['adherent_id'] : 0;

// Récupération des informations de l'adhérent
$adherent = $db->querySingle("SELECT id, nom, prenom FROM adherents WHERE id = $adherent_id", true);

// Récupération des tournois ouverts
$tournois = $db->query("SELECT id, nom, date FROM tournois WHERE etat = 1");

$tournoisList = [];
while ($tournoi = $tournois->fetchArray(SQLITE3_ASSOC)) {
    $tournoisList[] = $tournoi;
}

// Récupération des choix existants des participants
$participant = $db->querySingle("SELECT * FROM participants WHERE adherentId = $adherent_id", true);

// Mise à jour des choix
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tournoiId1 = isset($_POST['tournoiId1']) ? (int)$_POST['tournoiId1'] : null;
    $tournoiId2 = isset($_POST['tournoiId2']) ? (int)$_POST['tournoiId2'] : null;
    $tournoiId3 = isset($_POST['tournoiId3']) ? (int)$_POST['tournoiId3'] : null;
    $tournoiId4 = isset($_POST['tournoiId4']) ? (int)$_POST['tournoiId4'] : null;

    // Mise à jour des participants dans la table participants
    $db->exec("UPDATE participants SET tournoiId1 = $tournoiId1, tournoiId2 = $tournoiId2, tournoiId3 = $tournoiId3, tournoiId4 = $tournoiId4 WHERE adherentId = $adherent_id");

    header("Location: inscrireParticipantsPourTest.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier les Choix des Tournois</title>
</head>
<body>
    <h1>Modifier les Choix des Tournois pour <?php echo $adherent['nom'] . " " . $adherent['prenom']; ?></h1>
    <form method="post">
        <?php foreach ($tournoisList as $tournoi) { 
            $tournoiId = $tournoi['id'];
            $checked = isset($participant["tournoiId$tournoiId"]) && $participant["tournoiId$tournoiId"] ? 'checked' : '';
        ?>
            <div>
                <label>
                    <input type="checkbox" name="tournoiId<?php echo $tournoiId; ?>" value="<?php echo $tournoiId; ?>" <?php echo $checked; ?>>
                    <?php echo $tournoi['nom'] . " (" . $tournoi['date'] . ")"; ?>
                </label>
            </div>
        <?php } ?>
        <button type="submit">Valider</button>
    </form>
</body>
</html>
