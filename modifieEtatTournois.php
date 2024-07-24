<?php
// Connexion à la base de données SQLite
$db = new SQLite3('petanqueLPP.db');

// Vérification de la méthode de requête
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tournoi_id'])) {
    $tournoi_id = (int)$_POST['tournoi_id'];
    $nouvel_etat = (int)$_POST['etat'];

    // Mise à jour de l'état du tournoi
    $db->exec("UPDATE tournois SET etat = $nouvel_etat WHERE id = $tournoi_id");

    echo "L'état du tournoi a été mis à jour avec succès.";
}

// Récupération des tournois
$result = $db->query("SELECT id, nom, date, etat FROM tournois");

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier les Tournois</title>
</head>
<body>
    <h1>Page de modification de l'état (ouvert / fermé) des tournois</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Date</th>
            <th>État</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetchArray(SQLITE3_ASSOC)) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nom']; ?></td>
                <td><?php echo $row['date']; ?></td>
                <td><?php echo $row['etat']; ?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="tournoi_id" value="<?php echo $row['id']; ?>">
                        <select name="etat">
                            <option value="1" <?php echo $row['etat'] == 1 ? 'selected' : ''; ?>>1</option>
                            <option value="0" <?php echo $row['etat'] == 0 ? 'selected' : ''; ?>>0</option>
                        </select>
                        <button type="submit">Modifier</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
