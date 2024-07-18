<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
	        /* Style pour le fond de la page */
        body {
            background-color: black;
            color: white; /* Couleur du texte */
            text-align: center; /* Centrer le contenu */
        }
        /* Style pour l'effet d'impulsion */
        .icone {
            font-size: 24px;
            transition: transform 0.2s ease-in-out;
			display: inline-block;
        }
        .icone:hover {
            animation: pulse 0.5s alternate 3; /* Ajout de cette ligne */
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
            /* Style pour l'icône 9 */
        .icone9 img {
        max-height: 190px; /* Ajustez la hauteur selon vos besoins */
        max-width: 190px;  /* Ajustez la largeur selon vos besoins */
        margin-left: 15px;
        margin-bottom: -22px;
    }
        /* Style pour les nouveaux logos */
        .nouveaux-logos {
            display: flex;
            justify-content: center;
            align-items: center;
			margin-top: 80px; /* Ajoutez cette ligne pour augmenter l'espace entre les lignes */
        }
        .nouveaux-logos img {
            max-height: 160px; /* Ajustez la hauteur selon vos besoins */
            margin: 0 60px; /* Espacement entre les logos */
        }
    </style>

</head>
<body>
	<?php
    // Liens à exécuter (remplacez par vos propres URLs)
    $lien1 = 'https://lespétanquistesputeaux.com';
    $lien2 = 'https://lespétanquistesputeaux.com/A-propos/';
    $lien3 = 'https://lespétanquistesputeaux.com/Charte/';
    $lien4 = 'https://lespétanquistesputeaux.com/Contacts/';
    $lien5 = 'https://lespétanquistesputeaux.com/Tournois/';
    $lien6 = 'https://lespétanquistesputeaux.com/Liste-Partenaires/';
    $lien7 = 'https://lespétanquistesputeaux.com/INFOS/';
    $lien8 = 'https://lespétanquistesputeaux.com/LES/';
    $lien9 = 'https://lespétanquistesputeaux.com/SPONSORS/';


    // Icônes (remplacez par les icônes de votre choix)
    $icone1 = '<a href="' . $lien1 . '"><i class="icone"><img src="../images/accueilUrl.jpg" alt="Icône1"></i></a>';
    $icone2 = '<a href="' . $lien2 . '"><i class="icone"><img src="../images/aproposUrl.jpg" alt="Icône2"></i></a>';
    $icone3 = '<a href="' . $lien3 . '"><i class="icone"><img src="../images/charteUrl.png" alt="Icône3"></i></a>';
    $icone4 = '<a href="' . $lien4 . '"><i class="icone"><img src="../images/contactUrl.jpg" alt="Icône4"></i></a>';
    $icone5 = '<a href="' . $lien5 . '"><i class="icone"><img src="../images/tournoisUrl.jpg" alt="Icône5"></i></a>';
    $icone6 = '<a href="' . $lien6 . '"><i class="icone"><img src="../images/partenairesUrl.png" alt="Icône6"></i></a>';
    $icone7 = '<a href="' . $lien7 . '"><i class="icone"><img src="../images/infosUrl.jpg" alt="Icône7"></i></a>';
    $icone8 = '<a href="' . $lien8 . '"><i class="icone"><img src="../images/lesplusUrl.gif" alt="Icône8"></i></a>';
    // $icone9 = '<a href="' . $lien9 . '"><i class="icone"><img src="../images/sponsorsUrl.jpg" alt="Icône"></i></a>';
    
    // Icône 9 avec la classe spécifique
    $icone9 = '<a href="' . $lien9 . '"><i class="icone icone9"><img src="../images/sponsorsUrl.jpg" alt="Icône9"></i></a>';

    
    // Nouveaux logos (ajoutés en dessous)
    $tournoidepetanqueLogo = '<img src="../images/tournoisdepetanque.png" alt="Logo1">';
    $lappointmerci = '<img src="../images/lappointmerci.png" alt="Logo2">';
	
    // Affichage des icônes avec les liens
    echo $icone1 . $icone2 . $icone3 . $icone4 . $icone5 . $icone6 . $icone7 . $icone8 . $icone9;
	echo '<br>'; // Saut de ligne
	
	    // Affichage des nouveaux logos
    echo '<div class="nouveaux-logos">' . $tournoidepetanqueLogo . $lappointmerci . '</div>';
    ?>


	<!-- Texte sous les logos -->
    <p style="font-size: 25px; margin-top: 50px; margin-bottom: 50px">
        Les inscriptions aux tournois sont strictement réservées aux adhérents inscrits pour la saison en cours.
    </p>
    
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
            border: 1px solid white; /* Ajoutez cette ligne pour définir la couleur de la bordure */
            text-align: center; /* Centrer les champs de données */
        }
            a:link, a:visited { /* Couleur des liens */
            color: #ADD8E6;
        }
        .blue-button {
            background-color: #008CBA;
            color: white;
            padding: 10px 20px; /* Increase the padding to make the button larger */
            font-size: 18px; /* Increase the font size to make the button text larger */
        }
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
    echo "<p style='text-align: center; font-size: 25px;'><a href='https://lespétanquistesputeaux.com/gallery/CALENDRIER%20DES%20RENCONTRES%202025%20SITE.pdf'>Calendrier des rencontres 2025</a></p>";

    
// création d'un bouton pour revenir à la page d'accueil
echo '<a href="formulaireInscription.php" class="blue-button">Pour s\'incrire</a>';
?>


</body>
</html>

