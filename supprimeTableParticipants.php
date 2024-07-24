<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
        // Connexion à la base de données SQLite
        $db = new SQLite3('petanqueLPP.db');

        // Suppression de la table participants
        $db->exec("DROP TABLE IF EXISTS participants");

        // Recréation de la table participants vide
        $db->exec("CREATE TABLE participants (
            id INTEGER PRIMARY KEY,
            adherentId INTEGER,
            tournoiId1 INTEGER,
            tournoiId2 INTEGER,
            tournoiId3 INTEGER,
            tournoiId4 INTEGER
        )");

        echo "La table 'participants' a été supprimée et recréée avec succès.";
    } else {
        echo "La suppression de la table 'participants' a été annulée.";
    }
} else {
?>
    <form method="post">
        <h1>Page de suppression de la table des participants</h1>
        <p>Voulez-vous vraiment supprimer la table 'participants' ?</p>
        <button type="submit" name="confirm" value="yes">Oui</button>
        <button type="submit" name="confirm" value="no">Non</button>
    </form>
<?php
}
?>
