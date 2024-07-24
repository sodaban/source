<?php
// Connexion à la base de données SQLite
$db = new SQLite3('petanqueLPP.db');

// Vérification de la méthode de requête pour la mise à jour
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tournoi_id']) && isset($_POST['action']) && $_POST['action'] === 'modifier') {
    $tournoi_id = (int)$_POST['tournoi_id'];
    $nom = $_POST['nom'];
    $date = $_POST['date'];
    $heure = $_POST['heure'];
    $max_joueurs = (int)$_POST['max_joueurs'];
    $type = $_POST['type'];
    $etat = (int)$_POST['etat'];

    // Mise à jour des informations du tournoi
    $db->exec("UPDATE tournois SET nom = '$nom', date = '$date', time = '$heure', nom_joueurs_max = $max_joueurs, type = '$type', etat = $etat WHERE id = $tournoi_id");

    echo "Les informations du tournoi ont été mises à jour avec succès.";
}

// Vérification de la méthode de requête pour la suppression
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tournoi_id']) && isset($_POST['action']) && $_POST['action'] === 'supprimer') {
    $tournoi_id = (int)$_POST['tournoi_id'];

    // Suppression du tournoi
    $db->exec("DELETE FROM tournois WHERE id = $tournoi_id");

    echo "Le tournoi a été supprimé avec succès.";
}

// Récupération des tournois
$result = $db->query("SELECT id, nom, date, time, nom_joueurs_max, type, etat FROM tournois");

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier les Tournois</title>
    <style>
        .small-input {
            width: 50px;
        }
    </style>
</head>
<body>
    <h1>Page de modification ou de suppression des Tournois</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Date</th>
            <th>Heure</th>
            <th>Max Joueurs</th>
            <th>Type</th>
            <th>État</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetchArray(SQLITE3_ASSOC)) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nom']; ?></td>
                <td><?php echo $row['date']; ?></td>
                <td><?php echo $row['time']; ?></td>
                <td><?php echo $row['nom_joueurs_max']; ?></td>
                <td><?php echo $row['type']; ?></td>
                <td><?php echo $row['etat']; ?></td>
                <td>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="tournoi_id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="action" value="modifier">
                        <input type="text" name="nom" value="<?php echo $row['nom']; ?>">
                        <input type="date" name="date" value="<?php echo $row['date']; ?>">
                        <select name="heure">
                            <option value="08:00" <?php echo $row['time'] == '08:00' ? 'selected' : ''; ?>>08:00</option>
                            <option value="09:00" <?php echo $row['time'] == '09:00' ? 'selected' : ''; ?>>09:00</option>
                            <option value="10:00" <?php echo $row['time'] == '10:00' ? 'selected' : ''; ?>>10:00</option>
                            <option value="11:00" <?php echo $row['time'] == '11:00' ? 'selected' : ''; ?>>11:00</option>
                            <option value="12:00" <?php echo $row['time'] == '12:00' ? 'selected' : ''; ?>>12:00</option>
                            <option value="13:00" <?php echo $row['time'] == '13:00' ? 'selected' : ''; ?>>13:00</option>
                            <option value="14:00" <?php echo $row['time'] == '14:00' ? 'selected' : ''; ?>>14:00</option>
                            <option value="15:00" <?php echo $row['time'] == '15:00' ? 'selected' : ''; ?>>15:00</option>
                        </select>
                        <input type="number" name="max_joueurs" value="<?php echo $row['nom_joueurs_max']; ?>" class="small-input">
                        <select name="type">
                            <option value="Doublettes / Formée" <?php echo $row['type'] == 'Doublettes / Formée' ? 'selected' : ''; ?>>Doublettes / Formée</option>
                            <option value="Individuel" <?php echo $row['type'] == 'Individuel' ? 'selected' : ''; ?>>Individuel</option>
                            <option value="Triplettes / Mélée" <?php echo $row['type'] == 'Triplettes / Mélée' ? 'selected' : ''; ?>>Triplettes / Mélée</option>
                            <option value="Triplettes / Formée" <?php echo $row['type'] == 'Triplettes / Formée' ? 'selected' : ''; ?>>Triplettes / Formée</option>
                        </select>
                        <select name="etat">
                            <option value="1" <?php echo $row['etat'] == 1 ? 'selected' : ''; ?>>1</option>
                            <option value="0" <?php echo $row['etat'] == 0 ? 'selected' : ''; ?>>0</option>
                        </select>
                        <button type="submit">Modifier</button>
                    </form>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="tournoi_id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="action" value="supprimer">
                        <button type="submit">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
