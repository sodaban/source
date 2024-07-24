<?php
// Connexion à la base de données SQLite
$db = new SQLite3('petanqueLPP.db');

// Récupération des adhérents
$adherents = $db->query("SELECT id, nom, prenom FROM adherents");

// Récupération des tournois ouverts
$tournois = $db->query("SELECT id, nom, date FROM tournois WHERE etat = 1");

$tournoisList = [];
while ($tournoi = $tournois->fetchArray(SQLITE3_ASSOC)) {
    $tournoisList[] = $tournoi;
}

// Récupération des choix existants des participants
$participants = [];
$participantsQuery = $db->query("SELECT * FROM participants");
while ($participant = $participantsQuery->fetchArray(SQLITE3_ASSOC)) {
    $participants[$participant['adherentId']] = $participant;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscrire des Participants</title>
</head>
<body>
    <h1>Inscription des Participants aux Tournois Ouverts</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <?php foreach ($tournoisList as $tournoi) { ?>
                <th><?php echo $tournoi['nom'] . "<br>(" . $tournoi['date'] . ")"; ?></th>
            <?php } ?>
            <th>Action</th>
        </tr>
        <?php while ($adherent = $adherents->fetchArray(SQLITE3_ASSOC)) { ?>
            <tr>
                <td><?php echo $adherent['id']; ?></td>
                <td><?php echo $adherent['nom']; ?></td>
                <td><?php echo $adherent['prenom']; ?></td>
                <?php foreach ($tournoisList as $tournoi) { 
                    $tournoiId = $tournoi['id'];
                    $selected = isset($participants[$adherent['id']]) && $participants[$adherent['id']]["tournoiId$tournoiId"] ? 'Oui' : 'Non';
                ?>
                    <td><?php echo $selected; ?></td>
                <?php } ?>
                <td><a href="validerChoixTournoi.php?adherent_id=<?php echo $adherent['id']; ?>">Modifier</a></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
