<?php
// Connexion à la base de données SQLite
try {
    $db = new PDO('sqlite:petanqueLPP.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    die();
}

// Requête pour récupérer les tournois ouverts (état = 1)
$result = $db->query("SELECT * FROM tournois WHERE etat = 1");

// Ajout du style pour centrer le tableau
echo "<style>
        table {
            margin-left: auto;
            margin-right: auto;
            border-collapse: collapse;
        }
     th, td {
            padding: 10px;
            border: 1px solid black;
            text-align: center; /* Centrer les champs de données */
        }
      </style>";

// Affichage des tournois dans un tableau avec un numéro calculé
echo "<table>";
echo "<tr><th>N°</th><th>Date</th><th>Heure</th><th>Nom du tournoi</th><th>Nombre Max de joueurs autorisés</th><th>Type</th><th>Inscrits</th></tr>";
$numero = 1;
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    // Requête pour compter le nombre d'inscrits pour ce tournoi
    $query = "SELECT COUNT(*) FROM participants WHERE (tournoiId1 = {$row['id']} OR tournoiId2 = {$row['id']} OR tournoiId3 = {$row['id']} OR tournoiId4 = {$row['id']})";
    $count = $db->query($query)->fetchColumn();

    echo "<tr>";
    echo "<td>{$numero}</td>";
    echo "<td>{$row['date']}</td>";
    echo "<td>{$row['time']}</td>";
    echo "<td>{$row['nom']}</td>";
    echo "<td>{$row['nom_joueurs_max']}</td>";
    echo "<td>{$row['type']}</td>";
    echo "<td>{$count}</td>"; // Affiche le nombre d'inscrits
    echo "</tr>";
    $numero++;
}
echo "</table>";

// Fermeture de la connexion
$db = null;

// Ajout des liens en bas de la page avec une taille de police de 25 et centrés
echo "<p style='text-align: center; font-size: 25px;'><a href='https://lespétanquistesputeaux.com/Calendrier'>Calendrier des rencontres 2024</a></p>";
echo "<p style='text-align: center; font-size: 25px;'><a href='https://lespétanquistesputeaux.com/gallery/CALENDRIER%20DES%20RENCONTRES%202025%20SITE.pdf'>Calendrier des rencontres 2024</a></p>";
?>
