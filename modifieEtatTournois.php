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
    <script>
        function updateTournoi(tournoi_id) {
            var etat = document.getElementById('etat_' + tournoi_id).value;
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log(xhr.responseText);
                    // Mettre à jour l'affichage de l'état
                    document.querySelector(`#etat_${tournoi_id}`).closest('tr').querySelector('td:nth-child(4)').innerText = etat;
                }
            };
            xhr.send('tournoi_id=' + tournoi_id + '&etat=' + etat);
        }
    </script>
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
        <?php
        // Initialize the $db variable with a valid database connection object
        $db = new SQLite3('petanqueLPP.db');
        
        // Récupération des tournois
        $result = $db->query("SELECT id, nom, date, etat FROM tournois");
        if ($result !== false) {
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nom']; ?></td>
                    <td><?php echo $row['date']; ?></td>
                    <td><?php echo $row['etat']; ?></td>
                    <td>
                        <select id="etat_<?php echo $row['id']; ?>" name="etat">
                            <option value="1" <?php echo $row['etat'] == 1 ? 'selected' : ''; ?>>1</option>
                            <option value="0" <?php echo $row['etat'] == 0 ? 'selected' : ''; ?>>0</option>
                        </select>
                        <button type="button" onclick="updateTournoi(<?php echo $row['id']; ?>)">Modifier</button>
                    </td>
                </tr>
        <?php }
        } else {
            echo "Une erreur s'est produite lors de l'exécution de la requête.";
        }
        ?>
    </table>
</body>

</html>
