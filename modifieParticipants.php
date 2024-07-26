<?php
$db = new SQLite3('petanqueLPP.db');

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $tournoiId1 = isset($_POST['tournoiId1']) ? $_POST['tournoiId1'] : null;
    $tournoiId2 = isset($_POST['tournoiId2']) ? $_POST['tournoiId2'] : null;
    $tournoiId3 = isset($_POST['tournoiId3']) ? $_POST['tournoiId3'] : null;
    $tournoiId4 = isset($_POST['tournoiId4']) ? $_POST['tournoiId4'] : null;

    if (is_null($tournoiId1) && is_null($tournoiId2) && is_null($tournoiId3) && is_null($tournoiId4)) {
        $db->exec("DELETE FROM participants WHERE id='$id'");
    } else {
        $db->exec("UPDATE participants SET tournoiId1='$tournoiId1', tournoiId2='$tournoiId2', tournoiId3='$tournoiId3', tournoiId4='$tournoiId4' WHERE id='$id'");
    }
    header("Location: modifieSupprimeParticipants.php");
}

$id = isset($_GET['id']) ? $_GET['id'] : null;
$result = $db->query("
    SELECT participants.*, adherents.nom, adherents.prenom
    FROM participants
    JOIN adherents ON participants.adherentId = adherents.id
    WHERE participants.id='$id'
");
$row = $result->fetchArray();

$tournois = $db->query("
    SELECT id, nom, date
    FROM tournois
    WHERE etat = 1
");

$tournoisList = [];
while ($tournoi = $tournois->fetchArray()) {
    $tournoisList[] = $tournoi;
}
?>

<form method="post" action="modifieParticipants.php">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    <p>Nom : <?php echo $row['nom']; ?></p>
    <p>Prénom : <?php echo $row['prenom']; ?></p>
    <p>Tournois :</p>
    <ul>
        <?php foreach ($tournoisList as $tournoi): ?>
            <li>
                <input type="checkbox" name="tournoiId<?php echo $tournoi['id']; ?>" value="<?php echo $tournoi['id']; ?>" 
                <?php echo ($row['tournoiId1'] == $tournoi['id'] || $row['tournoiId2'] == $tournoi['id'] || $row['tournoiId3'] == $tournoi['id'] || $row['tournoiId4'] == $tournoi['id']) ? 'checked' : ''; ?>>
                <?php echo $tournoi['nom']; ?> (<?php echo $tournoi['date']; ?>)
            </li>
        <?php endforeach; ?>
    </ul>
    <input type="submit" name="submit" value="Modifier">
</form>
