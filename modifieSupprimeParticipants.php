<?php
$db = new SQLite3('petanqueLPP.db');

// Récupérer les tournois ouverts
$tournois = $db->query("
    SELECT id, nom, date
    FROM tournois
    WHERE etat = 1
");

$tournoisList = [];
while ($tournoi = $tournois->fetchArray()) {
    $tournoisList[] = $tournoi;
}

// Construire la requête pour récupérer les participants
$query = "
    SELECT participants.id, adherents.nom, adherents.prenom, 
           participants.tournoiId1, participants.tournoiId2, 
           participants.tournoiId3, participants.tournoiId4
    FROM participants
    JOIN adherents ON participants.adherentId = adherents.id
";

$result = $db->query($query);

echo "<h1>Page de modification ou suppression de tournois</h1>";

echo "<table border='1'>
<tr>
<th>Numéro</th>
<th>Nom</th>
<th>Prénom</th>";

foreach ($tournoisList as $tournoi) {
    echo "<th>" . $tournoi['nom'] . "<br>(" . $tournoi['date'] . ")</th>";
}

echo "<th>Actions</th>
</tr>";

$num = 1;
while ($row = $result->fetchArray()) {
    echo "<tr>";
    echo "<td>" . $num++ . "</td>";
    echo "<td>" . $row['nom'] . "</td>";
    echo "<td>" . $row['prenom'] . "</td>";

    foreach ($tournoisList as $tournoi) {
        $tournoiId = $tournoi['id'];
        $isParticipant = ($row['tournoiId1'] == $tournoiId || $row['tournoiId2'] == $tournoiId || $row['tournoiId3'] == $tournoiId || $row['tournoiId4'] == $tournoiId);
        echo "<td>" . ($isParticipant ? "Oui" : "Non") . "</td>";
    }

    echo "<td>
            <a href='modifieParticipants.php?id=" . $row['id'] . "'>Modifier</a> |
            <a href='supprimeParticipants.php?id=" . $row['id'] . "'>Supprimer</a>
          </td>";
    echo "</tr>";
}
echo "</table>";
?>
